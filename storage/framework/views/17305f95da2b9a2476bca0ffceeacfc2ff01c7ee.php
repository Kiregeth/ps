<?php $__env->startSection('content'); ?>
    <?php  $required=['visitor_name','contact_no','type','visit_purpose'];  ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><h1>Visitor Log</h1></div>
                    <div class="col-xs-6 col-md-6 center-blocks">
                        <form action="/reception" method="POST" name="search-form" id="search-form">
                            <?php echo e(csrf_field()); ?>

                            <h5><label for="search">Search:</label></h5>
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($col!='State' && $col!='created_at' && $col!='updated_at'): ?>
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
                <form id='ajax-form' method='post' action='/'>
                    <?php echo e(csrf_field()); ?>

                <div class="">
                    <table class="table table-striped table-bordered editableTable" >
                        <thead>
                        <tr>
                            <th><a title="Add New" class="btn btn-default" data-toggle="modal" data-target="#modal_add">Add New</a></th>
                            <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($col!='created_at' && $col!='updated_at'): ?>
                                <th><?php echo e($col); ?></th>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <th></th>
                            <td align="center"><a class="btn btn-link" id="quick_add"><strong><i class="fa fa-plus-square"></i></strong></a></td>
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($col!='sn' && $col!='time' && $col!="created_at" && $col!="updated_at"): ?>
                                    <?php if($col=='type'): ?>
                                        <td>
                                            <select id="qa_<?php echo e($col); ?>" name="<?php echo e($col); ?>">
                                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($type->type); ?>"><?php echo e($type->type); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                        </td>
                                    <?php else: ?>
                                        <td><input id="qa_<?php echo e($col); ?>" name="<?php echo e($col); ?>" placeholder="<?php echo e($col); ?> <?php if(in_array($col,$required)): ?>*<?php endif; ?>" required/></td>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td>&nbsp</td>
                        </tr>
                        <?php  $i=0; $datas_array=array();  ?>
                        <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th style="min-width: 100px; text-align: center">
                                    <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                        <a class="btn btn-link" data-toggle="modal" data-target="#modal_<?php echo e($log->sn); ?>"
                                           title="view"><i class="fa fa-eye"></i></a>
                                    </div>
                                </th>
                                <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($col!='created_at' && $col!='updated_at'): ?>
                                        <?php  $datas_array[$i][$col]=$log->$col;  ?>
                                    <td> <?php echo e($log->$col); ?> </td>
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
            <br/>
        </div>
        <div class="export">
            <a target="_blank" class="btn btn-primary" href="/export" onclick="event.preventDefault(); document.getElementById('excel-form').submit();">
                Export to Excel
            </a>

            <form id="excel-form" action="/export" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

                <input type="text" name="file" id="file" value="Visitor Log" />
                <input type="text" name="colsString" id="colsString" value="<?php echo e(serialize($cols)); ?>" />
                <input type="text" name="discardString" id="discardString" value="<?php echo e(serialize(['created_at','updated_at'])); ?>" />
                <input type="text" name="datasString" id="datasString" value="<?php echo e(serialize($datas_array)); ?>" />
            </form>
        </div>
        <?php if($sel!="" && $search!=""): ?>
            <div class="center-block"><?php echo e($logs->appends(['sel' => $sel,'search'=>$search])->render()); ?></div>
        <?php else: ?>
            <div class="center-block"><?php echo e($logs->render()); ?></div>
        <?php endif; ?>
        <br/>
    </div>

    <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modal_<?php echo e($log->sn); ?>" role="dialog">
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
                            <?php if($col!='created_at' && $col!='updated_at'): ?>
                            <div class="row">
                                <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                      for="<?php echo e($log->sn. '_' . $j); ?>"><?php echo e($col); ?>:</label>
                                </div>
                                <div class="col-xs-8 col-md-8"><input
                                            class="form-control"
                                            id="<?php echo e($log->sn. '_' . $j); ?>"
                                            value="<?php echo e($log->$col); ?>" readonly/>
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
    <div class="modal fade" id="modal_add" role="dialog">
        <div class="modal-dialog" >

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" name="frm_add" action="/add">
                    <?php echo e(csrf_field()); ?>

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add New</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="db_table" value="visitor_logs">
                        <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($col!="sn" && $col!="time" && $col!="created_at" && $col!="updated_at"): ?>
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="<?php echo e($col); ?>_0"><?php echo e($col); ?> <?php if(in_array($col,$required)): ?>*<?php endif; ?>:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <?php if($col=='type'): ?>
                                        <select id="qa_<?php echo e($col); ?>" name="<?php echo e($col); ?>" class="form-control">
                                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($type->type); ?>"><?php echo e($type->type); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php else: ?>
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="<?php echo e($col); ?>_0"
                                                name="<?php echo e($col); ?>"
                                                placeholder="Enter <?php echo e($col); ?> here!"
                                        <?php if(in_array($col,$required)): ?> <?php echo e(" required"); ?> <?php endif; ?>
                                        />
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="db_table" value="<?php echo e($db_table); ?>" />
                        <input type="submit" value="Add" name="add" class="btn btn-default" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $("#quick_add").click(function(){
            var colArray =<?php echo json_encode($cols); ?>;
            var data_string='<?php echo e($db_table); ?>,';
            for(var i=0;i<colArray.length;i++)
            {
                if(colArray[i]!=='sn' && colArray[i]!=='time' && colArray[i]!=='created_at' && colArray[i]!=='updated_at')
                {
                    var temp=colArray[i];
                    data_string+=colArray[i]+":"+document.getElementById('qa_'+colArray[i]).value+",";
                }
            }
            data_string=data_string.substr(0,data_string.length-1);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'post',
                url: '/quick_add',
                data: {value:data_string},
                cache: false,
                timeout: 10000,
                success: function (response){
                    if (response) {
                        alert(response);
                    }
                    // Load output into a P
                    else {
                        location.reload(true);
                    }
                }
            });
            return false;
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dash_app',['title'=>'visitor_log'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>