<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\online_form;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Ftp as Adapter;

class OnlineController extends Controller
{
    public function online_form()
    {
        $datas= json_decode(file_get_contents(public_path('results.json')), true);
        $cols=[];
        foreach($datas[0] as $key=>$value)
        {
            $cols[]=$key;
        }
        $this->update_folders($datas);
        $full_path_source = \Storage::disk('ftp')->getDriver()->getAdapter()->applyPathPrefix('ftp://pasainternational.com.np/public_html/image/online_files');
//        echo $full_path_source;
//        exit;
        $full_path_dest=public_path("images/app_forms/online");
        if(\File::copyDirectory($full_path_source, $full_path_dest))
        {
            echo "asd";
        }
        else
        {
            echo "dsa";
        }

        return view('joins/online_forms',compact('cols','datas'));

    }

    public function update_folders($datas){


//        foreach($datas as $data)
//        {
//            if (!\File::exists(public_path('\\images\\app_forms\\online\\O').$data['id']))
//            {
//                \File::makeDirectory(public_path("\\images\\app_forms\\online\\O").$data['id']);
//
//                $url= 'ftp://pasainternational.com.np/public_html/image/online_files/cv_doc_'.$data->id.'.*';
//
//            }
//        }

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
