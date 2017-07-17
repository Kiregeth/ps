<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\cv;
use App\cv_edu;
use App\cv_exp;

class AjaxController extends Controller
{
    public function quick_add(Request $request)
    {

        $err = "";
        $val = $request->value;


        // Perform MySQL ADD
        $query=array();
        $required=[];
        $array = explode(",", $val);
        $db_table = $array[0];
        switch ($db_table)
        {
            case 'visitor_logs':
                $required = ['visitor_name', 'contact_no','type', 'visit_purpose'];
                break;
            case 'databanks':
                $required=['Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','Trade','Company'];
                break;
            default:
                $required=[];
                break;
        }
        $i = 0;

        foreach ($array as $arr) {
            if ($i == 0) {
                $i++;
                continue;
            } else {

                $value = explode(":", $arr);
                if (in_array($value[0], $required) && ($value[1]==''||empty($value[1]))) {
                    $err = $value[0] . " field is required";
                    break;
                }

                $query[$value[0]]=$value[1];
            }
        }
        if ($err == "") {
            \DB::table($db_table)->insert($query);
        } else {
            echo $err;
        }
    }

    public function quick_edit(Request $request)
    {
        $db_table=$request->db_table;
        $w_col=$request->w_col;
        $w_val=$request->w_val;
        $col=$request->col;
        $val=$request->val;
        if($db_table=='users')
        {
            $check = \DB::table($db_table)->select()->where($w_col, $w_val)->first();
            if (count($check) > 0) {
                $cols = \Schema::getColumnListing($db_table);
                if (in_array($col, $cols)) {
                    \DB::table($db_table)->where($w_col, $w_val)->update([$col => $val]);
                    if($col=='role') {
                        if (Auth::user()->uname == $check->uname) {
                            //echo Auth::user()->role;
                            Auth::user()->role = $val;
                        }
                    }
                }
            }
        }
        else {
            $check = \DB::table('databanks')->select()->where($w_col, $w_val)->first();
            if (count($check) > 0) {
                $cols = \Schema::getColumnListing('databanks');
                if (in_array($col, $cols)) {
                    \DB::table('databanks')->where($w_col, $w_val)->update([$col => $val]);
                }
            }
            $check = \DB::table('visaprocesses')->select()->where($w_col, $w_val)->first();
            if (count($check) > 0) {
                $cols = \Schema::getColumnListing('visaprocesses');
                if (in_array($col, $cols)) {
                    \DB::table('visaprocesses')->where($w_col, $w_val)->update([$col => $val]);
                }
            }
            $check = \DB::table('vrflowns')->select()->where($w_col, $w_val)->first();
            if (count($check) > 0) {
                $cols = \Schema::getColumnListing('vrflowns');
                if (in_array($col, $cols)) {
                    \DB::table('vrflowns')->where($w_col, $w_val)->update([$col => $val]);
                }
            }
        }
    }

    public function delete(Request $request)
    {
        $db_table=$request->db_table;
        $col=$request->w_col;
        $value=$request->w_id;
        \DB::table($db_table)->where($col, $value)->delete();
    }

    public function visaprocess(Request $request)
    {
        $db_table1=$request->db_table1;
        $db_table2=$request->db_table2;

        $discard=['Old_VP_Date','Remarks','State','created_at','updated_at'];

        $w_col=$request->w_col;
        $w_id=$request->w_id;
        $query=[];
        $check=\DB::table($db_table2)->select()->where($w_col,$w_id)->first();
        if(count($check)<1)
        {
            $array= \DB::table($db_table1)->select()->where($w_col,$w_id)->first();

            foreach($array as $key=>$value) {
                if(!in_array($key,$discard))
                {
                    $query[$key]=$value;
                }
            }
            $query['State_Vp']='vp';
            \DB::table($db_table2)->insert($query);
            \DB::table($db_table1)->where($w_col, $w_id)->update(['State' => 'vp']);
        }
        else
        {
            \DB::table($db_table1)->where($w_col, $w_id)->update(['State' => 'vp']);
            \DB::table($db_table2)->where($w_col, $w_id)->update(['State_Vp' => 'vp']);
        }
    }

    public function deploy(Request $request)
    {
        $db_table1=$request->db_table1;
        $db_table2=$request->db_table2;
        $db_table3=$request->db_table3;

        $discard=['State_Vp','created_at','updated_at'];

        $w_col=$request->w_col;
        $w_id=$request->w_id;
        $query=[];
        $check=\DB::table($db_table2)->select()->where($w_col,$w_id)->first();
        if(count($check)<1)
        {
            $array= \DB::table($db_table1)->select()->where($w_col,$w_id)->first();

            foreach($array as $key=>$value) {
                if(!in_array($key,$discard))
                {
                    if($key=='Process_Date')
                        $query['VP_Date']=$value;
                    else
                        $query[$key]=$value;
                }
            }
            \DB::table($db_table2)->insert($query);
            \DB::table($db_table1)->where($w_col, $w_id)->update(['State_Vp' => 'vf']);
            \DB::table($db_table3)->where($w_col, $w_id)->update(['State' => 'vf']);
        }
        else
        {
            \DB::table($db_table1)->where($w_col, $w_id)->update(['State_Vp' => 'vf']);
            \DB::table($db_table3)->where($w_col, $w_id)->update(['State' => 'vf']);
        }
    }

