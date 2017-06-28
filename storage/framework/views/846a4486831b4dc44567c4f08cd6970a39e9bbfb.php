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
        <div class="col-md-4"></div>

        <div class="col-md-4">
            <section class="login-form">
                <form method="post" action="#" role="login">
                    <img src="<?php echo e(asset('images/pasa-logo.png')); ?>" class="img-responsive" alt="Pasa International Pvt. Ltd" />
                    <input type="text" name="uname" placeholder="Username" required class="form-control input-lg" />

                    <input type="password" class="form-control input-lg" id="password" placeholder="Password" required="" />


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