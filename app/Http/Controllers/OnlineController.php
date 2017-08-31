<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\online_form;

class OnlineController extends Controller
{
    public function online_form()
    {
        return view('joins/online_forms');

    }

    public function refresh()
    {
        $username='pasainternationa';
        $password='z8Q;gS62VcfM';
//        $usernamePassword = $username . ':' . $password;
//        $headers = array('Authorization: Basic ' . base64_encode($usernamePassword), 'Content-Type: application/json');

        $url= 'ftp://pasainternational.com.np/public_html/results.json';

        $filename = 'results.json';
        $path = public_path($filename);
        $fp = fopen($path, 'w');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        fwrite($fp,$output);
        curl_close($ch);

        fclose($fp);
        return back();
    }
}
