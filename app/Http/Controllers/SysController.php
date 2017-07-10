<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;
use App;
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

    public function users(Request $request)
    {
        if(\Auth::user() && (\Auth::user()->role=='admin' || \Auth::user()->role=='superadmin'))
        {
            $sel="";
            $search="";

            $gp_array=['id','uname','name','phn','role','email','password','remember_token','created_at','updated_at'];
            $pg_array=['id','uname','name','phn','role','email','password'];

            if (!empty($request->all()) && $request->sel!="" && $request->search!="")
            {
                $sel = $request->sel;
                $search = $request->search;
                $users=user::where($sel, 'LIKE', '%' . $search . '%')
                    ->orderBy('id','desc')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
            }
            else
            {
                $users=user::orderBy('uname','desc')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
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
