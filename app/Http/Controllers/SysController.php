<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;
use App;
use App\visitor_type;
use App\visitor_log;
use App\databank;
use App\visaprocess;
use App\vrflown;
use App\User;
use App\user_role;
use App\app_form;
use App\cv;
use App\cv_edu;
use App\cv_exp;

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

    public function application_form(Request $request)
    {
        if(\Auth::user()) {
            if (!empty($request->all()))
            {
                $pasa=new app_form();
                $discard=['_token','ref_no','submit','cv_doc'];
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

                $this->app_form_generate($insert_id);

                //uploading files
                if ($request->hasFile('cv_doc')) {
                    $request->file('cv_doc')->storeAs(
                        "/app_forms/".$d, "cv_".$insert_id.".".$request->cv_doc->getClientOriginalExtension()
                    );
                }
                else{
                    $this->cv_generate($insert_id);
                }

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

    public function app_form_generate($ref_no)
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
        $img->text($data->prior_experience, 265, 895,$font_style);
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
        $this->font_style($font);
    }

    public function cv_generate($ref_no)
    {
        $pdf = App::make('dompdf.wrapper');
        $app=app_form::find($ref_no);

        $cv_old=cv::where('ref_no',0)->first();
        $cv=new cv;
        $cv->ref_no=$ref_no;
        $cv->father_name=$cv_old->father_name;
        $cv->mother_name=$cv_old->mother_name;
        $cv->nationality=$cv_old->nationality;
        $cv->languages_known=$cv_old->languages_known;
        $cv->save();


        $asd="<img  height='220px' width='170px' src='".str_replace('\\','/',public_path("images/".$app->photo))."'>";
        $asd.="<div style='margin-left:auto;margin-right:auto'><h3>"."Name: ".$app->name."</h3></div>";

        $asd.="<br/><br/><br/>";
        $asd.="<div style='padding:20px;width:80%;margin-left: auto; margin-right: auto; border: 2px solid black;'>";
        $asd.="Gender: ". $app->gender."<br />";
        $asd.="Date of Birth: ". $app->date_of_birth."<br />";

        $asd.="Father's Name:".$cv->father_name."<br />";
        $asd.="Mother's Name:".$cv->mother_name."<br />";

        $asd.="Address: ". $app->contact_address."<br />";
        $asd.="Marital Status: ". $app->marital_status."<br />";
        $asd.="Height: ". $app->height_feet."ft. ".$app->height_inch."in."."<br />";

        $asd.="Nationality:".$cv->nationality."<br />";
        $asd.="languages_known:".$cv->languages_known."<br />";

        $asd.="Religion: ". $app->religion."<br />";
        $asd.="Passport No.: ". $app->passport_no."<br />";
        $asd.="Email: ". $app->email."<br />";
        if($app->mobile_no!==null && $app->mobile_no!=="")
        {
            $asd.="Contact No.: ". $app->mobile_no."<br />";
        }
        else
        {
            $asd.="Contact No.: ". $app->telephone_no."<br />";
        }

        $asd.="</div>";
        $pdf->loadHTML($asd)->save(public_path('/images/app_forms/L'.$ref_no.'/cv_'.$ref_no.".pdf"));
        return;
    }

}
