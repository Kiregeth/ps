<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\visitor_type;
use App\visitor_log;
use App\databank;
use App\visaprocess;
use App\vrflown;
use App\User;
use App\user_role;

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

    public function visitor_log(Request $request)
    {
        if(\Auth::user())
        {
            $sel="";
            $search="";

            if (!empty($request->all()) && $request->sel!="" && $request->search!="") {
                $sel=$request->sel;
                $search=$request->search;
                $logs=visitor_log::where($sel, 'LIKE', '%' . $search . '%')
                       ->groupBy('sn')
                       ->groupBy('visitor_name')
                       ->groupBy('contact_no')
                       ->groupBy('visit_purpose')
                       ->groupBy('remarks')
                       ->groupBy('time')
                       ->groupBy('created_at')
                       ->groupBy('updated_at')->paginate(20,['sn','visitor_name','contact_no','visit_purpose','remarks','time']);
            }
            else{
                $logs=visitor_log::orderBy('sn','desc')
                    ->groupBy('sn')
                    ->groupBy('visitor_name')
                    ->groupBy('contact_no')
                    ->groupBy('visit_purpose')
                    ->groupBy('remarks')
                    ->groupBy('time')
                    ->groupBy('created_at')
                    ->groupBy('updated_at')->paginate(20,['sn','visitor_name','contact_no','visit_purpose','remarks','time']);
            }

            $cols=\Schema::getColumnListing('visitor_logs');
            $types=visitor_type::all();
            $db_table="visitor_logs";
            return view('joins.visitor_log',compact('cols','logs','types','db_table','sel','search'));
        }else
        {
            return redirect('/');
        }

    }

    public function databank(Request $request)
    {
        if (\Auth::user()) {
            $sel="";
            $search="";

            if (!empty($request->all()) && $request->sel!="" && $request->search!="") {
                $sel=$request->sel;
                $search=$request->search;
                $datas = databank::where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('Ref_No', 'desc')
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
                    ->paginate(20,
                        [
                            'Ref_No', 'Date', 'Candidates_Name', 'Contact_No', 'DOB', 'PP_NO', 'PP_Status', 'LA_Contact', 'LA',
                            'Trade', 'Company', 'Status', 'Offer_Letter_Received_Date', 'Old_VP_Date', 'Remarks', 'PP_Returned_Date',
                            'PP_Resubmitted_Date', 'State'
                        ]
                    );
            } else {
                $datas = databank::orderBy('Ref_No', 'desc')
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
                    ->paginate(20,
                        [
                            'Ref_No', 'Date', 'Candidates_Name', 'Contact_No', 'DOB', 'PP_NO', 'PP_Status', 'LA_Contact', 'LA',
                            'Trade', 'Company', 'Status', 'Offer_Letter_Received_Date', 'Old_VP_Date', 'Remarks', 'PP_Returned_Date',
                            'PP_Resubmitted_Date', 'State'
                        ]
                    );
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

            if (!empty($request->all()) && $request->sel!="" && $request->search!="") {
                $sel=$request->sel;
                $search=$request->search;
                $datas=visaprocess::where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('Ref_No','desc')
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
                    ->groupBy('Process_Date')
                    ->groupBy('Status')
                    ->groupBy('PP_Returned_Date')
                    ->groupBy('PP_Resubmitted_Date')
                    ->groupBy('State_Vp')
                    ->groupBy('created_at')
                    ->groupBy('updated_at')
                    ->paginate(20,
                        [
                            'Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','PP_Status','LA_Contact','LA',
                            'Trade','Company','Status','Offer_Letter_Received_Date','Process_Date','Status','PP_Returned_Date',
                            'PP_Resubmitted_Date','State_Vp'
                        ]
                    );
            }
            else{
                $datas=visaprocess::orderBy('Ref_No','desc')
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
                    ->groupBy('Process_Date')
                    ->groupBy('Status')
                    ->groupBy('PP_Returned_Date')
                    ->groupBy('PP_Resubmitted_Date')
                    ->groupBy('State_Vp')
                    ->groupBy('created_at')
                    ->groupBy('updated_at')
                    ->paginate(20,
                        [
                            'Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','PP_Status','LA_Contact','LA',
                            'Trade','Company','Status','Offer_Letter_Received_Date','Process_Date','Status','PP_Returned_Date',
                            'PP_Resubmitted_Date','State_Vp'
                        ]
                    );
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

            if (!empty($request->all()) && $request->sel!="" && $request->search!="") {
                $sel = $request->sel;
                $search = $request->search;
                $datas = vrflown::where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('Ref_No','desc')
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
                    ->groupBy('WP_Expiry')
                    ->groupBy('Offer_Letter_Received_Date')
                    ->groupBy('VP_Date')
                    ->groupBy('VR_Date')
                    ->groupBy('Visa_Issue_Date')
                    ->groupBy('Visa_Exp')
                    ->groupBy('SA')
                    ->groupBy('Flown_date')
                    ->groupBy('PP_Returned_Date')
                    ->groupBy('PP_Resubmitted_Date')
                    ->groupBy('Demand_No')
                    ->groupBy('Visa_No')
                    ->groupBy('created_at')
                    ->groupBy('updated_at')
                    ->paginate(20,
                        [
                            'Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','PP_Status','LA_Contact','LA',
                            'Trade','Company','Status','WP_Expiry','Offer_Letter_Received_Date','VP_Date','VR_Date','Visa_Issue_Date','Visa_Exp','SA','Flown_Date','PP_Returned_Date',
                            'PP_Resubmitted_Date','Demand_No','Visa_No'
                        ]
                    );
            }
            else{
                $datas=vrflown::orderBy('Ref_No','desc')
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
                    ->groupBy('WP_Expiry')
                    ->groupBy('Offer_Letter_Received_Date')
                    ->groupBy('VP_Date')
                    ->groupBy('VR_Date')
                    ->groupBy('Visa_Issue_Date')
                    ->groupBy('Visa_Exp')
                    ->groupBy('SA')
                    ->groupBy('Flown_date')
                    ->groupBy('PP_Returned_Date')
                    ->groupBy('PP_Resubmitted_Date')
                    ->groupBy('Demand_No')
                    ->groupBy('Visa_No')
                    ->groupBy('created_at')
                    ->groupBy('updated_at')
                    ->paginate(20,
                        [
                            'Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','PP_Status','LA_Contact','LA',
                            'Trade','Company','Status','WP_Expiry','Offer_Letter_Received_Date','VP_Date','VR_Date','Visa_Issue_Date','Visa_Exp','SA','Flown_Date','PP_Returned_Date',
                            'PP_Resubmitted_Date','Demand_No','Visa_No'
                        ]
                    );
            }
            $cols=\Schema::getColumnListing('vrflowns');
            $db_table="visaprocesses";

            return view('joins.deployment',compact('cols','datas','db_table','sel','search'));
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

    public function users(Request $request)
    {
        if(\Auth::user() && (\Auth::user()->role=='admin' || \Auth::user()->role=='superadmin'))
        {
            $sel="";
            $search="";

            if (!empty($request->all()) && $request->sel!="" && $request->search!="")
            {
                $sel = $request->sel;
                $search = $request->search;
                $users=user::where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('id','desc')
                    ->groupBy('id')
                    ->groupBy('uname')
                    ->groupBy('name')
                    ->groupBy('phn')
                    ->groupBy('role')
                    ->groupBy('email')
                    ->groupBy('password')
                    ->groupBy('remember_token')
                    ->groupBy('created_at')
                    ->groupBy('updated_at')
                    ->paginate(20,['id','uname','name','phn','role','email','password']);
            }
            else
            {
                $users=user::orderBy('uname','desc')
                    ->groupBy('uname')
                    ->groupBy('id')
                    ->groupBy('name')
                    ->groupBy('phn')
                    ->groupBy('role')
                    ->groupBy('email')
                    ->groupBy('password')
                    ->groupBy('remember_token')
                    ->groupBy('created_at')
                    ->groupBy('updated_at')
                    ->paginate(20,['id','uname','name','phn','role','email','password']);
            }

            $cols=\Schema::getColumnListing('users');
            $db_table='users';
            $roles=user_role::all();
            return view ('joins/users', compact('users','cols','sel','search','db_table','roles'));
        }
        else
        {
            return redirect('/');
        }
    }

    public function add_user(Request $request)
    {
        if(\Auth::user() && (\Auth::user()->role=='admin' || \Auth::user()->role=='superadmin'))
        {

            if (!empty($request->all()))
            {
                $pasa=new User;
                $discard=['id','remember_token','created_at','updated_at'];
                $cols=\Schema::getColumnListing('users');
                foreach($request->all() as $key=>$value)
                {
                    if(in_array($key,$cols) && !in_array($key,$discard))
                    {
                        if($key=='password') {
                            $pasa->$key = bcrypt($value);
                        }
                        else if($key=='email')
                        {
                            $email_list=User::get(['email']);
                            $temp=[];
                            $i=0;

                            foreach($email_list as $e)
                            {
                                $temp[]=$e->email;
                                $i++;
                            }

                            if(in_array($value,$temp))
                            {
                                $pri="<h1 style='color:Red'>Error: Email Already Exist</h1>"."<br /><a class='btn btn-link' title='Go Back' href='/add_user'>Go Back</a>";
                                return $pri;
                            }
                            else
                            {
                                $pasa->$key = $value;
                            }
                        }
                        else {
                            $pasa->$key = $value;
                        }
                    }
                }
                $pasa->save();
                session()->flash('message', 'Data Added Successfully!');
            }
            $roles=user_role::all();
            $cols=\Schema::getColumnListing('users');

            return view ('joins/add_user', compact('cols','roles','msg'));
        }
        else
        {
            return redirect('/');
        }
    }

    public function change_pwd(Request $request)
    {
        $msg="";
        $msg_class="";
        if (!empty($request->all()))
        {
            if (\Hash::check($request->old_pwd, \Auth::user()->password))
            {
                $password=\Hash::make($request->new_pwd);
                User::where('uname', \Auth::user()->uname)
                    ->update(['password' => $password]);
                $msg="Password Changed!";
                $msg_class="bg-success";

            }
            else
            {
                $msg="Old Password Invalid";
                $msg_class="bg-danger";
            }
        }
        return view('change_pwd',compact('msg','msg_class'));
    }

}