    public function cancel(Request $request)
    {
        $db_table1=$request->db_table1;
        $db_table2=$request->db_table2;
        $db_table3=$request->db_table3;
        $w_col=$request->w_col;
        $w_id=$request->w_id;

        $temp_date="";
        $temp_status="";

        $check=\DB::table($db_table1)->select('State_Vp')->where($w_col,$w_id)->first();
        if($check->State_Vp=='vf')
        {
            $query=\DB::table($db_table2)->select('VP_Date','Status')->where($w_col,$w_id)->first();
            $temp_date=$query->VP_Date;
            $temp_status=$query->Status;
            \DB::table($db_table2)->where($w_col, $w_id)->delete();
            \DB::table($db_table1)->where($w_col, $w_id)->delete();
        }
        else
        {
            $query=\DB::table($db_table1)->select('Process_Date','Status')->where($w_col,$w_id)->first();
            $temp_date=$query->Process_Date;
            $temp_status=$query->Status;
            \DB::table($db_table1)->where($w_col, $w_id)->delete();
        }

        \DB::table($db_table3)->where($w_col, $w_id)->update(['State' => 'vc','Remarks'=>$temp_status,'Old_VP_Date'=>$temp_date]);
    }

    public function cv_save(Request $request)
    {
        if(cv::where('ref_no',0)->exists())
        {
            cv::where('ref_no',0)->delete();
        }
        $cv=new cv;
        $cv->ref_no=0;
        $cv->father_name=$request->father_name;
        $cv->mother_name=$request->mother_name;
        $cv->nationality=$request->nationality;
        $cv->languages_known=$request->languages_known;
        $cv->save();

        if(cv_edu::where('ref_no',0)->exists())
        {
            cv_edu::where('ref_no',0)->delete();
        }

        $cv_edu1=new cv_edu;
        $cv_edu1->ref_no=0;
        $cv_edu1->edu_id=1;
        $cv_edu1->qualification=$request->qualification_1;
        $cv_edu1->name_of_institution=$request->name_of_institution_1;
        $cv_edu1->year_of_passing=$request->year_of_passing_1;
        $cv_edu1->grades_obtained=$request->grades_obtained_1;
        $cv_edu1->save();


        if($request->qualification_2!==null && $request->qualification_2!=="")
        {
        $cv_edu2=new cv_edu;
        $cv_edu2->ref_no=0;
        $cv_edu2->edu_id=2;
        $cv_edu2->qualification=$request->qualification_2;
        $cv_edu2->name_of_institution=$request->name_of_institution_2;
        $cv_edu2->year_of_passing=$request->year_of_passing_2;
        $cv_edu2->grades_obtained=$request->grades_obtained_2;
        $cv_edu2->save();
        }
        if($request->qualification_3!==null && $request->qualification_3!=="")
        {
            $cv_edu3=new cv_edu;
            $cv_edu3->ref_no=0;
            $cv_edu3->edu_id=3;
            $cv_edu3->qualification=$request->qualification_3;
            $cv_edu3->name_of_institution=$request->name_of_institution_3;
            $cv_edu3->year_of_passing=$request->year_of_passing_3;
            $cv_edu3->grades_obtained=$request->grades_obtained_3;
            $cv_edu3->save();
        }
        if($request->qualification_4!==null && $request->qualification_4!=="")
        {
            $cv_edu4=new cv_edu;
            $cv_edu4->ref_no=0;
            $cv_edu4->edu_id=4;
            $cv_edu4->qualification=$request->qualification_4;
            $cv_edu4->name_of_institution=$request->name_of_institution_4;
            $cv_edu4->year_of_passing=$request->year_of_passing_4;
            $cv_edu4->grades_obtained=$request->grades_obtained_4;
            $cv_edu4->save();
        }

        if(cv_exp::where('ref_no',0)->exists())
        {
            cv_exp::where('ref_no',0)->delete();
        }

        $cv_exp1=new cv_exp;
        $cv_exp1->ref_no=0;
        $cv_exp1->exp_id=1;
        $cv_exp1->name_of_company=$request->name_of_company_1;
        $cv_exp1->designation=$request->designation_1;
        $cv_exp1->start_year=$request->start_year_1;
        $cv_exp1->end_year=$request->end_year_1;
        $cv_exp1->country=$request->country_1;
        $cv_exp1->reason_for_leave=$request->reason_for_leave_1;
        $cv_exp1->save();

        if($request->name_of_company_2!==null && $request->name_of_company_2!=="")
        {
            $cv_exp2=new cv_exp;
            $cv_exp2->ref_no=0;
            $cv_exp2->exp_id=2;
            $cv_exp2->name_of_company=$request->name_of_company_2;
            $cv_exp2->designation=$request->designation_2;
            $cv_exp2->start_year=$request->start_year_2;
            $cv_exp2->end_year=$request->end_year_2;
            $cv_exp2->country=$request->country_2;
            $cv_exp2->reason_for_leave=$request->reason_for_leave_2;
            $cv_exp2->save();
        }
        if($request->name_of_company_3!==null && $request->name_of_company_3!=="")
        {
            $cv_exp3=new cv_exp;
            $cv_exp3->ref_no=0;
            $cv_exp3->exp_id=3;
            $cv_exp3->name_of_company=$request->name_of_company_3;
            $cv_exp3->designation=$request->designation_3;
            $cv_exp3->start_year=$request->start_year_3;
            $cv_exp3->end_year=$request->end_year_3;
            $cv_exp3->country=$request->country_3;
            $cv_exp3->reason_for_leave=$request->reason_for_leave_3;
            $cv_exp3->save();
        }
        if($request->name_of_company_4!==null && $request->name_of_company_4!=="")
        {
            $cv_exp4=new cv_exp;
            $cv_exp4->ref_no=0;
            $cv_exp4->exp_id=4;
            $cv_exp4->name_of_company=$request->name_of_company_4;
            $cv_exp4->designation=$request->designation_4;
            $cv_exp4->start_year=$request->start_year_4;
            $cv_exp4->end_year=$request->end_year_4;
            $cv_exp4->country=$request->country_4;
            $cv_exp4->reason_for_leave=$request->reason_for_leave_4;
            $cv_exp4->save();
        }
    }

