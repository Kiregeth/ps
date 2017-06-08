<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\visitor_log;

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

    public function visitor_log()
    {
        if(\Auth::user())
        {
            $cols=\Schema::getColumnListing('visitor_logs');;
            $logs=visitor_log::orderBy('sn','desc')
                ->groupBy('sn')
                ->groupBy('visitor_name')
                ->groupBy('contact_no')
                ->groupBy('visit_purpose')
                ->groupBy('remarks')
                ->groupBy('time')
                ->get();
            $db_table="visitor_logs";
            return view('joins.visitor_log',compact('cols','logs','db_table'));
        }else
        {
            return redirect('/');
        }

    }
}
