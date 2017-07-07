<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;
use App;
use App\visitor_type;
use App\visitor_log;
use App\app_form;
use App\cv;
use App\cv_edu;
use App\cv_exp;
use Dompdf\Dompdf;

class OperationController extends Controller
{
    public function visitor_log(Request $request)
    {
        if(\Auth::user())
        {
            $sel="";
            $search="";
            $gp_array=['sn','visitor_name','contact_no','type','pp_no','visit_purpose','remarks','time','created_at','updated_at'];
            $pg_array=['sn','visitor_name','contact_no','type','pp_no','visit_purpose','remarks','time'];

            if (!empty($request->all()) && $request->sel!="" && $request->search!="") {
                $sel=$request->sel;
                $search=$request->search;
                $logs=visitor_log::where($sel, 'LIKE', '%' . $search . '%')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
            }
            else{
                $logs=visitor_log::orderBy('sn','desc')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
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

    public function application_form(Request $request)
    {
        if(\Auth::user()) {
            if (!empty($request->all()))
            {
                $pasa=new app_form();
                $discard=['_token','ref_no','submit','cv_doc','pp_doc','edu_doc','exp_doc','training_doc','driving_doc'];
                foreach($request->all() as $key=>$value)
                {
                    if(!in_array($key,$discard))
                    {
                        $pasa->$key=$value;
                    }
                }
                $pasa->save();

                $pasa=app_form::all()->last();
                $insert_id=$pasa->ref_no;
                $d="L".$insert_id;
                $dir=\File::makeDirectory(public_path("images/app_forms/").$d);

                $photo_path = $request->file('photo')->storeAs(
                    "/app_forms/".$d, "photo_".$insert_id.".jpg"
                );
                $pasa->photo=$photo_path;
                $pasa->save();

                $doc_list="Photo,   ";
                //uploading files
                if ($request->hasFile('cv_doc')) {
                    $request->file('cv_doc')->storeAs(
                        "/app_forms/".$d, "cv_".$insert_id.".".$request->cv_doc->getClientOriginalExtension()
                    );
                }
                else{
                    $this->cv_generate($insert_id);
                }
                $doc_list.="CV,   ";

                if ($request->hasFile('pp_doc')) {
                    $request->file('pp_doc')->storeAs(
                        "/app_forms/".$d, "pp_".$insert_id.".".$request->pp_doc->getClientOriginalExtension()
                    );
                    $doc_list.="PP Copy,   ";
                }
                if ($request->hasFile('edu_doc')) {
                    $request->file('edu_doc')->storeAs(
                        "/app_forms/".$d, "edu_".$insert_id.".".$request->edu_doc->getClientOriginalExtension()
                    );
                    $doc_list.="Educational Document,   ";
                }
                if ($request->hasFile('exp_doc')) {
                    $request->file('exp_doc')->storeAs(
                        "/app_forms/".$d, "exp_".$insert_id.".".$request->exp_doc->getClientOriginalExtension()
                    );
                    $doc_list.="Experience Certificate,   ";
                }
                if ($request->hasFile('training_doc')) {
                    $request->file('training_doc')->storeAs(
                        "/app_forms/".$d, "training_".$insert_id.".".$request->training_doc->getClientOriginalExtension()
                    );
                    $doc_list.="Training Document,   ";
                }
                if ($request->hasFile('driving_doc')) {
                    $request->file('driving_doc')->storeAs(
                        "/app_forms/".$d, "driving_".$insert_id.".".$request->driving_doc->getClientOriginalExtension()
                    );
                    $doc_list.="Driving Licence,   ";
                }

                $doc_list=substr($doc_list,0,strlen($doc_list)-4);
                $pasa=app_form::where('ref_no',$insert_id)->first();
                $pasa->document_list=$doc_list;
                $pasa->save();


                $this->app_form_generate($insert_id,$doc_list);

                session()->flash('message', 'Application Form Submitted Successfully!');
                return back();
            }
            $cols=\Schema::getColumnListing('app_forms');
            return view('joins.application_form',compact('cols'));
        }
        else
        {
            return redirect('/');
        }

    }

    public function app_forms(Request $request)
    {
        if(\Auth::user())
        {
            $sel="";
            $search="";

            $gp_array=['ref_no','name','position','telephone_no','mobile_no',
                'religion','address','contact_address','email','qualification',
                'date_of_birth','gender','marital_status','spouse_name','passport_no',
                'place_of_issue','date_of_issue','date_of_expiry','height_feet','height_inch',
                'weight','parent_name','prior_experience','document_list','photo',
                'app_status','created_at','updated_at'];
            $pg_array=['ref_no','name','position','telephone_no','mobile_no',
                'religion','address','contact_address','email','qualification',
                'date_of_birth','gender','marital_status','spouse_name','passport_no',
                'place_of_issue','date_of_issue','date_of_expiry','height_feet','height_inch',
                'weight','parent_name','prior_experience','document_list','photo','app_status'];



            if (!empty($request->all()) && $request->sel!="" && $request->search!="") {
                $sel=$request->sel;
                $search=$request->search;
                $datas=app_form::where($sel, 'LIKE', '%' . $search . '%')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
            }
            else{
                $datas=app_form::orderBy('ref_no','desc')
                    ->groupBy($gp_array)
                    ->paginate(20,$pg_array);
            }
            $cols=\Schema::getColumnListing('app_forms');
            $db_cols=\Schema::getColumnListing('new_databanks');
            $db_table='app_forms';
            return view('joins.app_forms',compact('cols','datas','sel','search','db_table','db_cols'));
        }
        else
        {
            return redirect('/');
        }
    }

    public function app_form_generate($ref_no,$doc_list)
    {
        $data=app_form::where('ref_no',$ref_no)->first();
        $img = Image::make(public_path('images/temp.jpg'));
        $font_style=function($font) {
            $font->file(public_path('img_font/times.ttf'));
            $font->size('24');
            $font->color('#000');
        };
        $img->text($data->ref_no, 175, 290,$font_style);
        $img->text($data->name, 265, 357,$font_style);
        $img->text($data->position, 950, 357,$font_style);
        $img->text($data->telephone_no, 265, 410,$font_style);
        $img->text($data->mobile_no, 570, 410,$font_style);
        $img->text($data->religion, 950, 410,$font_style);
        $img->text($data->address, 265, 465,$font_style);
        $img->text($data->contact_address, 265, 520,$font_style);
        $img->text($data->email, 265, 575,$font_style);
        $img->text($data->qualification, 825, 575,$font_style);

        //inserting dob date
        $time_dob = strtotime($data->date_of_birth);
        $dob_y= date('Y', $time_dob);
        $dob_m= date('m', $time_dob);
        $dob_d= date('d', $time_dob);

        $img->text($dob_d[0], 235, 630,$font_style);
        $img->text($dob_d[1], 275, 630,$font_style);
        $img->text($dob_m[0], 330, 630,$font_style);
        $img->text($dob_m[1], 370, 630,$font_style);
        $img->text($dob_y[0], 430, 630,$font_style);
        $img->text($dob_y[1], 470, 630,$font_style);
        $img->text($dob_y[2], 510, 630,$font_style);
        $img->text($dob_y[3], 550, 630,$font_style);

        //checkboxes
        if($data->gender=='male')
        {
            $img->text("■", 796, 630,$font_style);
        }
        else
        {
            $img->text("■", 923, 630,$font_style);
        }

        if($data->marital_status=='single')
        {
            $img->text("■", 224, 681,$font_style);
        }
        else
        {
            $img->text("■", 322, 681,$font_style);
        }

        if($data->spouse_name!=null && $data->spouse_name!="")
        {
            $img->text($data->spouse_name, 650, 683,$font_style);
        }

        $img->text($data->passport_no, 265, 735,$font_style);

        //inserting doi date
        $time_doi = strtotime($data->date_of_issue);
        $doi_y= date('Y', $time_doi);
        $doi_m= date('m', $time_doi);
        $doi_d= date('d', $time_doi);

        $img->text($doi_d[0], 572, 737,$font_style);
        $img->text($doi_d[1], 600, 737,$font_style);
        $img->text($doi_m[0], 642, 737,$font_style);
        $img->text($doi_m[1], 672, 737,$font_style);
        $img->text($doi_y[0], 714, 737,$font_style);
        $img->text($doi_y[1], 743, 737,$font_style);
        $img->text($doi_y[2], 770, 737,$font_style);
        $img->text($doi_y[3], 798, 737,$font_style);

        $img->text($data->place_of_issue, 1005, 735,$font_style);

        //inserting doi date
        $time_doe = strtotime($data->date_of_expiry);
        $doe_y= date('Y', $time_doe);
        $doe_m= date('m', $time_doe);
        $doe_d= date('d', $time_doe);

        $img->text($doe_d[0], 233, 797,$font_style);
        $img->text($doe_d[1], 263, 797,$font_style);
        $img->text($doe_m[0], 313, 797,$font_style);
        $img->text($doe_m[1], 347, 797,$font_style);
        $img->text($doe_y[0], 397, 797,$font_style);
        $img->text($doe_y[1], 433, 797,$font_style);
        $img->text($doe_y[2], 465, 797,$font_style);
        $img->text($doe_y[3], 497, 797,$font_style);

        $img->text($data->height_feet, 645, 790,$font_style);
        $img->text($data->height_inch, 750, 790,$font_style);
        $img->text($data->weight, 975, 790,$font_style);
        $img->text("kg.", 1030, 790,$font_style);

        $img->text($data->parent_name, 265, 845,$font_style);

        if(strlen($data->prior_experience)<85)
        {
            $img->text($data->prior_experience, 265, 895,$font_style);
        }
        else
        {
            $part1=substr($data->prior_experience,0,85)."-";
            $part2=substr($data->prior_experience,85,85);
            $img->text($part1, 265, 895,$font_style);
            $img->text($part2, 265, 945,$font_style);
        }

        if(strlen($doc_list)<85)
        {
            $img->text($doc_list, 265, 995,$font_style);
        }
        else
        {
            $part1=substr($doc_list,0,85)."-";
            $part2=substr($doc_list,85,85);
            $img->text($part1, 265, 995,$font_style);
            $img->text($part2, 265, 1045,$font_style);
        }

        $photo=Image::make(public_path('images/'.$data->photo))->resize(170, 220);
        $img->insert($photo,"",1010,85);

        $path=public_path('/images/app_forms/L'.$data->ref_no.'/app_form_'.$data->ref_no.".jpg");
        $img->save($path,50);


        return;
    }

    public function font_style($font)
    {
        $font->file(public_path('img_font/times.ttf'));
        $font->size('14');
        $font->color('#000');
//        $this->font_style($font);
    }

    public function cv_generate($ref_no)
    {

        $app=app_form::find($ref_no);

        $cv_old=cv::where('ref_no',0)->first();
        $cv=new cv;
        $cv->ref_no=$ref_no;
        $cv->father_name=$cv_old->father_name;
        $cv->mother_name=$cv_old->mother_name;
        $cv->nationality=$cv_old->nationality;
        $cv->languages_known=$cv_old->languages_known;
        $cv->save();
        $asd="<!DOCTYPE html>
            <html>
            <head>";
        $asd.="<style>
                @page{margin: 1in 1.5in 1in 1in;}
                table {
                    border-collapse: collapse;
                }
                
                table, td, th {
                    border: 1px solid black;
                }
                td,th{
                    padding-left: 10px;
                    padding-right: 10px;
                }
                p{
                    margin-bottom:5px;
                    margin-top:5px;
                }
                
                </style>
                </head>";
        $asd.="<body>";
//        $asd.="<img  height='220px' width='170px' src='".str_replace('\\','/',public_path("images/".$app->photo))."' />";
        $asd.="<h3>"."Name: ".$app->name."</h3>";

        $asd.="<br/><br/><br/>";
        $asd.="<div style='padding:20px; border: 2px solid black;'>";
        $asd.="<p><strong>Gender: </strong>". ucfirst($app->gender)."</p>";
        $asd.="<p><strong>Date of Birth: </strong>". $app->date_of_birth."</p>";

        $asd.="<p><strong>Father's Name: </strong>".$cv->father_name."</p>";
        $asd.="<p><strong>Mother's Name: </strong>".$cv->mother_name."</p>";

        $asd.="<p><strong>Address: </strong>". $app->contact_address."</p>";
        $asd.="<p><strong>Marital Status: </strong>". ucfirst($app->marital_status)."</p>";
        $asd.="<p><strong>Height: </strong>". $app->height_feet."ft. ".$app->height_inch."in."."</p>";

        $asd.="<p><strong>Nationality: </strong>".$cv->nationality."</p>";
        $asd.="<p><strong>Languages Known: </strong>".$cv->languages_known."</p>";

        $asd.="<p><strong>Religion: </strong>". $app->religion."</p>";
        $asd.="<p><strong>Passport No.: </strong>". $app->passport_no."</p>";
        $asd.="<p><strong>Email: </strong>". $app->email."</p>";
        if($app->mobile_no!==null && $app->mobile_no!=="")
        {
            $asd.="<p><strong>Contact No.: </strong>". $app->mobile_no."</p>";
        }
        else
        {
            $asd.="<p><strong>Contact No.: </strong>". $app->telephone_no."</p>";
        }

        $asd.="</div>";

        $cv_exps=cv_exp::where('ref_no',0)->get(['name_of_company','designation','start_year','end_year','country','reason_for_leave']);
        $i=1;
        $asd.="<br /><h3>Experience Record:</h3><br />";
        $asd.="<table width='100%'>";
        $asd.="<tr>";
        $asd.="<th>Sn.</th>
               <th>Name of Company</th>  
               <th>Designation</th>  
               <th>Start Year</th>  
               <th>End Year</th>  
               <th>Country</th>  
               <th>Reason for Leave</th>  
              ";
        $asd.="</tr>";
        $new_cv_exp=[];
        $req_exp=['name_of_company','designation','start_year','end_year','country','reason_for_leave'];
        foreach($cv_exps as $cv_exp)
        {
            $asd.="<tr>";
            $new_cv_exp[$i]=new cv_exp;
            $new_cv_exp[$i]->ref_no=$ref_no;
            $new_cv_exp[$i]->exp_id=$i;

            $asd.="<td>".$i."</td>";
            foreach($req_exp as $key)
            {
                if(in_array($key,$req_exp))
                {
                    $new_cv_exp[$i]->$key=$cv_exp->$key;
                    $asd.="<td>".$cv_exp->$key."</td>";
                }
            }
            $new_cv_exp[$i]->save();
            $i++;
            $asd.="</tr>";

        }
        $asd.="</table>";

//        $asd.="<div class='breakNow'></div>";

        $cv_edus=cv_edu::where('ref_no',0)->get(['qualification','name_of_institution','year_of_passing','grades_obtained']);
        $i=1;
        $asd.="<br /><h3>Educational Qualification:</h3><br />";
        $asd.="<table width='100%'>";
        $asd.="<tr>";
        $asd.="<th>Sn.</th>
               <th>Qualification</th>  
               <th>Name of Institute</th>  
               <th>Year of Passing</th>  
               <th>Grades Obtained</th>  
              ";
        $asd.="</tr>";
        $req_edu=['qualification','name_of_institution','year_of_passing','grades_obtained'];
        $new_cv_edu=[];
        foreach($cv_edus as $cv_edu)
        {
            $asd.="<tr>";
            $new_cv_edu[$i]=new cv_edu;
            $new_cv_edu[$i]->ref_no=$ref_no;
            $new_cv_edu[$i]->edu_id=$i;
            $asd.="<td>".$i."</td>";
            foreach($req_edu as $key)
            {
                if(in_array($key,$req_edu))
                {
                    $new_cv_edu[$i]->$key=$cv_edu->$key;
                    $asd.="<td>".$cv_edu->$key."</td>";
                }
            }
            $new_cv_edu[$i]->save();
            $i++;
            $asd.="</tr>";

        }
        $asd.="</table>";
        $asd.="</body>";
        $asd.="</html>";

        $pdf = new Dompdf();
//        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($asd);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $output = $pdf->output();
        $path=public_path('/images/app_forms/L'.$ref_no.'/cv_'.$ref_no.".pdf");
        file_put_contents($path, $output);
//        $pdf->stream(public_path('/images/app_forms/L'.$ref_no.'/cv_'.$ref_no.".pdf"));
        return;
    }
}
