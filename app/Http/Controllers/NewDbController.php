<?php

namespace App\Http\Controllers;

use App\databank;
use Illuminate\Http\Request;
use App\db_remark;
use App\new_databank;


class NewDbController extends Controller
{
    public function new_databank(Request $request)
    {
        if (\Auth::user()) {
            $sel = "";
            $search = "";
            if($request->page_size !=null && $request->page_size !="")
            {
                $limit=intval($request->page_size);
            }
            else
            {
                $limit=20;
            }
//        $app_cols=\Schema::getColumnListing('app_forms');
//        $db_cols=\Schema::getColumnListing('new_databanks');

            if (!empty($request->all()) && $request->sel != "" && $request->search != "") {

                $sel = $request->sel;
                if ($sel === 'ref_no') {
                    $sel = 'new_databanks.' . $sel;
                }
                $search = $request->search;
                $datas = new_databank::where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('new_databanks.ref_no', 'desc')
                    ->paginate($limit);

            } else {
                $datas = new_databank::orderBy('new_databanks.ref_no', 'desc')
                    ->paginate($limit);
            }

            $db_table = 'new_databanks';
            $remarks = db_remark::orderBy('time', 'desc')->get(['ref_no','remark_id','remark','user','time']);

            return view("joins.new_databank", compact('db_table', 'sel', 'search','limit', 'datas','remarks'));
        }
        else
        {
            return redirect('/');
        }
    }

    function new_visa(Request $request)
    {
        if (\Auth::user()) {
            $sel = "";
            $search = "";
            if($request->page_size !=null && $request->page_size !="")
            {
                $limit=intval($request->page_size);
            }
            else
            {
                $limit=20;
            }

//        $app_cols=\Schema::getColumnListing('app_forms');
//        $db_cols=\Schema::getColumnListing('new_databanks');
            if (!empty($request->all()) && $request->sel != "" && $request->search != "") {
                $sel = $request->sel;
                if ($sel === 'ref_no' || $sel==='date') {
                    $sel = 'new_visa_processes.' . $sel;
                }
                $search = $request->search;
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('new_visa_processes.ref_no', 'desc')
                    ->paginate($limit);

            } else {
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->orderBy('new_visa_processes.ref_no', 'desc')
                    ->paginate($limit);
            }
            $remarks = db_remark::orderBy('time', 'desc')->get(['ref_no','remark_id','remark','user','time']);
            $db_table = 'new_visa_processes';

            return view("joins.new_visa", compact('db_table', 'sel', 'search', 'limit', 'datas','remarks'));
        }
        else
        {
            return redirect('/');
        }
    }

    function new_visa_receive(Request $request)
    {
        if (\Auth::user()) {
            $sel = "";
            $search = "";
            if($request->page_size !=null && $request->page_size !="")
            {
                $limit=intval($request->page_size);
            }
            else
            {
                $limit=20;
            }
//        $app_cols=\Schema::getColumnListing('app_forms');
//        $db_cols=\Schema::getColumnListing('new_databanks');
            if (!empty($request->all()) && $request->sel != "" && $request->search != "") {
                $sel = $request->sel;
                if ($sel === 'ref_no' || $sel==='date') {
                    $sel = 'new_visa_receives.' . $sel;
                }
                $search = $request->search;
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_visa_receives','new_databanks.ref_no', '=', 'new_visa_receives.ref_no')
                    ->where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('new_visa_receives.ref_no', 'desc')
                    ->paginate($limit);

            } else {
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_visa_receives','new_databanks.ref_no', '=', 'new_visa_receives.ref_no')
                    ->orderBy('new_visa_receives.ref_no', 'desc')
                    ->paginate($limit);
            }

            $remarks = db_remark::orderBy('time', 'desc')->get(['ref_no','remark_id','remark','user','time']);
            $db_table = 'new_visa_receives';

            return view("joins.new_visa_receive", compact('db_table', 'sel', 'search', 'limit', 'datas','remarks'));
        }
        else
        {
            return redirect('/');
        }
    }

    function new_deployment(Request $request)
    {
        if (\Auth::user()) {
            $sel = "";
            $search = "";
            if($request->page_size !=null && $request->page_size !="")
            {
                $limit=intval($request->page_size);
            }
            else
            {
                $limit=20;
            }
            if (!empty($request->all()) && $request->sel != "" && $request->search != "") {
                $sel = $request->sel;
                if ($sel === 'ref_no' || $sel==='date') {
                    $sel = 'new_vr_flowns.' . $sel;
                }
                $search = $request->search;
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_visa_receives','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_vr_flowns','new_databanks.ref_no', '=', 'new_vr_flowns.ref_no')
                    ->where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('new_vr_flowns.ref_no', 'desc')
                    ->paginate($limit);

            } else {
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_visa_receives','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_vr_flowns','new_databanks.ref_no', '=', 'new_vr_flowns.ref_no')
                    ->orderBy('new_vr_flowns.ref_no', 'desc')
                    ->paginate($limit);
//                return $datas;
            }

            $remarks = db_remark::orderBy('time', 'desc')->get(['ref_no','remark_id','remark','user','time']);
            $db_table = 'new_vr_flowns';
            return view("joins.new_deployment", compact('db_table', 'sel', 'search', 'limit', 'datas','remarks'));
        }
        else
        {
            return redirect('/');
        }
    }
}
