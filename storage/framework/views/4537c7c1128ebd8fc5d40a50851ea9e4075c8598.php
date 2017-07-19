<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><h1>Old Visa Process</h1></div>
                    <div class="col-xs-6 col-md-6 center-blocks">
                        <form action="/visa" method="POST" name="search-form" id="search-form">
                            <?php echo e(csrf_field()); ?>

                            <h5><label for="search">Search:</label></h5>
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($col!='State_Vp' && $col!='created_at' && $col!='updated_at'): ?>)
                                    <option value="<?php echo e($col); ?>" <?php if($sel===$col): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e($col); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <input name="search" id="search" type="text" value="<?php echo e($search); ?>" placeholder="Search"/>

                            <input type="submit" style="display:none" />

                        </form>
                    </div>
                </div>
                <br />
                <form id='ajax-form' method='post' action='/quick_edit'>
                    <?php echo e(csrf_field()); ?>

                    <?php  $required=['Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','Trade','Company'];  ?>
                    <div class="">
                        <table class="table table-striped table-bordered editableTable" id="myTable" >
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($col!='created_at' && $col!='updated_at' && $col!='State_Vp'): ?>
                                        <th><?php echo e($col); ?></th>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </thead>

                            <tbody>
                            <?php  $i=0; $datas_array=array();  ?>
                            <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr
                                        <?php if($data->State_Vp== 'vf'): ?>
                                        style='background-color: lightblue;'
                                        <?php endif; ?>
                                >

                                    <th style="min-width: 100px; text-align: center">
                                        <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">

                                            <a class="btn btn-link" data-toggle="modal" data-target="#modal_<?php echo e($data->Ref_No); ?>"
                                               title="view"><i class="fa fa-eye"></i></a>
                                            <?php if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin'): ?>
                                            <a class="cancel btn btn-link" name="<?php echo e($data->Ref_No); ?>_cancel"
                                               title="Visa Cancel"><i style="color: #000;" class="fa fa-times"></i></a>
                                                <?php if($data->State_Vp!='vf'): ?>
                                                    <a title="Deploy" class="deploy btn btn-link" name="<?php echo e($data->Ref_No); ?>_deploy">
                                                        <i class="fa fa-paper-plane" style="color: #000;" aria-hidden="true"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </th>
                                    <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($col!='created_at' && $col!='updated_at' && $col!='State_Vp'): ?>
                                            <?php  $datas_array[$i][$col]=$data->$col;  ?>
                                            <td> <?php echo e($data->$col); ?> </td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                <?php  $i++;  ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="export">
            <a target="_blank" class="btn btn-primary" href="/export" onclick="event.preventDefault(); document.getElementById('excel-form').submit();">
                Export to Excel
            </a>

            <form id="excel-form" action="/export" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

                <input type="text" name="file" id="file" value="Visa Process" />
                <input type="text" name="colsString" id="colsString" value="<?php echo e(serialize($cols)); ?>" />
                <input type="text" name="discardString" id="discardString" value="<?php echo e(serialize(['State_Vp','created_at','updated_at'])); ?>" />
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
        <div class="modal fade" id="modal_<?php echo e($data->Ref_No); ?>" role="dialog">
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
                            <?php if($col!='created_at' && $col!='updated_at' && $col!='State_Vp'): ?>
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="<?php echo e($data->Ref_No. '_' . $j); ?>"><?php echo e($col); ?>:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
                                                class="form-control"
                                                id="<?php echo e($data->Ref_No. '_' . $j); ?>"
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

    <script type="text/javascript">
        <?php if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin'): ?>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function (){
            $(".deploy").click(function(){
                var name=$(this).attr("name");
                var id=parseInt(name.substr(0,name.lastIndexOf('_')));
                var col='Ref_No';

                $.ajax({
                    url: '/deploy',
                    type: 'post',
                    data: {
                        db_table1:'visaprocesses',
                        db_table2:'vrflowns',
                        db_table3:'databanks',
                        w_id: id,
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
            });
        });

        $(function (){
            $(".cancel").click(function(){
                var name=$(this).attr("name");
                var id=parseInt(name.substr(0,name.lastIndexOf('_')));
                var col='Ref_No';

                $.ajax({
                    url: '/cancel',
                    type: 'post',
                    data: {
                        db_table1:'visaprocesses',
                        db_table2:'vrflowns',
                        db_table3:'databanks',
                        w_id: id,
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
            });
        });

        $(function () {
            $("td").dblclick(function () {
                var OriginalContent = $(this).text();
                OriginalContent=OriginalContent.trim();

                $(this).addClass("cellEditing");
                var myCol = $(this).index()-1;
                var $tr = $(this).closest('tr');
                var myRow = $tr.index()+1;


                var colArray = <?php echo json_encode($cols); ?> ;

                var id=document.getElementById("myTable").rows[myRow].cells[1].innerHTML;


                $(this).html(
                    "<input placeholder='"+OriginalContent+"' id='"+colArray[myCol]+'_'+myRow+"' name='"+colArray[myCol]+'_'+myRow+"' value='" + OriginalContent + "'/>"+
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
                    db_table:'visaprocesses',
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dash_app',['title'=>'visa'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>