<?php
use App\Options;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Human Resource Management Portal">
  <meta name="keywords" content="" />
  <title><?php echo e(Options::getvalue("siteTitle")); ?></title>

  <!-- ========== Css Files ========== -->
  <link href="<?php echo e(asset('css/root.css')); ?>" rel="stylesheet">
  <style type="text/css">
    body{background: #F5F5F5;}
  </style>
  </head>
  <body>

    <div class="login-form">
    
     <?php echo e(Form::open(['url'=>'admin/login'])); ?>

        <div class="top">
          <h1>ELEARNING</h1>
        </div>
        <div class="form-area">
          <div class="group  <?php if($errors->has('userName')): ?> has-warning <?php endif; ?>">
            <input type="text" name="userName" class="form-control" placeholder="Username">
            <i class="fa fa-user"></i>
            <?php if($errors->has('userName')): ?>
            <span id="helpBlock" class="help-block"><?php echo e($errors->first('userName')); ?></span>
            <?php endif; ?>
          </div>
          <div class="group <?php if($errors->has('password')): ?> has-warning <?php endif; ?>">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <i class="fa fa-key"></i>
             <?php if($errors->has('password')): ?>
            <span id="helpBlock" class="help-block"><?php echo e($errors->first('password')); ?></span>
            <?php endif; ?>
          </div>
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
          
          <!-- <div class="checkbox checkbox-primary">
            <input id="checkbox101" type="checkbox" checked>
            <label for="checkbox101"> Remember Me</label>
          </div> -->
          <button type="submit" class="btn btn-default btn-block">LOGIN</button>
            <?php if(Session::has('error')): ?>
            <span id="helpBlock" style="color:#f39c12" class="help-block"><?php echo e(Session::get('error')); ?></span>
            <?php endif; ?>
        </div>
     <?php echo e(Form::close()); ?>



      <div class="footer-links row">
        <!-- <div class="col-xs-6"><a href="#"><i class="fa fa-external-link"></i> Register Now</a></div>
        <div class="col-xs-6 text-right"><a href="#"><i class="fa fa-lock"></i> Forgot password</a></div> -->
      </div>
    </div>

</body>
</html>