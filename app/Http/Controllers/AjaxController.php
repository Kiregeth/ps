<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function quick_add(Request $request)
    {

        $err = "";
        $val = $request->value;


        // Perform MySQL ADD
        $query=array();

        $array = explode(",", $val);
        $db_table = $array[0];
        switch ($db_table)
        {
            case 'visistor_logs':
                $required = ['visitor_name', 'contact_no', 'visit_purpose'];
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
                if (in_array($value[0], $required) && ($value[1]==null || $value[1]=="")) {
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
        \DB::table($db_table)->where($w_col, $w_val)->update([$col => $val]);

        if($db_table=='databanks' || $db_table=='visaprocesses')
        {
            $state=\DB::table($db_table)->select('State')->where($w_col,$w_val)->first();

            if($state->State=='vp') {
                ($db_table=='databanks')?$db_table2='visaprocesses':$db_table2='databanks';
                $cols=\Schema::getColumnListing($db_table2);
                $refs=\DB::table($db_table2)->select('Ref_No')->get();
                if(in_array($w_val,$refs) && in_array($col,$cols))
                {
                    echo "asdf";
                    exit;
                }

                $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME= '" . $db_table2 . "'";
                $result = $conn->query($sql);

                $col_name = array();
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $col_name[$i] = $row["COLUMN_NAME"];
                        $i++;
                    }
                }
                if (in_array($_POST['col'], $col_name)) {
                    $sql = "UPDATE " . $db_table2 . " SET " . $_POST['col'] . "='" . $_POST['val'] . "'WHERE " . $_POST['w_col'] . "='" . $_POST['w_val'] . "'";
                    $result = $conn->query($sql) or die('Unable to update row.');
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
        $array=[];
        $query=[];

        $i = 0;

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
}
