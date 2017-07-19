<?php $__env->startSection('content'); ?>
    <style>
        .form-group{
            margin-bottom: 0px;
        }
        .form-control{
            background-color: white;
        }
        label{
            line-height: 3em;
        }
    </style>
    <?php 
        $discard=['id','created_at','updated_at','remember_token'];
        $required=['uname','name','email','password'];
     ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?php if(session()->has('message')): ?>
                    <h1 align="center" class="alert alert-success"><?php echo e(session()->get('message')); ?></h1>
                <?php endif; ?>
                <h3>Add New User</h3>
                <form method="post" action="" name="add-user" id="add-user">
                    <?php echo e(csrf_field()); ?>

                    <?php $__currentLoopData = $cols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!in_array($col,$discard)): ?>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="control-label" for="<?php echo e($col); ?>"><?php echo e(strtoupper($col)); ?> <?php if(in_array($col,$required)): ?> * <?php endif; ?> :</label>
                                </div>
                                <div class="col-md-8">
                                    <?php if($col=='password'): ?>
                                        <input name="<?php echo e($col); ?>" id="<?php echo e($col); ?>" class="form-control" type="password" placeholder="<?php echo e(strtoupper($col)); ?> <?php if(in_array($col,$required)): ?> * <?php endif; ?>" <?php if(in_array($col,$required)): ?> required <?php endif; ?>/>
                                    <?php elseif($col=='role'): ?>
                                        <select name="<?php echo e($col); ?>" id="<?php echo e($col); ?>" class="form-control">
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($role->role); ?>"><?php echo e($role->role); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    <?php elseif($col=="email"): ?>
                                        <input name="<?php echo e($col); ?>" id="<?php echo e($col); ?>" class="form-control" type="email" placeholder="<?php echo e(strtoupper($col)); ?> <?php if(in_array($col,$required)): ?> * <?php endif; ?>" <?php if(in_array($col,$required)): ?> required <?php endif; ?>/>
                                    <?php else: ?>
                                        <input name="<?php echo e($col); ?>" id="<?php echo e($col); ?>" class="form-control" type="text" placeholder="<?php echo e(strtoupper($col)); ?> <?php if(in_array($col,$required)): ?> * <?php endif; ?>" <?php if(in_array($col,$required)): ?> required <?php endif; ?>/>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <div class="pull-left">
                            <input class="btn btn-primary" type="submit" value="Add User">
                        </div>
                        <br/>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dash_app',['title'=>'add_user'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>