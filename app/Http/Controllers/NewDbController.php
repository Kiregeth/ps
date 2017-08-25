<?php

namespace App\Http\Controllers;

use App\databank;
use App\field_preset;
use Illuminate\Http\Request;
use App\db_remark;
use App\new_databank;
use App\active_field;


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
            $fields=explode(',',active_field::where('view','new_databank')->first()->field);
            $db_table = 'new_databanks';
            $remarks = db_remark::orderBy('time', 'desc')->get(['ref_no','remark_id','remark','user','time']);

            return view("joins.new_databank", compact('db_table','fields', 'sel', 'search','limit', 'datas','remarks'));
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
            $fields=explode(',',active_field::where('view','new_visa_process')->first()->field);
            $remarks = db_remark::orderBy('time', 'desc')->get(['ref_no','remark_id','remark','user','time']);
            $db_table = 'new_visa_processes';

            return view("joins.new_visa", compact('db_table','fields', 'sel', 'search', 'limit', 'datas','remarks'));
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
            $fields=explode(',',active_field::where('view','new_visa_receive')->first()->field);
            $remarks = db_remark::orderBy('time', 'desc')->get(['ref_no','remark_id','remark','user','time']);
            $db_table = 'new_visa_receives';

            return view("joins.new_visa_receive", compact('db_table','fields', 'sel', 'search', 'limit', 'datas','remarks'));
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
                    ->join('new_visa_receives','new_databanks.ref_no', '=', 'new_visa_receives.ref_no')
                    ->join('new_vr_flowns','new_databanks.ref_no', '=', 'new_vr_flowns.ref_no')
                    ->where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('new_vr_flowns.ref_no', 'desc')
                    ->paginate($limit);

            } else {
                $datas = \DB::table('new_databanks')
                    ->join('new_visa_processes','new_databanks.ref_no', '=', 'new_visa_processes.ref_no')
                    ->join('new_visa_receives','new_databanks.ref_no', '=', 'new_visa_receives.ref_no')
                    ->join('new_vr_flowns','new_databanks.ref_no', '=', 'new_vr_flowns.ref_no')
                    ->orderBy('new_vr_flowns.ref_no', 'desc')
                    ->paginate($limit);
            }
            $fields=explode(',',active_field::where('view','new_deployment')->first()->field);
            $remarks = db_remark::orderBy('time', 'desc')->get(['ref_no','remark_id','remark','user','time']);
            $db_table = 'new_vr_flowns';
            return view("joins.new_deployment", compact('db_table', 'fields','sel', 'search', 'limit', 'datas','remarks'));
        }
        else
        {
            return redirect('/');
        }
    }

    public function new_preset(Request $request)
    {
        $db_cols = \Schema::getColumnListing('new_databanks');
        $db_cols=array_values(array_diff($db_cols,['ref_no','id','app_status','date','photo','created_at','updated_at']));

        $temp=$db_cols;
        $vp_cols = \Schema::getColumnListing('new_visa_processes');
        foreach($vp_cols as $col)
        {
            if(!in_array($col,$temp))
            {
                $temp[]=$col;
            }
        }
        $vp_cols=array_values(array_diff($temp,['ref_no','id','app_status','date','photo','created_at','updated_at']));

        $temp=$vp_cols;
        $vr_cols = \Schema::getColumnListing('new_visa_receives');
        foreach($vr_cols as $col)
        {
            if(!in_array($col,$temp))
            {
                $temp[]=$col;
            }
        }
        $vr_cols=array_values(array_diff($temp,['ref_no','id','app_status','date','photo','created_at','updated_at']));

        $temp=$vr_cols;
        $dp_cols = \Schema::getColumnListing('new_vr_flowns');
        foreach($dp_cols as $col)
        {
            if(!in_array($col,$temp))
            {
                $temp[]=$col;
            }
        }

        $dp_cols=array_values(array_diff($temp,['ref_no','id','app_status','date','photo','created_at','updated_at']));

        $db_presets=field_preset::where('view_id',1)->get();
        $vp_presets=field_preset::where('view_id',2)->get();
        $vr_presets=field_preset::where('view_id',3)->get();
        $dp_presets=field_preset::where('view_id',4)->get();

        return view("joins.new_preset",compact('db_cols','vp_cols','vr_cols','dp_cols','db_presets','vp_presets','vr_presets','dp_presets'));
    }
}
