<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\online_form;

class OnlineController extends Controller
{
    public function online_form()
    {
        return \DB::connection('mysql2')->select('select * from pasainte_pasa.online_forms');

    }
}
