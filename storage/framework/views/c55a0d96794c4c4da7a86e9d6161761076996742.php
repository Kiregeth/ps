<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-offset-1 col-md-8 col-xs-8">
                <div class="panel panel-success">
                    <div class="panel-heading">Change Password</div>
                    <form onsubmit="return confirm();" method="post">
                        <?php echo e(csrf_field()); ?>

                    <div class="panel-body">
                        <div class="form-group row">
                            <div class="col-md-2"><label for="old_pwd" class="control-label">Old Password</label></div>
                            <div class="col-md-10"><input type="password" id="old_pwd" name="old_pwd" class="form-control" required/></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2"><label for="new_pwd" class="control-label">New Password</label></div>
                            <div class="col-md-10"><input type="password" id="new_pwd" name="new_pwd" class="form-control" required/></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2"><label for="confirm_pwd" class="control-label">Confirm Password</label></div>
                            <div class="col-md-10"><input type="password" id="confirm_pwd" name="confirm_pwd" class="form-control" required/></div>
                        </div>
                        <h3 class="<?php echo e($msg_class); ?>" id="msg"><?php echo e($msg); ?></h3>
                    </div>
                    <div class="panel-footer">
                        <input style="margin-left: 15px; " type="submit" class ="btn btn-success" value="Change" />
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function confirm() {
            var new_pwd=document.getElementById('new_pwd').value;
            var confirm_pwd=document.getElementById('confirm_pwd').value;
            if(new_pwd===confirm_pwd)
            {
                return true;
            }
            else
            {
                document.getElementById('err').innerHTML="The new password does not match with the confirm password";
                return false;
            }
        }
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dash_app',['title'=>'change_pwd'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>