<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                if (in_array($value[0], $required)) {
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
}
