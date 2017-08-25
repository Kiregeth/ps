<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\visitor_log;
use App\databank;
use App\app_form;
use App\new_databank;
use App\new_visa_process;
use App\new_visa_receive;
use App\new_vr_flown;
use App\db_remark;


class FormController extends Controller
{
    public function add_to_db(Request $request)
    {
        $fields=['pp_status','next_of_kin','local_agent','la_contact','trade','company','offer_letter_received_date','old_vp_date','pp_returned_date','pp_resubmitted_date'];
        $app=app_form::find($request->ref_no);
        $pasa=new new_databank();
        $cols=\Schema::getColumnListing('app_forms');
        $discard=['created_at','updated_at'];

        foreach($cols as $col)
        {
            if(!in_array($col,$discard))
            {
                $pasa->$col=$app->$col;
            }
        }

        foreach($fields as $field)
        {
            $pasa->$field=$request->$field;
        }

        $pasa->save();

        app_form::where('ref_no', $app->ref_no)->delete();
        new_databank::where('ref_no', $request->ref_no)->update(['app_status' => 'db']);

        if($request->remarks!==null && $request->remarks!=="")
        {
            $pasa1=new db_remark();
            $pasa1->ref_no=$request->ref_no;
            $pasa1->remark_id=1;
            $pasa1->remark=$request->remarks;
            $pasa1->user=\Auth::user()->uname;
            $pasa1->save();
        }

        session()->flash('message', 'Candidate with refer no. '.$request->ref_no.' was entered into databank!');
        return back();
    }
    public function add_to_visa(Request $request)
    {
        $pasa=new new_visa_process();
        $pasa->ref_no=$request->ref_no;
        $pasa->visa_process_date=$request->visa_process_date;
        $pasa->save();
        new_databank::where('ref_no', $request->ref_no)->update(['app_status' => 'vp','trade'=>$request->trade,'company'=>$request->company]);
        session()->flash('message', 'Candidate with refer no. '.$request->ref_no.' was entered into visa process!');
        return back();
    }

    public function add_to_visa_receive(Request $request)
    {
        if($request->db_table==='new_databanks')
        {
            $pasa=new new_visa_process();
            $pasa->ref_no=$request->ref_no;
            $pasa->visa_process_date=null;
            $pasa->save();
        }

        $pasa1=new new_visa_receive();
        $pasa1->ref_no=$request->ref_no;
        $pasa1->vr_date=$request->vr_date;
        $pasa1->visa_issue_date=$request->visa_issue_date;
        $pasa1->visa_expiry_date=$request->visa_expiry_date;
        $pasa1->save();

        new_databank::where('ref_no', $request->ref_no)->update(['app_status' => 'vr','trade'=>$request->trade,'company'=>$request->company]);
        session()->flash('message', 'Candidate with refer no. '.$request->ref_no.' was entered into visa return!');
        return back();
    }

    public function add_to_deployment(Request $request)
    {
        $pasa=new new_vr_flown();
        foreach ($request->all() as $key=>$value)
        {
            if($key!=='_token')
            {
                $pasa->$key=$value;
            }
        }
        $pasa->save();
        new_databank::where('ref_no', $request->ref_no)->update(['app_status' => 'vf']);
        session()->flash('message', 'Candidate with refer no. '.$request->ref_no.' was entered into deployment!');
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

    public function export_to_excel(Request $request)
    {
        \Excel::create($request->file.' Export', function($excel) use ($request) {
            $excel->sheet('Sheet1', function($sheet) use($request) {
                $cols=unserialize($request->colsString);
                $discard=unserialize($request->discardString);
                $datas=unserialize($request->datasString);
                $head=[];
                foreach($cols as $col)
                {
                    if(!in_array($col,$discard))
                    {
                        $head[]=$col;
                    }
                }
                $sheet->setOrientation('landscape');
                $sheet->fromArray($datas, null, 'A1', false, false);
                $sheet->prependRow(1, $head);
            });
        })->export('xls');
        return back();
    }

    public function change_photo(Request $request)
    {
        if ($request->hasFile('photo')) {
            $request->file('photo')->storeAs(
                "/app_forms/" . "L" . $request->ref_no, "photo_" . $request->ref_no . ".jpg"
            );
            new_databank::where('ref_no',$request->ref_no)->update(['photo'=>'app_forms/'.'L'.$request->ref_no.'/photo_'.$request->ref_no.'.jpg']);
        }
        return back();
    }

    public function upload_doc(Request $request)
    {
        $data=new_databank::where('ref_no',$request->ref_no)->first(['document_list']);
//        echo strpos($data->document_list, $request->title)+1;
//        exit;
        if(!strpos($data->document_list, $request->title))
        {
            new_databank::where('ref_no',$request->ref_no)->update(['document_list'=>$data->document_list.', '.$request->title]);
        }
        $title=strstr( $request->title . ' ', ' ', true );
        if ($request->hasFile('upload_doc')) {
            $request->file('upload_doc')->storeAs(
                "/app_forms/" . "L" . $request->ref_no, $title."_" . $request->ref_no .'.'. $request->upload_doc->getClientOriginalExtension()
            );
        }
        return back();
    }




}
