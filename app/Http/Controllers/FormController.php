<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\visitor_log;
use App\databank;
use App\app_form;
use App\new_databank;
use App\new_visa_process;


class FormController extends Controller
{
    public function add_to_db(Request $request)
    {
        $pasa=new new_databank();
        $cols=\Schema::getColumnListing('new_databanks');
        $discard=['created_at','updated_at','date','db_status'];

        foreach($cols as $col)
        {
            if(!in_array($col,$discard))
            {
                $pasa->$col=$request->$col;
            }
        }
        $pasa->save();
        app_form::where('ref_no', $request->ref_no)->update(['app_status' => 'db']);
        session()->flash('message', 'Candidate with refer no. '.$request->ref_no.' was entered into databank!');
        return back();
    }
    public function add_to_visa(Request $request)
    {
        $pasa=new new_databank();
        $pasa->ref_no=$request->ref_no;
        $pasa->visa_process_date=$request->visa_process_date;
        $pasa->save();
        app_form::where('ref_no', $request->ref_no)->update(['app_status' => 'vp']);
        session()->flash('message', 'Candidate with refer no. '.$request->ref_no.' was entered into databank!');
        return back();
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
                $discard=['_token','db_table','add','State','created_at','updated_at'];
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
}