    public function delete_new(Request $request)
    {
        $db_table=$request->db_table;
        $col=$request->w_col;
        $value=$request->w_val;
        \DB::table($db_table)->where($col, $value)->delete();
        \DB::table('new_visa_processes')->where($col, $value)->delete();
        \DB::table('new_vr_flowns')->where($col, $value)->delete();
        \DB::table('app_forms')->where($col, $value)->update(['app_status' => null]);

    }

    public function cancel_new(Request $request)
    {
        $db_table=$request->db_table;
        $col=$request->w_col;
        $value=$request->w_val;

        $visa_process_dates=\DB::table('new_visa_processes')->where($col, $value)->first(['visa_process_date']);
        $d=$visa_process_dates->visa_process_date;
        \DB::table('new_databanks')->where($col, $value)->update(['old_vp_date' => $d]);

        \DB::table('new_visa_processes')->where($col, $value)->delete();
        \DB::table('new_vr_flowns')->where($col, $value)->delete();

        \DB::table('app_forms')->where($col, $value)->update(['app_status' => 'vc']);
        \DB::table('new_databanks')->where($col, $value)->update(['db_status' => 'vc']);
    }

    public function quick_edit_new(Request $request)
    {
        $w_col = $request->w_col;
        $w_val = $request->w_val;
        $col = $request->col;
        $val = $request->val;
        $check = \DB::table('app_forms')->select()->where($w_col, $w_val)->first();
        if (count($check) > 0) {
            $cols = \Schema::getColumnListing('app_forms');
            if (in_array($col, $cols)) {
                \DB::table('app_forms')->where($w_col, $w_val)->update([$col => $val]);
            }
        }
        $check = \DB::table('new_databanks')->select()->where($w_col, $w_val)->first();
        if (count($check) > 0) {
            $cols = \Schema::getColumnListing('new_databanks');
            if (in_array($col, $cols)) {
                \DB::table('new_databanks')->where($w_col, $w_val)->update([$col => $val]);
            }
        }
        $check = \DB::table('new_visa_processes')->select()->where($w_col, $w_val)->first();
        if (count($check) > 0) {
            $cols = \Schema::getColumnListing('new_visa_processes');
            if (in_array($col, $cols)) {
                \DB::table('new_visa_processes')->where($w_col, $w_val)->update([$col => $val]);
            }
        }
        $check = \DB::table('new_deployments')->select()->where($w_col, $w_val)->first();
        if (count($check) > 0) {
            $cols = \Schema::getColumnListing('new_deployments');
            if (in_array($col, $cols)) {
                \DB::table('new_deployments')->where($w_col, $w_val)->update([$col => $val]);
            }
        }
    }

}
