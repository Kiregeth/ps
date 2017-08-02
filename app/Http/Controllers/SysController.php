<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;
use App;
use App\User;
use App\user_role;


class SysController extends Controller
{

    public function add_sess()
    {
        $permission=[];
        $user_id=\Auth::user()->id;
        if(\DB::table('role_user')->where('user_id',$user_id)->count()>0)
        {
            $role_id=\DB::table('role_user')->where('user_id',$user_id)->first()->role_id;
            if(\DB::table('permission_role')->where('role_id',$role_id)->orderBy('permission_id', 'asc')->count()>0)
            {
                $permission_ids=\DB::table('permission_role')->where('role_id',$role_id)->orderBy('permission_id', 'asc')->get();
                $permissions=\DB::table('permissions')->get(['id','name']);

                foreach($permission_ids as $per_id)
                {
                    foreach($permissions as $check)
                    {
                        if($check->id===$per_id->permission_id)
                        {
                            $permission[]=$check->name;
                            break;
                        }
                    }

                }
            }
        }
        session(['permission' => $permission]);
        return redirect('/');
    }

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
            if($this->middleware(['permission:delete']))
                //return 'maybe';
            return view('joins.dashboard');
        }else
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
