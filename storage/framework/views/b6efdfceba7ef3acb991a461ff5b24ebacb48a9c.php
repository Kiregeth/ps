<?php $__env->startSection('content'); ?>
    <style>
        * {
            font-family:Consolas;
        }
        .modal-dialog {
            width: 80% !important;
        }
        .modal-content input[type=text], .modal-content input[type=number] {
            max-height: 24px;
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
        th .center-block a{
            padding:0 !important;
            margin:0 !important;
        }
        .fa{
            color: #000;
        }
        th,td{
            padding:0 !important;
            padding-left:5px !important;
            padding-right:5px !important;
            min-width: 50px !important;
            max-width:200px !important;
        }
        thead th{
            padding:10px !important;
            max-width:200px !important;
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
    </style>
    <?php 
        $discard=['created_at','updated_at','password','remember_token'];
        $opt_roles=[];
        foreach($roles as $role)
        {
            $opt_roles[]=$role->role;
        }
     ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><h1>Users</h1></div>
                    <div class="col-xs-6 col-md-6 center-blocks">
                        <form action="/users" method="POST" name="search-form" id="search-form">
                            <?php echo e(csrf_field()); ?>

                            <h5><label for="search">Search:</label></h5>
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!in_array($col,$discard)): ?>)
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
                <form id='ajax-form' method='post' action='/quick_edit'>
                    <?php echo e(csrf_field()); ?>

                    <div class="">
                        <table class="table table-striped table-bordered editableTable" id="myTable" >
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!in_array($col,$discard)): ?>
                                        <th><?php echo e(strtoupper($col)); ?></th>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            </thead>

                            <tbody>

                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th style="text-align: center">
                                        <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">

                                            <a class="btn btn-link" data-toggle="modal" data-target="#modal_<?php echo e($user->id); ?>"
                                               title="view"><i class="fa fa-eye"></i></a>
                                            <a title="delete" class="delete btn btn-link" name="<?php echo e($user->id); ?>_delete-<?php echo e($user->uname); ?>">
                                                <i class="fa fa-trash-o"></i></a>

                                        </div>
                                    </th>
                                    <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!in_array($col,$discard)): ?>
                                            <td> <?php echo e($user->$col); ?> </td>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modal_<?php echo e($user->id); ?>" role="dialog">
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
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="<?php echo e($user->id. '_' . $j); ?>"><?php echo e($col); ?>:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
                                                class="form-control"
                                                id="<?php echo e($user->id. '_' . $j); ?>"
                                                value="<?php echo e($user->$col); ?>" readonly/>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function (){
            $(".delete").click(function(){
                var name = $(this).attr("name");
                var id = parseInt(name.substr(0, name.lastIndexOf('_')));
                var uname=name.substr(name.lastIndexOf('-')+1,name.length);
                var result = confirm("Are you sure you want to delete user '"+uname+"'");
                if (result) {

                    var col = 'id';


                    $.ajax({
                        url: '/delete',
                        type: 'post',
                        data: {
                            db_table: '<?php echo e($db_table); ?>',
                            w_id: id,
                            w_col: col
                        },
                        cache: false,
                        timeout: 10000,
                        success: function (data) {
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
                OriginalContent=OriginalContent.trim();

                $(this).addClass("cellEditing");
                var myCol = $(this).index()-1;
                var $tr = $(this).closest('tr');
                var myRow = $tr.index()+1;


                var colArray = <?php echo json_encode($cols); ?> ;

                var id=document.getElementById("myTable").rows[myRow].cells[1].innerHTML;

                var cname=$('#myTable').find('tr:eq(0) th:eq('+(myCol+1)+')').html();
                var pri="";
                var roles=<?php echo json_encode($opt_roles); ?>;

                if(cname.toString()==='ROLE')
                {
                    pri="<select name='"+colArray[myCol]+'_'+myRow+"' id='"+colArray[myCol]+'_'+myRow+"'>";
                    var x;
                    for(x in roles)
                    {
                        var req="";
                        if(roles[x]===OriginalContent)
                        {
                            req='selected';
                        }
                        pri+="<option value='"+roles[x]+"' "+req+">"+roles[x]+"</option>";
                    }
                    pri+="</select>";
                }
                else
                {
                    pri="<input placeholder='"+OriginalContent+"' id='"+colArray[myCol]+'_'+myRow+"' name='"+colArray[myCol]+'_'+myRow+"' value='" + OriginalContent + "'/>";
                }


                pri+="<input type='hidden' id='where_"+myRow+"_"+myCol+"' name='id' value='"+id+"' />";
                $(this).html(pri);

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
                    db_table:'users',
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
<?php echo $__env->make('layouts.dash_app',['title'=>'users'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>