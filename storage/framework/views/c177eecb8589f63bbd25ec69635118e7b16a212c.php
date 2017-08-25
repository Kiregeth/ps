<?php $__env->startSection('content'); ?>
    <style>
        table{
            border:solid lightgrey 1px;
        }
        table a{
            margin-top:5px !important;
            margin-bottom:5px !important;
        }
    </style>
    <?php if(in_array('transfer',session('permission'))): ?><strong></strong>
        <div class="container">
            <h1>New Preset Manager</h1>
            <div>
                <h3>1. Databank Preset <a class="btn btn-primary" data-toggle="modal" data-target="#add_databank_preset">Add Preset</a></h3>
                <form action="post">
                <?php echo e(csrf_field()); ?>


                <table class="table-striped" width="80%">
                    <thead>
                        <tr>
                            <th><strong>SN.</strong></th>
                            <th><strong>Preset Name</strong></th>
                            <th><strong>State</strong></th>
                            <th><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  $i=1;  ?>
                    <?php $__currentLoopData = $db_presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i); ?></td>
                        <td><?php echo e($preset->preset_name); ?></td>
                        <td>
                            <?php if($preset->state==='active'): ?>
                                <h5 align="center" class="bg-success" style="width:120px;">Active Now</h5>
                            <?php else: ?>
                                <a class="btn btn-xs btn-primary activate" id="activate_<?php echo e($preset->view_id); ?>_<?php echo e($preset->preset_id); ?>">Activate</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a class="btn btn-xs btn-default" data-toggle="modal" data-target="#db_preset_edit_<?php echo e($preset->preset_id); ?>">Edit</a>
                            <?php if($preset->state!=='active'): ?>
                                <a class="delete btn btn-xs btn-default" id="<?php echo e($preset->preset_id); ?>_dbdelete">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php  $i++;  ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                </form>
            </div>
            <div>
                <h3>2. Visa Process Preset <a class="btn btn-primary" data-toggle="modal" data-target="#add_vp_preset">Add Preset</a></h3>
            </div>
            <div>
                <h3>3. Visa Receive Preset <a class="btn btn-primary" data-toggle="modal" data-target="#add_vr_preset">Add Preset</a></h3>
            </div>
            <div>
                <h3>4. Deployment Preset <a class="btn btn-primary" data-toggle="modal" data-target="#add_deployment_preset">Add Preset</a></h3>
            </div>
        </div>


        <div class="modal fade" id="add_databank_preset" role="dialog">
            <div class="modal-dialog" >

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Databank Field Preset</h4>
                    </div>
                    <form method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body container">
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-2"><label class="control-label" for="db_preset_name">Preset Name:</label></div>
                                <div class="col-md-8"><input name="db_preset_name" id="db_preset_name" class="form-control" required/></div>
                            </div>
                            <br />
                            <br />
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-5 field field-left" id="databank-left">
                                    <ul>
                                        <?php $__currentLoopData = $db_cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($col); ?><span class="pull-right"><i class="fa fa-exchange" aria-hidden="true"></i></span></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="col-md-5 field field-right" id="databank-right">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" style="color:black !important;" id="add_databank_btn">Add</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add_vp_preset" role="dialog">
            <div class="modal-dialog" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Visa Process Field Preset</h4>
                    </div>
                    <form method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body container">
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-2"><label class="control-label" for="vp_preset_name">Preset Name:</label></div>
                                <div class="col-md-8"><input name="vp_preset_name" id="vp_preset_name" class="form-control" required/></div>
                            </div>
                            <br />
                            <br />
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-5 field field-left" id="visaProcess-left">
                                    <ul>
                                        <?php $__currentLoopData = $vp_cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($col); ?><span class="pull-right"><i class="fa fa-exchange" aria-hidden="true"></i></span></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="col-md-5 field field-right" id="visaProcess-right">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" style="color:black !important;" id="add_visa_process_btn">Add</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="add_vr_preset" role="dialog">
            <div class="modal-dialog" >

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Visa Receive Field Preset</h4>
                    </div>
                    <form method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body container">
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-2"><label class="control-label" for="vr_preset_name">Preset Name:</label></div>
                                <div class="col-md-8"><input name="vr_preset_name" id="vr_preset_name" class="form-control" required/></div>
                            </div>
                            <br />
                            <br />
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-5 field field-left" id="visaReceive-left">
                                    <ul>
                                        <?php $__currentLoopData = $vr_cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($col); ?><span class="pull-right"><i class="fa fa-exchange" aria-hidden="true"></i></span></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="col-md-5 field field-right" id="visaReceive-right">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" style="color:black !important;" id="add_visa_receive_btn">Add</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add_deployment_preset" role="dialog">
            <div class="modal-dialog" >

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Deployment Field Preset</h4>
                    </div>
                    <form method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body container">
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-2"><label class="control-label" for="dp_preset_name">Preset Name:</label></div>
                                <div class="col-md-8"><input name="dp_preset_name" id="dp_preset_name" class="form-control" required/></div>
                            </div>
                            <br />
                            <br />
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-5 field field-left" id="deployment-left">
                                    <ul>
                                        <?php $__currentLoopData = $dp_cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($col); ?><span class="pull-right"><i class="fa fa-exchange" aria-hidden="true"></i></span></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="col-md-5 field field-right" id="deployment-right">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" style="color:black !important;" id="add_deployment_btn">Add</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php $__currentLoopData = $db_presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="db_preset_edit_<?php echo e($preset->preset_id); ?>" role="dialog">
            <div class="modal-dialog" >

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Databank Field Preset [ <?php echo e($preset->preset_name); ?> ]</h4>
                    </div>
                    <form method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body container">
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-2"><label class="control-label" for="db_preset_name">Preset Name:</label></div>
                                <div class="col-md-8"><input name="db_preset_name_<?php echo e($preset->preset_id); ?>" value="<?php echo e($preset->preset_name); ?>" placeholder="<?php echo e($preset->preset_name); ?>" id="db_preset_name_<?php echo e($preset->preset_id); ?>" class="form-control" required/></div>
                            </div>
                            <br />
                            <br />
                            <?php  $before_field=explode(',',$preset->preset_field)  ?>
                            <div class="col-md-offset-1 col-md-10 row">
                                <div class="col-md-5 field field-left" id="databank-left-<?php echo e($preset->preset_id); ?>">
                                    <ul>
                                        <?php $__currentLoopData = $db_cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(!in_array($col,$before_field)): ?>
                                                <li><?php echo e($col); ?><span class="pull-right"><i class="fa fa-exchange" aria-hidden="true"></i></span></li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="col-md-5 field field-right" id="databank-right-<?php echo e($preset->preset_id); ?>">
                                    <ul>
                                        <?php $__currentLoopData = $before_field; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($col!='ref_no' && $col!='date' && $col!='app_status'): ?>
                                            <li><?php echo e($col); ?><span class="pull-right"><i class="fa fa-exchange" aria-hidden="true"></i></span></li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" style="color:black !important;" id="db_edit_btn_<?php echo e($preset->preset_id); ?>">Edit</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <script>
            var databankArray=[];
            var visaProcessArray=[];
            var visaReceiveArray=[];
            var deploymentArray=[];

            var tempStr="";

            var dbArray=[];

            <?php $__currentLoopData = $db_presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                dbArray[<?php echo e($preset->preset_id); ?>]=<?php echo json_encode(substr($preset->preset_field,12,strlen($preset->preset_field))); ?>;
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            $(function () {
                $("#databank-left").find('li').on('click',function () {
                    var check=0;
                    for(var i=0;i<databankArray.length;i++)
                    {
                        if(databankArray[i]===$(this).text())
                        {
                            databankArray.splice(i,1);
                            check++;
                            break;
                        }
                    }
                    if(check===0)
                    {
                        databankArray.push($(this).text());
                    }

                    $(this).appendTo('#databank-right ul').on('click',function (e) {
                        var id=e.target.parentNode.parentNode.id;
                        if(id==='databank-right') {
                            $(this).appendTo('#databank-left ul');
                        }

                        else if(id==='databank-left') {

                            $(this).appendTo('#databank-right ul');

                        }
                    });
                });

                $("#databank-right").find('li').on('click',function () {
                    var check=0;
                    for(var i=0;i<databankArray.length;i++)
                    {
                        if(databankArray[i]===$(this).text())
                        {
                            databankArray.splice(i,1);
                            check++;
                            break;
                        }
                    }
                    if(check===0)
                    {
                        databankArray.push($(this).text());
                    }
                    $(this).appendTo('#databank-left ul').on('click',function (e) {
                        var id=e.target.parentNode.parentNode.id;
                        if(id==='databank-right') {
                            $(this).appendTo('#databank-left ul');
                        }
                        else if(id==='databank-left') {
                            $(this).appendTo('#databank-right ul');
                        }
                    });
                });

                $("#visaProcess-left").find('li').on('click',function () {
                    var check=0;
                    for(var i=0;i<visaProcessArray.length;i++)
                    {
                        if(visaProcessArray[i]===$(this).text())
                        {
                            visaProcessArray.splice(i,1);
                            check++;
                            break;
                        }
                    }
                    if(check===0)
                    {
                        visaProcessArray.push($(this).text());
                    }

                    $(this).appendTo('#visaProcess-right ul').on('click',function (e) {
                        var id=e.target.parentNode.parentNode.id;
                        if(id==='visaProcess-right') {
                            $(this).appendTo('#visaProcess-left ul');
                        }

                        else if(id==='visaProcess-left') {

                            $(this).appendTo('#visaProcess-right ul');

                        }
                    });
                });

                $("#visaProcess-right").find('li').on('click',function () {
                    var check=0;
                    for(var i=0;i<visaProcessArray.length;i++)
                    {
                        if(visaProcessArray[i]===$(this).text())
                        {
                            visaProcessArray.splice(i,1);
                            check++;
                            break;
                        }
                    }
                    if(check===0)
                    {
                        visaProcessArray.push($(this).text());
                    }
                    $(this).appendTo('#visaProcess-left ul').on('click',function (e) {
                        var id=e.target.parentNode.parentNode.id;
                        if(id==='visaProcess-right') {
                            $(this).appendTo('#visaProcess-left ul');
                        }
                        else if(id==='visaProcess-left') {
                            $(this).appendTo('#visaProcess-right ul');
                        }
                    });
                });

                $("#visaReceive-left").find('li').on('click',function () {
                    var check=0;
                    for(var i=0;i<visaReceiveArray.length;i++)
                    {
                        if(visaReceiveArray[i]===$(this).text())
                        {
                            visaReceiveArray.splice(i,1);
                            check++;
                            break;
                        }
                    }
                    if(check===0)
                    {
                        visaReceiveArray.push($(this).text());
                    }

                    $(this).appendTo('#visaReceive-right ul').on('click',function (e) {
                        var id=e.target.parentNode.parentNode.id;
                        if(id==='visaReceive-right') {
                            $(this).appendTo('#visaReceive-left ul');
                        }

                        else if(id==='visaReceive-left') {

                            $(this).appendTo('#visaReceive-right ul');

                        }
                    });
                });

                $("#visaReceive-right").find('li').on('click',function () {
                    var check=0;
                    for(var i=0;i<visaReceiveArray.length;i++)
                    {
                        if(visaReceiveArray[i]===$(this).text())
                        {
                            visaReceiveArray.splice(i,1);
                            check++;
                            break;
                        }
                    }
                    if(check===0)
                    {
                        visaReceiveArray.push($(this).text());
                    }
                    $(this).appendTo('#visaReceive-left ul').on('click',function (e) {
                        var id=e.target.parentNode.parentNode.id;
                        if(id==='visaReceive-right') {
                            $(this).appendTo('#visaReceive-left ul');
                        }
                        else if(id==='visaReceive-left') {
                            $(this).appendTo('#visaReceive-right ul');
                        }
                    });
                });

                $("#deployment-left").find('li').on('click',function () {
                    var check=0;
                    for(var i=0;i<deploymentArray.length;i++)
                    {
                        if(deploymentArray[i]===$(this).text())
                        {
                            deploymentArray.splice(i,1);
                            check++;
                            break;
                        }
                    }
                    if(check===0)
                    {
                        deploymentArray.push($(this).text());
                    }

                    $(this).appendTo('#deployment-right ul').on('click',function (e) {
                        var id=e.target.parentNode.parentNode.id;
                        if(id==='deployment-right') {
                            $(this).appendTo('#deployment-left ul');
                        }

                        else if(id==='deployment-left') {

                            $(this).appendTo('#deployment-right ul');

                        }
                    });
                });

                $("#deployment-right").find('li').on('click',function () {
                    var check=0;
                    for(var i=0;i<deploymentArray.length;i++)
                    {
                        if(deploymentArray[i]===$(this).text())
                        {
                            deploymentArray.splice(i,1);
                            check++;
                            break;
                        }
                    }
                    if(check===0)
                    {
                        deploymentArray.push($(this).text());
                    }
                    $(this).appendTo('#deployment-left ul').on('click',function (e) {
                        var id=e.target.parentNode.parentNode.id;
                        if(id==='deployment-right') {
                            $(this).appendTo('#deployment-left ul');
                        }
                        else if(id==='deployment-left') {
                            $(this).appendTo('#deployment-right ul');
                        }
                    });
                })
            });

            //add preset function

            $(function (){
                $("#add_databank_btn").on('click',function (){
                    $.post('/add_preset', {'view_name':'new_databank','preset_name': $('#db_preset_name').val(),'val': 'ref_no,date,app_status,'+databankArray.toString(),'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
                });

                $("#add_visa_process_btn").on('click',function (){
                    $.post('/add_preset', {'view_name':'new_visa_process','preset_name': $('#vp_preset_name').val(),'val': 'ref_no,date,app_status,'+visaProcessArray.toString(),'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
                });

                $("#add_visa_receive_btn").on('click',function (){
                    $.post('/add_preset', {'view_name':'new_visa_receive','preset_name': $('#vr_preset_name').val(),'val': 'ref_no,date,app_status,'+visaReceiveArray.toString(),'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
                });

                $("#add_deployment_btn").on('click',function (){
                    $.post('/add_preset', {'view_name':'new_deployment','preset_name': $('#dp_preset_name').val(),'val': 'ref_no,date,app_status,'+deploymentArray.toString(),'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
                })
            });

            $(function(){
                <?php $__currentLoopData = $db_presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                $("#databank-left-<?php echo e($preset->preset_id); ?>").find('li').on('click',function () {
                    var check=0;
                    var temp=dbArray[<?php echo e($preset->preset_id); ?>].toString().split(',');
                    for(var i=0;i<temp.length;i++)
                    {
                        if(temp[i]===$(this).text())
                        {
                            temp.splice(i,1);
                            check++;
                            break;
                        }
                    }
                    if(check===0)
                    {
                        var temp1=[];
                        temp1=dbArray[<?php echo e($preset->preset_id); ?>].toString().split(',');
                        temp1.push($(this).text());
                        dbArray[<?php echo e($preset->preset_id); ?>]=temp1;
                    }
                    else{
                        dbArray[<?php echo e($preset->preset_id); ?>]=temp;
                    }

                    $(this).appendTo('#databank-right-<?php echo e($preset->preset_id); ?> ul').on('click',function (e) {
                        var id=e.target.parentNode.parentNode.id;
                        if(id==='databank-right-<?php echo e($preset->preset_id); ?>') {
                            $(this).appendTo('#databank-left-<?php echo e($preset->preset_id); ?> ul');
                        }

                        else if(id==='databank-left-<?php echo e($preset->preset_id); ?>') {

                            $(this).appendTo('#databank-right-<?php echo e($preset->preset_id); ?> ul');

                        }
                    });
                });

                $("#databank-right-<?php echo e($preset->preset_id); ?>").find('li').on('click',function () {
                    var check = 0;
                    var temp=dbArray[<?php echo e($preset->preset_id); ?>].toString().split(',');
                    for(var i=0;i<temp.length;i++)
                    {
                        if(temp[i]===$(this).text())
                        {
                            temp.splice(i,1);
                            check++;
                            break;
                        }
                    }


                    if (check === 0) {
                        var temp1=[];
                        temp1=dbArray[<?php echo e($preset->preset_id); ?>].toString().split(',');
                        temp1.push($(this).text());
                        dbArray[<?php echo e($preset->preset_id); ?>]=temp1;
                    }
                    else{
                        dbArray[<?php echo e($preset->preset_id); ?>]=temp;
                    }
                    $(this).appendTo('#databank-left-<?php echo e($preset->preset_id); ?> ul').on('click', function (e) {
                        var id = e.target.parentNode.parentNode.id;
                        if (id === 'databank-right-<?php echo e($preset->preset_id); ?>') {
                            $(this).appendTo('#databank-left-<?php echo e($preset->preset_id); ?> ul');
                        }
                        else if (id === 'databank-left-<?php echo e($preset->preset_id); ?>') {
                            $(this).appendTo('#databank-right-<?php echo e($preset->preset_id); ?> ul');
                        }
                    });
                });
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            });

            $(function() {
                <?php $__currentLoopData = $db_presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                $("#db_edit_btn_<?php echo e($preset->preset_id); ?>").on('click',function (){
                    var temp =dbArray[<?php echo e($preset->preset_id); ?>].toString();
                    if(temp.substr(0,1)===',')
                    {
                        temp=temp.substr(1,temp.length-1);
                    }
                    if(temp.substr(temp.length-1,1)===',')
                    {
                        temp=temp.substr(0,temp.length-2);
                    }
                    dbArray[<?php echo e($preset->preset_id); ?>]=temp.split(',');
                    $.post('/edit_preset', {'view_name':'new_databank','preset_id':<?php echo e($preset->preset_id); ?>,'preset_name': $('#db_preset_name_<?php echo e($preset->preset_id); ?>').val(),'val': 'ref_no,date,app_status,'+dbArray[<?php echo e($preset->preset_id); ?>].toString(),'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
                });

                $("#<?php echo e($preset->preset_id); ?>_dbdelete").on('click',function(){
                    var id=$(this).attr("id");
                    var view_name='new_databank';
                    var preset_id=parseInt(id.substr(0,id.lastIndexOf('_')));

                    var result = confirm("Want to delete?");
                    if (result) {
                        $.post('/delete_preset', {'view_name':view_name,'preset_id':preset_id,'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
                    }
                });
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            });




            //activate function
            $(function (){
                $(".activate").on('click',function (e) {
                    var id = e.target.id.split('_');
                    var view_id=id[1];
                    var preset_id=id[2];
                    $.post('/activate_preset', {'view_id':view_id,'preset_id': preset_id,'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
                })
            });

        </script>

    <?php else: ?>
        <h1>Permission Denied</h1>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dash_app',['title'=>'new_preset'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>