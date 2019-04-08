<?php 
use App\Students;
use App\Staff;
use App\Group;
use App\Courses;
?>

<?php $__env->startSection('pageTitle'); ?>
  Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <li><a href="javascript:void(0)">Dashboard</a></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('maincontent'); ?>
<div class="container-default row">
<div class="col-md-12">
  <ul class="topstats clearfix">
    <li class="arrow"></li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-dot-circle-o"></i> Staff</span>
      <?php $count=Staff::where('status','active')->count(); ?>
      <h3><?php echo e($count); ?></h3>
    </li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-calendar-o"></i> Students</span>
      <?php $count=Students::where('status','active')->count(); ?>
      <h3><?php echo e($count); ?></h3>
    </li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-shopping-cart"></i>Groups</span>
       <?php $count=Group::where('status','active')->count(); ?>
      <h3 class="color-up"><?php echo e($count); ?></h3>
    </li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-users"></i> Courses</span>
      <?php $count=Courses::where('status','active')->count(); ?>
      <h3><?php echo e($count); ?></h3>
    </li>
  </ul>
  

  <form action="<?php echo URL::to('api/login'); ?>" method="post">
    <button type="submit">Submit</button>
  </form>

  </div>
 </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>