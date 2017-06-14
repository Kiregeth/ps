<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\visitor_log;
use App\databank;

class SysController extends Controller
{
    public function index()
    {
        if(\Auth::user())
        {
            return redirect('/dashboard');
        }else
        {
            return $this->login();
        }

    }

    public function login()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        if(\Auth::user())
        {
            return view('joins.dashboard');
        }else
        {
            return redirect('/');
        }

    }

    public function visitor_log()
    {
        if(\Auth::user())
        {
            $cols=\Schema::getColumnListing('visitor_logs');
            $logs=visitor_log::orderBy('sn','desc')
                ->groupBy('sn')
                ->groupBy('visitor_name')
                ->groupBy('contact_no')
                ->groupBy('visit_purpose')
                ->groupBy('remarks')
                ->groupBy('time')
                ->groupBy('created_at')
                ->groupBy('updated_at')
                ->get(['sn','visitor_name','contact_no','visit_purpose','remarks','time']);
            $db_table="visitor_logs";
            return view('joins.visitor_log',compact('cols','logs','db_table'));
        }else
        {
            return redirect('/');
        }

    }

    public function databank()
    {
        if(\Auth::user())
        {
            $cols=\Schema::getColumnListing('databanks');
            $datas=databank::orderBy('Ref_No','desc')
                ->groupBy('Ref_No')
                ->groupBy('Date')
                ->groupBy('Candidates_Name')
                ->groupBy('Contact_No')
                ->groupBy('DOB')
                ->groupBy('PP_NO')
                ->groupBy('PP_Status')
                ->groupBy('LA_Contact')
                ->groupBy('LA')
                ->groupBy('Trade')
                ->groupBy('Company')
                ->groupBy('Status')
                ->groupBy('Offer_Letter_Received_Date')
                ->groupBy('Old_VP_Date')
                ->groupBy('Remarks')
                ->groupBy('PP_Returned_Date')
                ->groupBy('PP_Resubmitted_Date')
                ->groupBy('State')
                ->groupBy('created_at')
                ->groupBy('updated_at')
                ->get([
                    'Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','PP_Status','LA_Contact','LA',
                    'Trade','Company','Status','Offer_Letter_Received_Date','Old_VP_Date','Remarks','PP_Returned_Date',
                    'PP_Resubmitted_Date','State'
                    ]);
            $db_table="databanks";
            return view('joins.databank',compact('cols','datas','db_table'));
        }else
        {
            return redirect('/');
        }

    }

    public function add(Request $request)
    {
        switch ($request->db_table)
        {
            case 'visitor_logs':
                $pasa=new visitor_log;
                $discard=['_token','sn','db_table','add','created_at','updated_at'];
                break;
            case 'databanks':
                $pasa=new databank;
                $discard=['_token','db_table','add','state','created_at','updated_at'];
                break;
            default:
                $pasa=new visitor_log;
                $discard=[];
                break;
        }

        $cols=\Schema::getColumnListing($request->db_table);
        foreach($request->all() as $key=>$value)
        {
            echo $key;
            if(in_array($key,$cols) && !in_array($key,$discard))
            {
                $pasa->$key=$value;
            }
        }
        $pasa->save();
        return back();
    }

    public function delete(Request $request)
    {
        $value=$request->db_table;
        echo $value;
        exit;
        \DB::table($db_table)->where('Ref_No', $Ref_No)->delete();
        return back();
    }
}
