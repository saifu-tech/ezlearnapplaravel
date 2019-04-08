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
  <link rel="icon" href="<?php echo e(Options::getvalue('siteFavIcon')); ?>" type="image/png" sizes="16x16">
  <meta name="_token" content="<?php echo app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()); ?>" />
  <title><?php echo e(Options::getvalue("siteTitle")); ?></title>

  <!-- ========== Css Files ========== -->
  <?php echo e(HTML::style('css/bootstrap.css')); ?>

  <?php echo e(HTML::style('css/root.css')); ?>

  <?php echo e(HTML::style('css/font-awesome.min.css')); ?>

  <style type="text/css">
  .validation-error {
      color: red;
      font-size: 11px;
      padding-left: 5px;
  }
  </style>
  <?php echo $__env->yieldContent('custom-header-scripts'); ?>
  </head>
  <body>
  <!-- Start Page Loading -->
  <div class="loading"><img src="<?php echo e(URL::asset('image/loading.gif')); ?>" alt="loading-img"></div>
  <!-- End Page Loading -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
  <!-- START TOP -->
  <div id="top" class="clearfix">

    <!-- Start App Logo -->
    <div class="applogo">
      <center><h4>ELEARNING</h4></center>
    </div>
    <!-- End App Logo -->

    <!-- Start Sidebar Show Hide Button -->
    <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
    <!-- End Sidebar Show Hide Button -->

    <!-- Start Searchbox -->
    <!-- <form class="searchform">
      <input type="text" class="searchbox" id="searchbox" placeholder="Search">
      <span class="searchbutton"><i class="fa fa-search"></i></span>
    </form> -->
    <!-- End Searchbox -->

    <!-- Start Top Menu -->
   <!--  <ul class="topmenu">
      <li><a href="#">Files</a></li>
      <li><a href="#">Authors</a></li>
      <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">My Files <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Videos</a></li>
          <li><a href="#">Pictures</a></li>
          <li><a href="#">Blog Posts</a></li>
        </ul>
      </li>
    </ul> -->
    <!-- End Top Menu -->

    <!-- Start Sidepanel Show-Hide Button -->
    <!-- <a href="#sidepanel" class="sidepanel-open-button"><i class="fa fa-outdent"></i></a> -->
    <!-- End Sidepanel Show-Hide Button -->

    <!-- Start Top Right -->
    <ul class="top-right">

    

   

    <li class="dropdown link">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox"><b><?php echo e(Auth::user()->full_name); ?></b><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
          <!-- <li role="presentation" class="dropdown-header">Profile</li>
          <li><a href="#"><i class="fa falist fa-inbox"></i>Inbox<span class="badge label-danger">4</span></a></li>
          <li><a href="#"><i class="fa falist fa-file-o"></i>Files</a></li>
          <li><a href="#"><i class="fa falist fa-wrench"></i>Settings</a></li>
          <li class="divider"></li>
          <li><a href="#"><i class="fa falist fa-lock"></i> Lockscreen</a></li> -->
          <li><a href="<?php echo e(URL::to('admin/changepassword')); ?>"><i class="fa falist fa-key"></i> Change Password</a></li>
          <li><a href="<?php echo e(URL::to('logout')); ?>"><i class="fa falist fa-power-off"></i> Logout</a></li>
        </ul>
    </li>

    </ul>
    <!-- End Top Right -->

  </div>
  <!-- END TOP -->

<!-- START SIDEBAR -->
<?php echo $__env->make('sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- END SIDEBAR -->

<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title"><?php echo $__env->yieldContent('pageTitle'); ?></h1>
      <ol class="breadcrumb">
      <?php echo $__env->yieldContent('breadcrumb'); ?>
      </ol>
  </div>
  <!-- End Page Header -->

  <!-- Start Presentation -->
  <!-- <div class="row presentation">

    <div class="col-lg-8 col-md-6 titles">
      <span class="icon color14-bg"><i class="fa fa-align-left"></i></span>
      <h1>Form Layouts</h1>
      <h4>Includes predefined classes for easy layout options</h4>
    </div>

    <div class="col-lg-4 col-md-6">
      <ul class="list-unstyled list">
        <li><i class="fa fa-check"></i>Easy to Edit<li>
        <li><i class="fa fa-check"></i>5 Layout Options<li>
        <li><i class="fa fa-check"></i>Based on <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a><li>
      </ul>
    </div>

  </div> -->
  <!-- End Presentation -->


<!-- START CONTAINER -->
<?php echo $__env->yieldContent('maincontent'); ?>
<!-- END CONTAINER -->

<!-- ================================================
jQuery Library
================================================ -->
<?php echo e(HTML::script('js/jquery.min.js')); ?>


<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<?php echo e(HTML::script('js/bootstrap/bootstrap.min.js')); ?>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<?php echo e(HTML::script('js/plugins.js')); ?>

<?php echo $__env->yieldContent('custom-footer-scripts'); ?>
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
      $('.successMessage,.errorMessage,.validation-error').fadeOut()},5000);
});
</script>
</body>
</html>