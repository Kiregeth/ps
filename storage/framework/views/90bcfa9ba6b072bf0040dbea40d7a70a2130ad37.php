<?php $__env->startSection('content'); ?>
    <style>
        .modal-dialog {
            width: 60% !important;
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
        .clear {
            display: inline;
            padding: 5px;
            border-radius: 10px;
            background: #9d9d9d;
            color: black;
            text-align: center;
            cursor: pointer;
            margin-left: 5px;
        }
    </style>
    <?php 
        $discard=['ref_no','name','position','telephone_no','mobile_no','document_list','photo','created_at','updated_at'];
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
                                        <input class="center-block" type="file" name="photo" id="photo" onchange="readURL(this,'#preview')" />
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
                                <div class="form-group" id="cv_group">
                                    <a title="Upload Title" class="btn btn-success" name="u_cv_sel" id="u_cv_sel">Upload CV</a>
                                    &nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;
                                    <a title="Generate CV" class="btn btn-success" data-toggle="modal" data-target="#modal_cv">Generate CV</a>
                                </div>



                                <input type="file" name="cv_doc" id="cv_doc" style="display:none;"/>
                            </div>
                            <div class="col-sm-12 col-xs-12 hidden-md hidden-lg">
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
                        <h5 class="modal-title">Add CV Info</h5>
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
                        <h6>Education Qualification:</h6>
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
                                <td><input type="text" name="qualification_1" id="qualification_1" placeholder="Qualification(1) *"></td>
                                <td><input type="text" name="name_of_institute_1" id="name_of_institute_1" placeholder="Name Of Institute(1) *"></td>
                                <td><input type="text" name="year_of_passing" id="year_of_passing" placeholder="Year of Passing(1) *"></td>
                                <td><input type="text" name="grades_obtained" id="grades_obtained" placeholder="Grades Odtained(1) *"></td>
                            </tr>
                            <tr>
                                <td>2. </td>
                                <td><input type="text" name="qualification_2" id="qualification_2" placeholder="Qualification(2)"></td>
                                <td><input type="text" name="name_of_institute_2" id="name_of_institute_2" placeholder="Name Of Institute(2)"></td>
                                <td><input type="text" name="year_of_passing" id="year_of_passing" placeholder="Year of Passing(2)"></td>
                                <td><input type="text" name="grades_obtained" id="grades_obtained" placeholder="Grades Odtained(2)"></td>
                            </tr>
                            <tr>
                                <td>3. </td>
                                <td><input type="text" name="qualification_3" id="qualification_3" placeholder="Qualification(3)"></td>
                                <td><input type="text" name="name_of_institute_3" id="name_of_institute_3" placeholder="Name Of Institute(3)"></td>
                                <td><input type="text" name="year_of_passing" id="year_of_passing" placeholder="Year of Passing(3)"></td>
                                <td><input type="text" name="grades_obtained" id="grades_obtained" placeholder="Grades Odtained(3)"></td>
                            </tr>
                            <tr>
                                <td>4. </td>
                                <td><input type="text" name="qualification_4" id="qualification_4" placeholder="Qualification(4)"></td>
                                <td><input type="text" name="name_of_institute_4" id="name_of_institute_4" placeholder="Name Of Institute(4)"></td>
                                <td><input type="text" name="year_of_passing" id="year_of_passing" placeholder="Year of Passing(4)"></td>
                                <td><input type="text" name="grades_obtained" id="grades_obtained" placeholder="Grades Odtained(4)"></td>
                            </tr>
                            </tbody>
                        </table>
                        <h6>Experience Record:</h6>
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
        }

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
                "<h5 class='bg-success'><div class='btn btn-danger' id='pp_doc_clear' onclick='clear_cv()'>&nbsp;X&nbsp;</div> &nbsp; CV copy uploaded! ("+fileName+") </h5>"
            );
            $('#cv_group').hide();
        });
        function clear_cv() {
            event.preventDefault();
            $('input[type="file"]#cv_doc').val('');
            $('#cv_doc-selected').html('');
            $('#cv_group').show();
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dash_app',['title'=>'application_form'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>