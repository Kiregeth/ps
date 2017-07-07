<?php $__env->startSection('content'); ?>
    <style>
        .modal-dialog {
            width: 80% !important;
        }
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

        select{
            width: 100%;
            height:100%;
            overflow:hidden;
            margin-top:8px;
            background-image:none;
            margin-left:10px;
        }

        select option {
            width:100%;
            background: none repeat scroll 0 0 #E5E3E3;
            border: 1px dotted #CCCCCC;
            padding: 10px;
            line-height: 15px;
            text-indent: 3px;
            text-transform: capitalize;
            z-index: -9999;
            cursor: pointer;
        }
        #cv_group{
            margin-left:13px;
            margin-right:auto;
        }
        .selected
        {
            margin-left:13px;
        }

    </style>
    <?php 
        $discard=['ref_no','name','position','telephone_no','mobile_no','document_list','photo','app_status','created_at','updated_at'];
        $required=['religion','address','contact_address','email','qualification',
                   'dob','gender','marital_status','passport_no','place_of_issue',
                   'date_of_issue','date_of_expiry','height_feet','height_inch','weight',
                   'parent_name','prior_experience'];
        $numeric=['height_feet','height_inch','weight'];
        $date=['date_of_birth','date_of_issue','date_of_expiry']
     ?>
    <div class="container">
        <?php if(session()->has('message')): ?>
            <h1 align="center" class="alert alert-success"><?php echo e(session()->get('message')); ?></h1>
        <?php endif; ?>
        <div class="row">
            <div class="col-xs-offset-1 col-md-8 col-xs-8">
                <div class="panel panel-info">
                    <div class="panel-heading"><h5>Application Form</h5></div>
                    <form class="form-horizontal" name="app_form" id="app_form" method="post" action="/application_form" onsubmit="return validation();" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <div class="panel-body">
                            <div class="row col-md-12 col-xs-12">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="ref_no"><?php echo e(strtoupper(preg_replace('/_+/', ' ', 'ref_no'))); ?></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="ref_no" id="ref_no" readonly/>
                                            </div>
                                            <br /><br />

                                        </div>

                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="name"><?php echo e(strtoupper(preg_replace('/_+/', ' ', 'name'))); ?> *</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name *" required/>
                                            </div>
                                            <br /><br />
                                        </div>

                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="position"><?php echo e(strtoupper(preg_replace('/_+/', ' ', 'position'))); ?> *</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="position" id="position" placeholder="Position *" required/>
                                            </div>
                                            <br /><br />
                                        </div>

                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="telephone_no"><?php echo e(strtoupper(preg_replace('/_+/', ' ', 'telephone_no'))); ?> *</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="telephone_no" id="telephone_no" placeholder="Telephone Number *" required/>
                                            </div>
                                            <br /><br />
                                        </div>

                                        <div class="col-md-12">
                                            <label class="control-label col-md-4" for="mobile_no"><?php echo e(strtoupper(preg_replace('/_+/', ' ', 'mobile_no'))); ?> *</label>
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
                                            <img src="<?php echo e(asset('/images/default.jpg')); ?>" alt="preview" id="preview" height="144px" width="116px"/>
                                        </div>
                                        <br />
                                        <input class="center-block" type="file" name="photo" id="photo" onchange="readURL(this,'#preview')" required />
                                        <p>Image type must be in .jpg format</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!in_array($col,$discard)): ?>
                                        <div class="form-group col-md-6 row">
                                            <label class="control-label col-md-4" for="<?php echo e($col); ?>">
                                                <?php echo e(strtoupper(preg_replace("/_+/", " ", "$col"))); ?>

                                                <?php if(in_array($col,$required)): ?>*<?php endif; ?>
                                            </label>
                                            <div class="col-md-8">
                                                <?php if($col=='gender'): ?>
                                                    <input id="male" type="radio" value="male" name="gender">
                                                    <label class="control-label" for="male">Male</label>
                                                    &nbsp;&nbsp;
                                                    <input id="female" type="radio" value="female" name="gender">
                                                    <label class="control-label" for="female">Female </label>
                                                <?php elseif($col=='marital_status'): ?>
                                                    <input id="single" type="radio" value="single" name="marital_status">
                                                    <label class="control-label" for="single">Single</label>
                                                    &nbsp;&nbsp;
                                                    <input id="married" type="radio" value="married" name="marital_status">
                                                    <label class="control-label" for="married">Married </label>
                                                <?php else: ?>
                                                    <?php 
                                                        $type="text";
                                                        if($col=='email') $type='email';
                                                        else if (in_array($col,$numeric)) $type='number';
                                                        else if (in_array($col,$date)) $type='date';
                                                        else $type='text';
                                                     ?>

                                                    <input type="<?php echo e($type); ?>" class="form-control"
                                                           name="<?php echo e($col); ?>" id="<?php echo e($col); ?>"
                                                           placeholder="<?php echo e(ucfirst(preg_replace("/_+/", " ", "$col"))); ?> <?php if(in_array($col,$required)): ?>*<?php endif; ?>"
                                                    />
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div id="doc_upload">
                                <h5><strong>Document Upload</strong></h5>
                                <div id="cv_doc-selected" class="selected"></div>
                                <div id="pp_doc-selected" class="selected"></div>
                                <div id="edu_doc-selected" class="selected"></div>
                                <div id="exp_doc-selected" class="selected"></div>
                                <div id="training_doc-selected" class="selected"></div>
                                <div id="driving_doc-selected" class="selected"></div>

                                <div class="form-group" id="cv_group">
                                    <a title="Upload Title" class="btn btn-success" name="u_cv_sel" id="u_cv_sel">Upload CV *</a>
                                    &nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;
                                    <a title="Generate CV" class="btn btn-success" data-toggle="modal" data-target="#modal_cv">Generate CV *</a>
                                </div>


                                <select size="5" title="upload documents">
                                    <option id="option_pp_doc"> PP Copy* </option>
                                    <option id="option_edu_doc"> Educational Document </option>
                                    <option id="option_exp_doc"> Experience Certificate </option>
                                    <option id="option_training_doc"> Training Certificate </option>
                                    <option id="option_driving_doc"> Driving Licence </option>
                                </select>



                            </div>
                            <div class="hidden-xs hidden-md hidden-lg">
                                
                                <input type="file" name="cv_doc" id="cv_doc" style="display:none;"/>
                                
                                <input type="file" name="pp_doc" id="pp_doc" style="display:none;" required/>
                                
                                <input type="file" name="edu_doc" id="edu_doc" style="display:none;"/>
                                
                                <input type="file" name="exp_doc" id="exp_doc" style="display:none;"/>
                                
                                <input type="file" name="training_doc" id="training_doc" style="display:none;"/>
                                
                                <input type="file" name="driving_doc" id="driving_doc" style="display:none;"/>


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

    <div class="modal fade" id="modal_cv" role="dialog">
        <div class="modal-dialog" >
            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" name="frm_add" action="/temp_cv">
                    <?php echo e(csrf_field()); ?>

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><strong>Add CV Info</strong> (Fields with * is required)</h5>

                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="father_name">Father's Name: * </label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="father_name" name="father_name" placeholder="Enter Father's Name *" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="mother_name">Mother's Name: * </label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="mother_name" name="mother_name" placeholder="Enter Mother's Name *" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="nationality">Nationality: * </label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="nationality" name="nationality" placeholder="Enter Nationality *" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label" for="languages_known">Languages Known: * </label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="languages_known" name="languages_known" placeholder="Enter Langueages Known *" />
                            </div>
                        </div>
                        <h6 style="text-decoration: underline"><strong>Education Qualification:</strong></h6>
                        <table width="100%" class="table-striped">
                            <thead>
                            <tr>
                                <th>Sn.</th>
                                <th>Qualification</th>
                                <th>Name of Institute</th>
                                <th>Passed Year</th>
                                <th>Grades Obtained</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1. *</td>
                                <td><input type="text" name="qualification_1" id="qualification_1" placeholder="Qualification(1) *" required></td>
                                <td><input type="text" name="name_of_institution_1" id="name_of_institution_1" placeholder="Name Of Institute(1) *" required></td>
                                <td><input type="text" name="year_of_passing_1" id="year_of_passing_1" placeholder="Year of Passing(1) *" required></td>
                                <td><input type="text" name="grades_obtained_1" id="grades_obtained_1" placeholder="Grades Obtained(1) *" required></td>
                            </tr>
                            <tr>
                                <td>2. </td>
                                <td><input type="text" name="qualification_2" id="qualification_2" placeholder="Qualification(2)"></td>
                                <td><input type="text" name="name_of_institution_2" id="name_of_institution_2" placeholder="Name Of Institute(2)"></td>
                                <td><input type="text" name="year_of_passing_2" id="year_of_passing_2" placeholder="Year of Passing(2)"></td>
                                <td><input type="text" name="grades_obtained_2" id="grades_obtained_2" placeholder="Grades Obtained(2)"></td>
                            </tr>
                            <tr>
                                <td>3. </td>
                                <td><input type="text" name="qualification_3" id="qualification_3" placeholder="Qualification(3)"></td>
                                <td><input type="text" name="name_of_institution_3" id="name_of_institution_3" placeholder="Name Of Institute(3)"></td>
                                <td><input type="text" name="year_of_passing_3" id="year_of_passing_3" placeholder="Year of Passing(3)"></td>
                                <td><input type="text" name="grades_obtained_3" id="grades_obtained_3" placeholder="Grades Obtained(3)"></td>
                            </tr>
                            <tr>
                                <td>4. </td>
                                <td><input type="text" name="qualification_4" id="qualification_4" placeholder="Qualification(4)"></td>
                                <td><input type="text" name="name_of_institution_4" id="name_of_institution_4" placeholder="Name Of Institute(4)"></td>
                                <td><input type="text" name="year_of_passing_4" id="year_of_passing_4" placeholder="Year of Passing(4)"></td>
                                <td><input type="text" name="grades_obtained_4" id="grades_obtained_4" placeholder="Grades Obtained(4)"></td>
                            </tr>
                            </tbody>
                        </table>
                        <h6 style="text-decoration: underline"><strong>Experience Record:</strong></h6>
                        <table width="100%" class="table-striped">
                            <thead>
                            <tr>
                                <th>Sn.</th>
                                <th>Name of Company</th>
                                <th>Designation</th>
                                <th>Start Year</th>
                                <th>End Year</th>
                                <th>Country</th>
                                <th>Reason for Leave</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1. *</td>
                                <td><input type="text" name="name_of_company_1" id="name_of_company_1" placeholder="Name of Company(1) *" required></td>
                                <td><input type="text" name="designation_1" id="designation_1" placeholder="Designation(1) *" required></td>
                                <td><input type="text" name="start_year_1" id="start_year_1" placeholder="Start Year(1) *" required></td>
                                <td><input type="text" name="end_year_1" id="end_year_1" placeholder="End Year(1) *" required></td>
                                <td><input type="text" name="country_1" id="country_1" placeholder="Country(1) *" required></td>
                                <td><input type="text" name="reason_for_leave_1" id="reason_for_leave_1" placeholder="Reason for Leave(1) *" required></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td><input type="text" name="name_of_company_2" id="name_of_company_2" placeholder="Name of Company(2)"></td>
                                <td><input type="text" name="designation_2" id="designation_2" placeholder="Designation(2)"></td>
                                <td><input type="text" name="start_year_2" id="start_year_2" placeholder="Start Year(2)"></td>
                                <td><input type="text" name="end_year_2" id="end_year_2" placeholder="End Year(2)"></td>
                                <td><input type="text" name="country_2" id="country_2" placeholder="Country(2)"></td>
                                <td><input type="text" name="reason_for_leave_2" id="reason_for_leave_2" placeholder="Reason for Leave(2)"></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td><input type="text" name="name_of_company_3" id="name_of_company_3" placeholder="Name of Company(3)"></td>
                                <td><input type="text" name="designation_3" id="designation_3" placeholder="Designation(3)"></td>
                                <td><input type="text" name="start_year_3" id="start_year_3" placeholder="Start Year(3)"></td>
                                <td><input type="text" name="end_year_3" id="end_year_3" placeholder="End Year(3)"></td>
                                <td><input type="text" name="country_3" id="country_3" placeholder="Country(3)"></td>
                                <td><input type="text" name="reason_for_leave_3" id="reason_for_leave_3" placeholder="Reason for Leave(3)"></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td><input type="text" name="name_of_company_4" id="name_of_company_4" placeholder="Name of Company(4)"></td>
                                <td><input type="text" name="designation_4" id="designation_4" placeholder="Designation(4)"></td>
                                <td><input type="text" name="start_year_4" id="start_year_4" placeholder="Start Year(4)"></td>
                                <td><input type="text" name="end_year_4" id="end_year_4" placeholder="End Year(4)"></td>
                                <td><input type="text" name="country_4" id="country_4" placeholder="Country(4)"></td>
                                <td><input type="text" name="reason_for_leave_4" id="reason_for_leave_4" placeholder="Reason for Leave(4)"></td>
                            </tr>


                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-success" id="generate">Generate</a>
                    </div>
                </form>
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

            if(genm.checked===false && genf.checked===false){
                alert("Select gender");
                return false;
            }
            if(mss.checked===false && msm.checked===false){
                alert("Select marital status");
                return false;
            }
            if($('#cv_doc-selected').html()==="") {
                alert("CV must be generated or uploaded");
                return false;
            }


        }

        //CV Processing
        $('#u_cv_sel').on('click', function() {
            $('#cv_doc').trigger('click');
        });
        $('#cv_doc').bind('change', function() {
            var fileName = '';
            var index = 0;
            fileName = $(this).val();
            index=(fileName.lastIndexOf("\\") + 1);
            fileName=fileName.substr(index);
            $('#cv_doc-selected').html
            (
                "<h5 class='bg-success'><div class='btn btn-danger' id='cv_doc_clear' onclick='clear_cv()'>&nbsp;X&nbsp;</div> &nbsp; CV copy* uploaded! ("+fileName+") </h5>"
            );
            $('#cv_group').hide();
        });
        function clear_cv() {
            event.preventDefault();
            $('input[type="file"]#cv_doc').val('');
            $('#cv_doc-selected').html('');
            $('#cv_group').show();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#generate").on('click',function(){
            var err='';
            if(cv_validate()===true)
            {
                var fields = {}
                    ,varNames = ["father_name","mother_name","nationality","languages_known",
                    "qualification_1","name_of_institution_1","year_of_passing_1","grades_obtained_1",
                    "qualification_2","name_of_institution_2","year_of_passing_2","grades_obtained_2",
                    "qualification_3","name_of_institution_3","year_of_passing_3","grades_obtained_3",
                    "qualification_4","name_of_institution_4","year_of_passing_4","grades_obtained_4",
                    "name_of_company_1","designation_1","start_year_1","end_year_1","country_1","reason_for_leave_1",
                    "name_of_company_2","designation_2","start_year_2","end_year_2","country_2","reason_for_leave_2",
                    "name_of_company_3","designation_3","start_year_3","end_year_3","country_3","reason_for_leave_3",
                    "name_of_company_4","designation_4","start_year_4","end_year_4","country_4","reason_for_leave_4"
                ];
                for (var i=0;i<varNames.length;i+=1) {
                    if(document.getElementById(varNames[i])!==null && document.getElementById(varNames[i]).value!=="")
                    {
                        fields[varNames[i]]=document.getElementById(varNames[i]).value;
                    }
                }

                $.ajax({
                    method: 'post',
                    url: '/cv_save',
                    data: fields,
                    cache: false,
                    timeout: 10000,
                    success: function (response){
                        if (response) {
                            alert(response);
                        }
                        // Load output into a P
                        else {
                            $('#cv_doc-selected').html
                            (
                                "<h5 class='bg-success'><div class='btn btn-danger' id='pp_doc_clear' onclick='clear_cv()'>&nbsp;X&nbsp;</div> &nbsp; CV data entered!</h5>"
                            );
                            $('#cv_group').hide();

                            $('#modal_cv').modal('hide');
                        }
                    }
                });

            }
        });

        function cv_validate()
        {
            var myVariables = {}
                ,varNames = ["father_name","mother_name","nationality","languages_known",
                             "qualification_1","name_of_institution_1","year_of_passing_1","grades_obtained_1",
                             "name_of_company_1","designation_1","start_year_1","end_year_1","country_1","reason_for_leave_1"
                            ];
            for (var i=0;i<varNames.length;i+=1){
                myVariables[varNames[i]] = document.getElementById(varNames[i]);
                if(myVariables[varNames[i]]===null || myVariables[varNames[i]].value==="")
                {
                    myVariables[varNames[i]].placeholder="This field is required!";
                    myVariables[varNames[i]].style.borderColor ="red";
                    myVariables[varNames[i]].focus();
                    return false;
                }
                else
                {
                    myVariables[varNames[i]].style.borderColor ="#EBE9ED";
                }
            }
            return true;
        }

        //Other Doc Processing
        $('#option_pp_doc').on('click', function() {
            $('#pp_doc').trigger('click');
        });
        $('#pp_doc').bind('change', function() {
            var fileName = '';
            var index = 0;
            fileName = $(this).val();
            index=(fileName.lastIndexOf("\\") + 1);
            fileName=fileName.substr(index);
            $('#pp_doc-selected').html
            (
                "<h5 class='bg-success'><div class='btn btn-danger' id='pp_doc_clear' onclick='clear_pp()'>&nbsp;X&nbsp;</div> &nbsp; PP copy* uploaded! ("+fileName+") </h5>"
            );
            $('#option_pp_doc').hide();
        });
        function clear_pp() {
            event.preventDefault();
            $('input[type="file"]#pp_doc').val('');
            $('#pp_doc-selected').html('');
            $('#option_pp_doc').show();
        }
        $('#option_edu_doc').on('click', function() {
            $('#edu_doc').trigger('click');
        });
        $('#edu_doc').bind('change', function() {
            var fileName = '';
            var index = 0;
            fileName = $(this).val();
            index=(fileName.lastIndexOf("\\") + 1);
            fileName=fileName.substr(index);
            $('#edu_doc-selected').html
            (
                "<h5 class='bg-success'><div class='btn btn-danger' id='edu_doc_clear' onclick='clear_edu()'>&nbsp;X&nbsp;</div> &nbsp; Educational Document uploaded! ("+fileName+") </h5>"
            );
            $('#option_edu_doc').hide();
        });
        function clear_edu() {
            event.preventDefault();
            $('input[type="file"]#edu_doc').val('');
            $('#edu_doc-selected').html('');
            $('#option_edu_doc').show();
        }
        $('#option_exp_doc').on('click', function() {
            $('#exp_doc').trigger('click');
        });
        $('#exp_doc').bind('change', function() {
            var fileName = '';
            var index = 0;
            fileName = $(this).val();
            index=(fileName.lastIndexOf("\\") + 1);
            fileName=fileName.substr(index);
            $('#exp_doc-selected').html
            (
                "<h5 class='bg-success'><div class='btn btn-danger' id='exp_doc_clear' onclick='clear_exp()'>&nbsp;X&nbsp;</div> &nbsp; Experience certificate uploaded! ("+fileName+") </h5>"
            );
            $('#option_exp_doc').hide();
        });
        function clear_exp() {
            event.preventDefault();
            $('input[type="file"]#exp_doc').val('');
            $('#exp_doc-selected').html('');
            $('#option_exp_doc').show();
        }
        $('#option_training_doc').on('click', function() {
            $('#training_doc').trigger('click');
        });
        $('#training_doc').bind('change', function() {
            var fileName = '';
            var index = 0;
            fileName = $(this).val();
            index=(fileName.lastIndexOf("\\") + 1);
            fileName=fileName.substr(index);
            $('#training_doc-selected').html
            (
                "<h5 class='bg-success'><div class='btn btn-danger' id='training_doc_clear' onclick='clear_training()'>&nbsp;X&nbsp;</div> &nbsp; Training Document uploaded! ("+fileName+") </h5>"
            );
            $('#option_training_doc').hide();
        });
        function clear_training() {
            event.preventDefault();
            $('input[type="file"]#training_doc').val('');
            $('#training_doc-selected').html('');
            $('#option_training_doc').show();
        }
        $('#option_driving_doc').on('click', function() {
            $('#driving_doc').trigger('click');
        });
        $('#driving_doc').bind('change', function() {
            var fileName = '';
            var index = 0;
            fileName = $(this).val();
            index=(fileName.lastIndexOf("\\") + 1);
            fileName=fileName.substr(index);
            $('#driving_doc-selected').html
            (
                "<h5 class='bg-success'><div class='btn btn-danger' id='driving_doc_clear' onclick='clear_driving()'>&nbsp;X&nbsp;</div> &nbsp; Driving licence uploaded! ("+fileName+") </h5>"
            );
            $('#option_driving_doc').hide();
        });
        function clear_driving() {
            event.preventDefault();
            $('input[type="file"]#driving_doc').val('');
            $('#driving_doc-selected').html('');
            $('#option_driving_doc').show();
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dash_app',['title'=>'application_form'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>