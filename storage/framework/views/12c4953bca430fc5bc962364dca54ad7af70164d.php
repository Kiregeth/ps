<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PASA | LOGIN</title>

    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/login-style.css')); ?>">
</head>
<body>
<div class="container">

    <div class="row" id="pwd-container">
        <div class="col-md-4 col-xs-2"></div>

        <div class="col-md-4 col-xs-8">
            <section class="login-form">
                <form method="post" action="<?php echo e(route('login')); ?>" role="login">
                    <?php echo e(csrf_field()); ?>


                    <img src="<?php echo e(asset('images/pasa-logo.png')); ?>" class="img-responsive" alt="Pasa International Pvt. Ltd" />
                    <div class="form-group<?php echo e($errors->has('uname') ? ' has-error' : ''); ?>">
                        <div class="col-xs-12">
                            <input id="uname" type="text" name="uname" value="<?php echo e(old('uname')); ?>" placeholder="User Name" required autofocus class="form-control input-lg" />
                            <?php if($errors->has('uname')): ?>
                                <span class="help-block">
                                        <strong><?php echo e($errors->first('uname')); ?></strong>
                                    </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <div class="col-xs-12">
                            <input id="password" type="password" class="form-control input-lg" placeholder="Password" name="password" required>

                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                            <?php endif; ?>
                        </div>
                    </div>



                    <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>

                    
                        
                    

                </form>

                <div class="form-links">
                    <a  href="https://pasainternational.com.np" target="_blank">www.pasainternational.com.np</a>
                </div>
            </section>
        </div>
    </div>
</div>

</body>
</html>