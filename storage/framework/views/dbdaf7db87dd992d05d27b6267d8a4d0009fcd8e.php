<?php $__env->startSection('content'); ?>
    <?php 
        $date=['date_of_birth','offer_letter_received_date','visa_process_date','pp_returned_date','pp_resubmitted_date'];
        $discard=['photo','db_status','created_at','updated_at','app_status','vp_status','id'];
        $vf_fields=['supply_agent','ticket_no','flown_date','demand_no','visa_no'];
        $vf_required=['ticket_no'];
        $vf_date=['wp_expiry','visa_return_date','visa_issue_date','visa_expiry_date','flown_date'];
        $vf_numeric=['ticket_no'];
     ?>
    <div class="container">
        <?php if(session()->has('message')): ?>
            <h3 align="center" class="alert alert-success"><?php echo e(session()->get('message')); ?></h3>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-4 col-md-4"><h1>Visa Receive</h1></div>
                    <form action="/new_visa_receive" method="POST" name="search-form" id="search-form">
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
                        <?php  $i=0; $datas_array=array();  ?>
                        <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr
                                <?php if($data->app_status=='vr'): ?>
                                style='background-color: yellow;'
                                <?php elseif($data->app_status== 'vf'): ?>
                                style='background-color: lightblue;'
                                    <?php endif; ?>>

                                <th style="min-width: 100px; text-align: center">
                                    <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                        <?php if(in_array('view',session('permission'))): ?>
                                            <a class="btn btn-link" data-toggle="modal" data-target="#modal_<?php echo e($data->ref_no); ?>"
                                               title="view"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-link" data-toggle="modal" data-target="#remarks_<?php echo e($data->ref_no); ?>"
                                               title="Remarks"><i class="fa fa-comment"></i></a>
                                        <?php endif; ?>
                                        <?php if(in_array('transfer',session('permission'))): ?>
                                            <a class="cancel btn btn-link" name="<?php echo e($data->ref_no); ?>_cancel"
                                               title="visa cancel"><i class="fa fa-times"></i></a>
                                            <?php if($data->app_status!='vf' && $data->app_status!='vc' && $data->app_status!='vr'): ?>
                                                <a class="btn btn-link" data-toggle="modal" data-target="#visa_receive_<?php echo e($data->ref_no); ?>"
                                                   title="add to visa receive"><i class="fa fa-life-ring"></i></a>
                                            <?php endif; ?>
                                            <?php if($data->app_status==='vr'): ?>
                                                <a class="btn btn-link" data-toggle="modal" data-target="#deploy_<?php echo e($data->ref_no); ?>"
                                                   title="add to deployment"><i class="fa fa-paper-plane"></i></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
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
        </div>
        <div class="export">
            <a target="_blank" class="btn btn-primary" href="/export" onclick="event.preventDefault(); document.getElementById('excel-form').submit();">
                Export to Excel
            </a>

            <form id="excel-form" action="/export" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

                <input type="text" name="file" id="file" value="New Visa Receive" />
                <input type="text" name="colsString" id="colsString" value="<?php echo e(serialize($fields)); ?>" />
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
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!in_array($col,$discard)): ?>
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="<?php echo e($data->ref_no. '_v_' . $col); ?>"><?php echo e(ucwords($col)); ?>:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
                                                class="form-control"
                                                id="<?php echo e($data->ref_no. '_v_' . $col); ?>"
                                                value="<?php echo e($value); ?>" readonly/>
                                    </div>
                                </div>
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
        <div class="modal fade" id="deploy_<?php echo e($data->ref_no); ?>" role="dialog">
            <div class="modal-dialog" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add to Deployment</h4>
                    </div>
                    <form action="/add_to_deployment" method="post" id="data-form-<?php echo e($data->ref_no); ?>">
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
                            <?php $__currentLoopData = $vf_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <label class="control-label pull-right"
                                               for="<?php echo e($data->ref_no. '_' . $col); ?>"><?php echo e(ucwords(preg_replace('/_+/', ' ', $col))); ?>:<?php if(in_array($col,$vf_required)): ?> *<?php endif; ?></label>
                                    </div>
                                    <?php if(in_array($col,$vf_date)): ?>
                                        <?php  $type='date';  ?>
                                    <?php elseif(in_array($col,$vf_numeric)): ?>
                                        <?php  $type='number';  ?>
                                    <?php else: ?>
                                        <?php  $type='text';  ?>
                                    <?php endif; ?>
                                    <div class="col-xs-7 col-md-7"><input
                                                type="<?php echo e($type); ?>"
                                                class="form-control"
                                                id="<?php echo e($data->ref_no. '_' . $col); ?>"
                                                name="<?php echo e($col); ?>"
                                                placeholder="Enter <?php echo e(ucwords(preg_replace('/_+/', ' ', $col))); ?> Date here! <?php if(in_array($col,$vf_required)): ?> * <?php endif; ?>"
                                                <?php if(in_array($col,$vf_required)): ?> required <?php endif; ?>
                                        />
                                    </div>
                                </div>
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
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <script type="text/javascript">
        <?php if(in_array('transfer',session('permission'))): ?>
        $(function (){
            $(".cancel").click(function(){
                var name=$(this).attr("name");
                var val=parseInt(name.substr(0,name.lastIndexOf('_')));
                var col='ref_no';
                var result = confirm("Want to cancel?");
                if (result) {
                    $.post('/cancel_new', {'db_table':'<?php echo e($db_table); ?>','w_val': val,'w_col': col,'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
                }
            });
        });
        <?php endif; ?>

        <?php if(in_array('edit',session('permission'))): ?>
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
            $.post(action, {'db_table':'<?php echo e($db_table); ?>','val': value,'col': column,'w_col': where_col,'w_val': where_val,'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):null});
            return false;
        }
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
<?php echo $__env->make('layouts.dash_app',['title'=>'new_visa_receive'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>