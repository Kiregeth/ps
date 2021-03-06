<?php $__env->startSection('content'); ?>
    <style>
        .btn-tbl{
            font-size:10px;
            font-weight:bold;
            padding:2px 10px;
            margin-top:5px;
            margin-bottom:5px;
        }
    </style>
    <div class="container">
    <?php 
        $fields=['ref_no','name','passport_no','trade'];
        $discard=[];
     ?>
    <?php if(session()->has('message')): ?>
        <h3 align="center" class="alert alert-success"><?php echo e(session()->get('message')); ?></h3>
    <?php endif; ?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-4  col-md-4"><h1>Interview List</h1></div>
                    <form action="/interview" method="POST" name="search-form" id="search-form">
                        <?php echo e(csrf_field()); ?>

                        <div class="col-xs-4 col-md-4 ">
                            <h5 align="center"><label for="search">Search:</label></h5>
                            <?php  if(strpos($sel, '.') !== false) $sel=substr($sel, strpos($sel, ".") + 1)  ?>
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!in_array($col,$discard)): ?>
                                        <option value="<?php echo e($col); ?>" <?php if($sel===$col): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e(ucwords($col)); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <input name="search" id="search" type="text" value="<?php echo e($search); ?>" placeholder="Search"/>

                        </div>
                        <div class="col-xs-4 col-md-4">
                            <h5><label for="page_size">Page Size:</label></h5>
                            <select name="page_size" class="selectpicker" data-style="btn-info">
                                <option value="20" <?php if($limit==20): ?> selected <?php endif; ?>>20</option>
                                <option value="40" <?php if($limit==40): ?> selected <?php endif; ?>>40</option>
                                <option value="60" <?php if($limit==60): ?> selected <?php endif; ?>>60</option>
                                <option value="80" <?php if($limit==80): ?> selected <?php endif; ?>>80</option>
                            </select>
                            <input type="submit" value="Go" />
                        </div>
                    </form>
                </div>
                <br/>
            </div>
        </div>
        <br/>
        <form id='ajax-form' method='post'>
            <?php echo e(csrf_field()); ?>

            <table style="width: 85% !important" class="table table-striped table-bordered editableTable" id="myTable">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!in_array($col,$discard)): ?>
                            <th><?php echo e(strtoupper(preg_replace('/_+/', ' ', $col))); ?></th>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
                </thead>
                <tbody>
                <?php  $i=0; $datas_array=array();  ?>
                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th style="min-width: 100px; text-align: center">
                            <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                <?php if(in_array('view',session('permission'))): ?>
                                    <a class="btn btn-link" data-toggle="modal" data-target="#modal_<?php echo e($data->ref_no); ?>"
                                       title="view"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-link" data-toggle="modal" data-target="#remarks_<?php echo e($data->ref_no); ?>"
                                       title="Remarks"><i class="fa fa-comment"></i></a>
                                <?php endif; ?>
                                <?php if(in_array('transfer',session('permission'))): ?>

                                <?php endif; ?>
                            </div>
                        </th>
                        <th style="background-color: lightgrey">
                            <div class="center-block" style="margin-top: auto;margin-bottom: auto; text-align: center;">
                                <a class="btn btn-sm btn-success btn-tbl" data-toggle="modal" data-target="#visa_<?php echo e($data->ref_no); ?>"
                                   title="add to visa processing">Accept</a>
                                <a class="reject btn btn-sm btn-danger btn-tbl" name="<?php echo e($data->ref_no); ?>_reject">Reject</a>
                            </div>
                        </th>
                        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!in_array($col,$discard)): ?>
                                <?php  $datas_array[$i][$col]=$data->$col;  ?>
                                <td> <?php echo e($data->$col); ?> </td>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php  $i++;  ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </form>
    </div>


    <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modal_<?php echo e($data->ref_no); ?>" role="dialog">
            <div class="modal-dialog" >

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Data View</h4>
                    </div>
                    <div class="modal-body">
                        <?php  $j=0; ?>
                        <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($col!='created_at' && $col!='updated_at' && $col!='app_status'): ?>
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="<?php echo e($data->ref_no. '_' . $j); ?>"><?php echo e($col); ?>:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
                                                class="form-control"
                                                id="<?php echo e($data->ref_no. '_' . $j); ?>"
                                                value="<?php echo e($data->$col); ?>" readonly/>
                                    </div>
                                </div>
                                <?php  $j++;  ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="remarks_<?php echo e($data->ref_no); ?>" role="dialog">
            <div class="modal-dialog" >

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Remarks [Ref.No - <?php echo e($data->ref_no); ?>]</h4>
                    </div>
                    <form class="frm_remark" method="post">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body" >
                            <div id="mb_<?php echo e($data->ref_no); ?>" class="mb-class">
                                <?php $__currentLoopData = $remarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($remark->ref_no===$data->ref_no): ?>
                                        <div class="bg-primary row dbt">
                                            <div class="col-md-8" style="word-wrap: break-word;"><?php echo e($remark->remark); ?></div>
                                            <div class="col-md-2" style="font-weight:bold;">[<?php echo e($remark->user); ?>]</div>
                                            <div class="col-md-2"><?php echo e($remark->time); ?></div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="row dbt">
                                <div class="col-md-12"><input style="margin-top:10px !important;" autofocus class="form-control" placeholder="Add Remark" id="in_<?php echo e($data->ref_no); ?>"></div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="ansar_<?php echo e($data->ref_no); ?>" role="dialog">
            <div class="modal-dialog" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add to Visa Processing</h4>
                    </div>
                    <form action="/add_to_visa" method="post" id="data-fom-<?php echo e($data->ref_no); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="<?php echo e($data->ref_no. '_' . 'ref_no'); ?>">Ref No:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            type="text"
                                            class="form-control"
                                            id="<?php echo e($data->ref_no. '_' . 'ref_no'); ?>"
                                            name="ref_no"
                                            placeholder="Enter Ref No here!"
                                            value="<?php echo e($data->ref_no); ?>"  readonly />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="<?php echo e($data->ref_no. '_' . 'visa_process_date'); ?>">Visa Process Date*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            type="date"
                                            class="form-control"
                                            id="<?php echo e($data->ref_no. '_' . 'visa_process_date'); ?>"
                                            name="visa_process_date"
                                            placeholder="Enter Visa Process Date here!"
                                            required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="<?php echo e($data->ref_no. '_' . 'trade'); ?>">Trade*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            class="form-control"
                                            id="<?php echo e($data->ref_no. '_' . 'trade'); ?>"
                                            name="trade"
                                            placeholder="Enter trade here! *"
                                            value="<?php echo e($data->trade); ?>"
                                            required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="<?php echo e($data->ref_no. '_' . 'company'); ?>">Companye*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            class="form-control"
                                            id="<?php echo e($data->ref_no. '_' . 'company'); ?>"
                                            name="company"
                                            placeholder="Enter company here!"
                                            value="<?php echo e($data->company); ?>"
                                            required />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-default" value="Add"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="remarks_<?php echo e($data->ref_no); ?>" role="dialog">
            <div class="modal-dialog" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add to Visa Processing</h4>
                    </div>
                    <form action="/add_to_visa" method="post" id="data-fom-<?php echo e($data->ref_no); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="<?php echo e($data->ref_no. '_' . 'ref_no'); ?>">Ref No:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            type="text"
                                            class="form-control"
                                            id="<?php echo e($data->ref_no. '_' . 'ref_no'); ?>"
                                            name="ref_no"
                                            placeholder="Enter Ref No here!"
                                            value="<?php echo e($data->ref_no); ?>"  readonly />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="<?php echo e($data->ref_no. '_' . 'visa_process_date'); ?>">Visa Process Date*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            type="date"
                                            class="form-control"
                                            id="<?php echo e($data->ref_no. '_' . 'visa_process_date'); ?>"
                                            name="visa_process_date"
                                            placeholder="Enter Visa Process Date here!"
                                            required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="<?php echo e($data->ref_no. '_' . 'trade'); ?>">Trade*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            class="form-control"
                                            id="<?php echo e($data->ref_no. '_' . 'trade'); ?>"
                                            name="trade"
                                            placeholder="Enter trade here! *"
                                            value="<?php echo e($data->trade); ?>"
                                            required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="<?php echo e($data->ref_no. '_' . 'company'); ?>">Companye*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            class="form-control"
                                            id="<?php echo e($data->ref_no. '_' . 'company'); ?>"
                                            name="company"
                                            placeholder="Enter company here!"
                                            value="<?php echo e($data->company); ?>"
                                            required />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-default" value="Add"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script>

    <?php if(in_array('transfer',session('permission'))): ?>
    $(function (){
        $(".reject").click(function(){
            var name=$(this).attr("name");
            var val=parseInt(name.substr(0,name.lastIndexOf('_')));
            var col='ref_no';
            var result = confirm("Want to reject?");
            if (result) {
                $.post('/reject', {'w_val': val,'w_col': col,'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
            }


        });
    });


    <?php endif; ?>

    $('.frm_remark').bind('keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
    e.preventDefault();
    var id=e.target.id.substring( e.target.id.indexOf('_') + 1 );
    var now= (new Date ((new Date((new Date(new Date())).toISOString() )).getTime() - ((new Date()).getTimezoneOffset()*60000))).toISOString().slice(0, 19).replace('T', ' ');
    var val=$("#in_"+id).val();
    //            var now=new Date();
    //            var mnth;
    //            if((now.getDate()+1)<10)
    //                mnth='0'+now.getDate()+1;
    //            else
    //                mnth=now.getDate()+1;
    //            var nowString=now.getFullYear()+"-"+mnth+"-"+now.getDate()+" "+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();

    $.post('/add_remark', {'id':id,'remark': val,'_token':$('input[name=_token]').val()}, function(response) {
    if(response)
    {
    alert(response)
    }
    else
    {
    $("#mb_"+id).prepend(
    "<div class='bg-primary row dbt'>"+
        "<div class='col-md-8' style='word-wrap: break-word;'>"+val+"</div>"+
        "<div class='col-md-2' style='font-weight: bold;'>"+"[<?php echo e(Auth::user()->uname); ?>]"+"</div>"+
        "<div class='col-md-2'>"+now+"</div>"+
        "</div>"
    );
    }
    });
    document.getElementById("in_"+id).value="";
    //            var modal_div = document.getElementById("my_modal");
    //            var new_element = document.createElement("div");
    //            modal_div.appendChild(new_element);
    return false;
    }
    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dash_app',['title'=>'interview'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>