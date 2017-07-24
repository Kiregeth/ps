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
            min-width: 100px;
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
    </style>
    <?php 
            $fields=['ref_no','date','name','mobile_no','contact_address','email','date_of_birth', 'passport_no',
                   'pp_status','local_agent','la_contact','trade','company','offer_letter_received_date','old_vp_date',
                   'pp_returned_date','pp_resubmitted_date','remarks','db_status'];
            $discard=['photo','db_status','created_at','updated_at','app_status'];
            $date=['date','date_of_birth','offer_letter_received_date','old_vp_date','pp_returned_date','pp_resubmitted_date'];

     ?>
        <div class="container">
            <?php if(session()->has('message')): ?>
                <h3 align="center" class="alert alert-success"><?php echo e(session()->get('message')); ?></h3>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-xs-6 col-md-6"><h1>Databank</h1></div>
                        <div class="col-xs-6 col-md-6 center-blocks">
                            <form action="/new_databank" method="POST" name="search-form" id="search-form">
                                <?php echo e(csrf_field()); ?>

                                <h5><label for="search">Search:</label></h5>
                                <?php  if(strpos($sel, '.') !== false) $sel=substr($sel, strpos($sel, ".") + 1)  ?>
                                <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!in_array($col,$discard)): ?>
                                            <option value="<?php echo e($col); ?>" <?php if($sel===$col): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e(ucwords($col)); ?></option>
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
                                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!in_array($col,$discard)): ?>
                                        <th><?php echo e(strtoupper(preg_replace('/_+/', ' ', $col))); ?></th>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr
                                        <?php if($data->db_status=='vp'): ?>
                                        style='background-color: lightgreen;'
                                        <?php elseif($data->db_status== 'vc'): ?>
                                        style='background-color: lightcoral;'
                                        <?php elseif($data->db_status== 'vf'): ?>
                                        style='background-color: lightblue;'
                                        <?php endif; ?>
                                >

                                    <th style="min-width: 100px; text-align: center">
                                        <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">

                                            <a class="btn btn-link" data-toggle="modal" data-target="#modal_<?php echo e($data->ref_no); ?>"
                                               title="view"><i class="fa fa-eye"></i></a>
                                            <?php if($data->db_status!='vp' && $data->db_status!='vf'): ?>
                                                <a class="btn btn-link" data-toggle="modal" data-target="#visa_<?php echo e($data->ref_no); ?>"
                                                   title="add to visa processing"><i class="fa fa-cc-visa"></i></a>
                                            <?php endif; ?>
                                            <a title="delete" class="delete btn btn-link" name="<?php echo e($data->ref_no); ?>_delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </div>
                                    </th>
                                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!in_array($col,$discard)): ?>
                                            <td> <?php echo e($data->$col); ?> </td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </form>
                </div>
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
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!in_array($col,$discard)): ?>
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="<?php echo e($data->ref_no. '_' . $j); ?>"><?php echo e(ucwords($col)); ?>:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
                                                class="form-control"
                                                id="<?php echo e($data->ref_no. '_' . $j); ?>"
                                                value="<?php echo e($value); ?>" readonly/>
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
        <div class="modal fade" id="visa_<?php echo e($data->ref_no); ?>" role="dialog">
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

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function (){
            $(".delete").click(function(){
                var name=$(this).attr("name");
                var val=parseInt(name.substr(0,name.lastIndexOf('_')));
                var col='ref_no';
                var result = confirm("Want to delete?");
                if (result) {
                    $.ajax({
                        url: '/delete_new',
                        type: 'post',
                        data: {
                            db_table:'<?php echo e($db_table); ?>',
                            w_val: val,
                            w_col: col
                        },
                        cache: false,
                        timeout: 10000,
                        success: function (data){
                            if (data) {
                                alert(data);
                            }
// Load output into a P
                            else {
                                location.reload(true);
//                        $('#notice').text('Deleted');
//                        $('#notice').fadeOut().fadeIn();

                            }
                        }
                    });
                }
            });
        });

        $(function () {
            $("td").dblclick(function () {
                var OriginalContent = $(this).text();
                OriginalContent = OriginalContent.trim();

                $(this).addClass("cellEditing");
                var myCol = $(this).index() - 1;
                var $tr = $(this).closest('tr');
                var myRow = $tr.index() + 1;


                var colArray = <?php echo json_encode($fields); ?> ;
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
                if(colArray[myCol]!=='date')
                {
                    $(this).html(
                        "<input type='"+type+"' placeholder='"+OriginalContent+"' id='"+colArray[myCol]+'_'+myRow+"' name='"+colArray[myCol]+'_'+myRow+"' value='" + OriginalContent + "'/>"+
                        "<input type='hidden' id='where_"+myRow+"_"+myCol+"' name='Ref_No' value='"+id+"' />"
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

            $.ajax({
                url: action,
                type: method,
                data: {
                    db_table:'<?php echo e($db_table); ?>',
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

    </script>


    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dash_app',['title'=>'new_databank'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>