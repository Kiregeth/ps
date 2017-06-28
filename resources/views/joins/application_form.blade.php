@extends('layouts.dash_app',['title'=>'application_form'])

@section('content')
    <style>
        label{
            font-size: 9px;
            font-weight: bold;
        }
        input[type=text],input[type=number],input[type=email],input[type=date]
        {
            font-size: 12px;
            max-height:30px;
        }
        input[type=submit]
        {
            margin-right:60px;
        }
        .form-group{
            margin-bottom:10px;
        }
    </style>
    @php
        $discard=['ref_no','name','position','telephone_no','mobile_no','document_list','photo','created_at','updated_at'];
        $required=['religion','address','contact_address','email','qualification',
                   'dob','gender','marital_status','passport_no','place_of_issue',
                   'date_of_issue','date_of_expiry','height_feet','height_inch','weight',
                   'parent_name','prior_experience'];
        $numeric=['height_feet','height_inch','weight'];
        $date=['date_of_birth','date_of_issue','date_of_expiry']
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-xs-offset-1 col-md-8 col-xs-8">
                <div class="panel panel-info">
                    <div class="panel-heading">Application Form</div>
                    <form class="form-horizontal" name="app_form" id="app_form" method="post" action="/application_form" onsubmit="return validation();" enctype="multipart/form-data">
                        <div class="panel-body">
                            <div class="row col-md-12 col-xs-12">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="ref_no">{{strtoupper(preg_replace('/_+/', ' ', 'ref_no'))}}</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="ref_no" id="ref_no" readonly/>
                                            </div>
                                            <br /><br />

                                        </div>

                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="name">{{strtoupper(preg_replace('/_+/', ' ', 'name'))}} *</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name *" required/>
                                            </div>
                                            <br /><br />
                                        </div>

                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="position">{{strtoupper(preg_replace('/_+/', ' ', 'position'))}} *</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="position" id="position" placeholder="Position *" required/>
                                            </div>
                                            <br /><br />
                                        </div>

                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="telephone_no">{{strtoupper(preg_replace('/_+/', ' ', 'telephone_no'))}} *</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="telephone_no" id="telephone_no" placeholder="Telephone Number *" required/>
                                            </div>
                                            <br /><br />
                                        </div>

                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="mobile_no">{{strtoupper(preg_replace('/_+/', ' ', 'mobile_no'))}} *</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile Number*" required/>
                                            </div>
                                            <br /><br />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pull-right">
                                        <div id="img" class="img center-block">
                                            <img src="{{asset('/images/default.jpg')}}" alt="preview" id="preview" height="144px" width="116px"/>
                                        </div>
                                        <br />
                                        <input class="center-block" type="file" name="photo" id="photo" onchange="readURL(this,'#preview')" />
                                        <p>Image type must be in .jpg format</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($cols as $col)
                                    @if(!in_array($col,$discard))
                                        <div class="form-group col-md-6 row">
                                            <label class="control-label col-md-4" for="{{$col}}">
                                                {{strtoupper(preg_replace("/_+/", " ", "$col"))}}
                                                @if(in_array($col,$required))*@endif
                                            </label>
                                            <div class="col-md-8">
                                                @if($col=='gender')
                                                    <input id="male" type="radio" value="male" name="gender">
                                                    <label class="control-label" for="male">Male</label>
                                                    &nbsp;&nbsp;
                                                    <input id="female" type="radio" value="female" name="gender">
                                                    <label class="control-label" for="female">Female </label>
                                                @elseif($col=='marital_status')
                                                    <input id="single" type="radio" value="single" name="marital_status">
                                                    <label class="control-label" for="single">Single</label>
                                                    &nbsp;&nbsp;
                                                    <input id="married" type="radio" value="married" name="marital_status">
                                                    <label class="control-label" for="married">Married </label>
                                                @else
                                                    @php
                                                        $type="text";
                                                        if($col=='email') $type='email';
                                                        else if (in_array($col,$numeric)) $type='number';
                                                        else if (in_array($col,$date)) $type='date';
                                                        else $type='text';
                                                    @endphp

                                                    <input type="{{$type}}" class="form-control"
                                                           name="{{$col}}" id="{{$col}}"
                                                           placeholder="{{ucfirst(preg_replace("/_+/", " ", "$col"))}} @if(in_array($col,$required))*@endif"
                                                    />
                                                @endif
                                            </div>
                                        </div>

                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="panel-footer">
                            <input type="submit" name="submit" id="submit" class="btn btn-info pull-right" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function readURL(input, temp) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(temp)
                        .attr('src', e.target.result)
                        .width(116)
                        .height(144);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        function validation() {
            var genm = document.getElementById("male");
            var genf = document.getElementById("female");
            var mss=document.getElementById("single");
            var msm=document.getElementById("married");

            if(genm.checked==false && genf.checked==false){
                alert("Select gender");
                return false;
            }
            if(mss.checked==false && msm.checked==false){
                alert("Select marital status");
                return false;
            }
        }
    </script>
@endsection