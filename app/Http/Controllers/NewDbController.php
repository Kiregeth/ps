<?php

namespace App\Http\Controllers;

use App\databank;
use Illuminate\Http\Request;
use App\app_form;
use App\new_databank;


class NewDbController extends Controller
{
    public function new_databank(Request $request)
    {
        if (\Auth::user()) {
            $sel = "";
            $search = "";

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
                    ->paginate(20);

            } else {
                $datas = new_databank::orderBy('new_databanks.ref_no', 'desc')
                    ->paginate(20);
            }

            $db_table = 'new_databanks';

            return view("joins.new_databank", compact('db_table', 'sel', 'search', 'datas'));
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
                    ->paginate(20);

            } else {
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->orderBy('new_visa_processes.ref_no', 'desc')
                    ->paginate(20);
            }

            $db_table = 'new_visa_processes';

            return view("joins.new_visa", compact('db_table', 'sel', 'search', 'datas'));
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
                    ->paginate(20);

            } else {
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_visa_receives','new_databanks.ref_no', '=', 'new_visa_receives.ref_no')
                    ->orderBy('new_visa_receives.ref_no', 'desc')
                    ->paginate(20);
            }

            $db_table = 'new_visa_receives';

            return view("joins.new_visa_receive", compact('db_table', 'sel', 'search', 'datas'));
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
                    ->paginate(20);

            } else {
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_visa_receives','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_vr_flowns','new_databanks.ref_no', '=', 'new_vr_flowns.ref_no')
                    ->orderBy('new_vr_flowns.ref_no', 'desc')
                    ->paginate(20);
//                return $datas;
            }

            $db_table = 'new_vr_flowns';
            return view("joins.new_deployment", compact('db_table', 'sel', 'search', 'datas'));
        }
        else
        {
            return redirect('/');
        }
    }
}
