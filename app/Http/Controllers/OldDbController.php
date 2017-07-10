<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\databank;
use App\visaprocess;
use App\vrflown;

class OldDbController extends Controller
{
    public function databank(Request $request)
    {
        if (\Auth::user()) {
            $sel="";
            $search="";

            $gp_array=['Ref_No', 'Date', 'Candidates_Name', 'Contact_No', 'DOB', 'PP_NO', 'PP_Status', 'LA_Contact', 'LA',
                'Trade', 'Company', 'Status', 'Offer_Letter_Received_Date', 'Old_VP_Date', 'Remarks', 'PP_Returned_Date',
                'PP_Resubmitted_Date', 'State','created_at','updated_at'];
            $pg_array=['Ref_No', 'Date', 'Candidates_Name', 'Contact_No', 'DOB', 'PP_NO', 'PP_Status', 'LA_Contact', 'LA',
                'Trade', 'Company', 'Status', 'Offer_Letter_Received_Date', 'Old_VP_Date', 'Remarks', 'PP_Returned_Date',
                'PP_Resubmitted_Date', 'State'];

            if (!empty($request->all()) && $request->sel!="" && $request->search!="") {
                $sel=$request->sel;
                $search=$request->search;
                $datas = databank::where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('Ref_No', 'desc')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
            } else {
                $datas = databank::orderBy('Ref_No', 'desc')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
            }
            $cols = \Schema::getColumnListing('databanks');
            $db_table = "databanks";
            return view('joins.databank', compact('cols', 'datas', 'db_table','sel','search'));
        }
        else
        {
            return redirect('/');
        }
    }

    public function visa(Request $request)
    {
        if(\Auth::user())
        {
            $sel="";
            $search="";

            $gp_array=['Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','PP_Status','LA_Contact','LA',
                'Trade','Company','Status','Offer_Letter_Received_Date','Process_Date','Status','PP_Returned_Date',
                'PP_Resubmitted_Date','State_Vp','created_at','updated_at'];
            $pg_array=['Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','PP_Status','LA_Contact','LA',
                'Trade','Company','Status','Offer_Letter_Received_Date','Process_Date','Status','PP_Returned_Date',
                'PP_Resubmitted_Date','State_Vp'];

            if (!empty($request->all()) && $request->sel!="" && $request->search!="") {
                $sel=$request->sel;
                $search=$request->search;
                $datas=visaprocess::where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('Ref_No','desc')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
            }
            else{
                $datas=visaprocess::orderBy('Ref_No','desc')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
            }
            $cols=\Schema::getColumnListing('visaprocesses');

//
            $db_table="visaprocesses";

            return view('joins.visa',compact('cols','datas','db_table','sel','search'));
        }else
        {
            return redirect('/');
        }

    }

    public function deployment(Request $request)
    {
        if(\Auth::user())
        {
            $sel="";
            $search="";

            $gp_array=['Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','PP_Status','LA_Contact','LA',
                'Trade','Company','Status','WP_Expiry','Offer_Letter_Received_Date','VP_Date','VR_Date','Visa_Issue_Date','Visa_Exp','SA','Flown_Date','PP_Returned_Date',
                'PP_Resubmitted_Date','Demand_No','Visa_No','created_at','updated_at'];
            $pg_array=['Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','PP_Status','LA_Contact','LA',
                'Trade','Company','Status','WP_Expiry','Offer_Letter_Received_Date','VP_Date','VR_Date','Visa_Issue_Date','Visa_Exp','SA','Flown_Date','PP_Returned_Date',
                'PP_Resubmitted_Date','Demand_No','Visa_No'];

            if (!empty($request->all()) && $request->sel!="" && $request->search!="") {
                $sel = $request->sel;
                $search = $request->search;
                $datas = vrflown::where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('Ref_No','desc')
                    ->groupBy($gp_array)
                    ->paginate(20, $pg_array);
            }
            else{
                $datas=vrflown::orderBy('Ref_No','desc')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
            }
            $cols=\Schema::getColumnListing('vrflowns');
            $db_table="visaprocesses";

            return view('joins.deployment',compact('cols','datas','db_table','sel','search'));
        }else
        {
            return redirect('/');
        }

    }
}
