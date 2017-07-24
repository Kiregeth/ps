<?php $__env->startSection('content'); ?>
    <style>
        * {
            font-family:Consolas;
        }
        .modal-dialog {
            width: 80% !important;
        }
        .modal-content input[type=text], .modal-content input[type=number], .modal-content select {
            max-height: 20px;
            padding: 0 0 0 10px;
            margin:2px;
        }
        .modal-content input[readonly]
        {
            background-color:grey;
            max-height:20px;
            color:white;
        }
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        .fa{
            color:#000;
        }
        th,td{
            padding:0 !important;
            padding-left:5px !important;
            padding-right:5px !important;
            min-width: 70px;
        }

        a.btn.btn-link{
            padding:0;
        }

        .caret{
            display:none;
        }
        .select
        {
            color:blue !important;
        }

        .btn-info
        {
            padding:5px;
        }
        .form-control
        {
            max-height: 20px;
        }
        .export{
             padding-top:20px;
             padding-bottom:20px;
         }

    </style>
    <?php 
        $discard=['photo','app_status','created_at','updated_at','date','db_status'];
        $date=['date_of_birth','date_of_issue','date_of_expiry'];
        $db_date_field=['offer_letter_received_date','old_vp_date','pp_returned_date','pp_resubmitted_date'];
        $db_required=['trade','company'];
     ?>
    <div class="container">
        <?php if(session()->has('message')): ?>
            <h3 align="center" class="alert alert-success"><?php echo e(session()->get('message')); ?></h3>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><h1>Application Forms</h1></div>
                    <div class="col-xs-6 col-md-6 center-blocks">
                        <form action="/app_forms" method="POST" name="search-form" id="search-form">
                            <?php echo e(csrf_field()); ?>

                            <h5><label for="search">Search:</label></h5>
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!in_array($col,$discard)): ?>
                                        <option value="<?php echo e($col); ?>" <?php if($sel===$col): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e($col); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <input name="search" id="search" type="text" value="<?php echo e($search); ?>" placeholder="Search"/>

                            <input type="submit" style="display:none" />

                        </form>
                    </div>
                </div>
                <br/>
                <form id='ajax-form' method='post' action='/quick_edit_new'>
                    <?php echo e(csrf_field()); ?>

                    <table class="table table-striped table-bordered editableTable" id="myTable">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!in_array($col,$discard)): ?>
                                    <th><?php echo e(strtoupper(preg_replace('/_+/', ' ', $col))); ?></th>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        </thead>

                        <tbody>
                        <?php  $i=0; $datas_array=array();  ?>
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr <?php if($data->app_status==='db'): ?>
                                style="background-color: #BED661;color:white;"
                                <?php elseif($data->app_status=='vp'): ?>
                                style='background-color: lightgreen;'
                                <?php elseif($data->app_status== 'vc'): ?>
                                style='background-color: lightcoral;'
                                <?php elseif($data->app_status== 'vf'): ?>
                                style='background-color: lightblue;'
                                    <?php endif; ?>>
                                <th style="min-width: 100px; text-align: center">
                                    <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                        <a class="btn btn-link" data-toggle="modal" data-target="#modal_<?php echo e($data->ref_no); ?>"
                                           title="view"><i class="fa fa-eye"></i></a>
                                        <?php if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin'): ?>
                                            <?php if($data->app_status!=='db' && $data->app_status!=='vc' && $data->app_status!=='vp' && $data->app_status!=='vf'): ?>
                                                <a class="btn btn-link" data-toggle="modal" data-target="#db_<?php echo e($data->ref_no); ?>"
                                                   title="add to databank"><i class="fa fa-database"></i></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </th>
                                <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            <br/>
        </div>
        <div class="export">
                <a target="_blank" class="btn btn-primary" href="/export" onclick="event.preventDefault(); document.getElementById('excel-form').submit();">
                    Export to Excel
                </a>

                <form id="excel-form" action="/export" method="POST" style="display: none;">
                    <?php echo e(csrf_field()); ?>

                    <input type="text" name="file" id="file" value="App Form" />
                    <input type="text" name="colsString" id="colsString" value="<?php echo e(serialize($cols)); ?>" />
                    <input type="text" name="discardString" id="discardString" value="<?php echo e(serialize($discard)); ?>" />
                    <input type="text" name="datasString" id="datasString" value="<?php echo e(serialize($datas_array)); ?>" />
                </form>
            </div>
        <?php if($sel!="" && $search!=""): ?>
            <div class="center-block"><?php echo e($datas->appends(['sel' => $sel,'search'=>$search])->render()); ?></div>
        <?php else: ?>
            <div class="center-block"><?php echo e($datas->render()); ?></div>
        <?php endif; ?>
        <br/>

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
                            <?php if(!in_array($col,$discard)): ?>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3"><label class="control-label pull-right"
                                                                          for="<?php echo e($data->ref_no. '_' . $j); ?>"><?php echo e(ucfirst(preg_replace('/_+/', ' ', $col))); ?>:</label>
                                    </div>
                                    <div class="col-xs-7 col-md-7"><input
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
        <div class="modal fade" id="db_<?php echo e($data->ref_no); ?>" role="dialog">
            <div class="modal-dialog" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add to Databank</h4>
                    </div>
                    <form action="/add_to_db" method="post" id="data-fom-<?php echo e($data->ref_no); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-body">
                            <?php  $j=0; ?>
                            <?php $__currentLoopData = $db_cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!in_array($col,$discard)): ?>
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3"><label class="control-label pull-right"
                                                                              for="<?php echo e($data->ref_no. '_' . $j); ?>"><?php echo e(ucfirst(preg_replace('/_+/', ' ', $col))); ?><?php if(in_array($col,$db_required)): ?>*<?php endif; ?>:</label>
                                        </div>
                                        <?php if(in_array($col,$db_date_field)): ?>
                                            <div class="col-xs-7 col-md-7"><input
                                                        type="date"
                                                        class="form-control"
                                                        id="<?php echo e($data->ref_no. '_' . $j); ?>"
                                                        name="<?php echo e($col); ?>"
                                                        placeholder="Enter <?php echo e(ucfirst(preg_replace('/_+/', ' ', $col))); ?> here!<?php if(in_array($col,$db_required)): ?>*<?php endif; ?>"
                                                        <?php if($col==='ref_no'): ?>value="<?php echo e($data->ref_no); ?>"  readonly <?php endif; ?> <?php if(in_array($col,$db_required)): ?> required <?php endif; ?>/>
                                            </div>
                                        <?php else: ?>
                                            <div class="col-xs-7 col-md-7"><input
                                                        class="form-control"
                                                        type="text"
                                                        id="<?php echo e($data->ref_no. '_' . $j); ?>"
                                                        name="<?php echo e($col); ?>"
                                                        placeholder="Enter <?php echo e(ucfirst(preg_replace('/_+/', ' ', $col))); ?> here!<?php if(in_array($col,$db_required)): ?>*<?php endif; ?>"
                                                        <?php if($col==='ref_no'): ?>value="<?php echo e($data->ref_no); ?>"  readonly <?php endif; ?> <?php if(in_array($col,$db_required)): ?> required <?php endif; ?>/>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php  $j++;  ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-default" value="Add"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <script>
            <?php if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin'): ?>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(function () {
                $("td").dblclick(function () {
                    var OriginalContent = $(this).text();
                    OriginalContent = OriginalContent.trim();

                    $(this).addClass("cellEditing");
                    var myCol = $(this).index() - 1;
                    var $tr = $(this).closest('tr');
                    var myRow = $tr.index() + 1;


                    var colArray = <?php echo json_encode($cols); ?> ;
                    var dateArray= <?php echo json_encode($date); ?>;

                    var id = document.getElementById("myTable").rows[myRow].cells[1].innerHTML;
                    var type;
                    var x;
                    var count=0;
                    for(x in dateArray)
                    {
                        if(colArray[myCol]===dateArray[x])
                        {
                            count++;
                            break;
                        }
                    }
                    if(count>0) type='date'; else type='text';
                    if(colArray[myCol]==='email') type='email';

                    if(colArray[myCol]!=='ref_no' && colArray[myCol]!=='date')
                    {
                        $(this).html(
                            "<input type='"+type+"' placeholder='"+OriginalContent+"' id='"+colArray[myCol]+'_'+myRow+"' name='"+colArray[myCol]+'_'+myRow+"' value='" + OriginalContent + "'/>"+
                            "<input type='hidden' id='where_"+myRow+"_"+myCol+"' name='ref_no' value='"+id+"' />"
                        );

                        $(this).children().first().focus();

                        $(this).children().first().keypress(function (e) {
                            if (e.which == 13) {
                                var res=autosubmit(colArray,myCol,myRow);
                                var val=document.getElementById(colArray[myCol]+'_'+myRow).value;
                                $(this).parent().text(val);
                                $(this).parent().removeClass("cellEditing");
                            }
                        });

                        $(this).children().first().blur(function(){

                            var res=autosubmit(colArray,myCol,myRow);
                            var val=document.getElementById(colArray[myCol]+'_'+myRow).value;
                            $(this).parent().text(val);
                            $(this).parent().removeClass("cellEditing");
                        });
                    }
                });
            });

            function autosubmit(colArray,myCol,myRow)
            {

                var input=document.getElementById(colArray[myCol]+'_'+myRow);

                var column = input.name;
                column=column.substr(0, column.lastIndexOf('_'));
                var value = input.value;
                var form = document.getElementById('ajax-form');
                var method = form.method;
                var action = form.action;



                var where=document.getElementById('where_'+myRow+'_'+myCol);
                var where_val = where.value;
                var where_col = where.name;

//                alert(action+': '+method+'        '+column+': '+value+'   '+where_col+' '+where_val);
                $.ajax({
                    url: action,
                    type: method,
                    data: {
                        val: value,
                        col: column,
                        w_col: where_col,
                        w_val: where_val
                    },
                    cache: false,
                    timeout: 10000,
                    success: function (data){
                        if (data) {
                            alert(data);
                        }
                        // Load output into a P
                        else {


                        }
                    }
                });
                // Prevent normal submission of form
                return false;
            }
            <?php endif; ?>
        </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dash_app',['title'=>'app_forms'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>