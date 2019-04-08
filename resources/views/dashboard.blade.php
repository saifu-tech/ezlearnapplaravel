<?php 
use App\Students;
use App\Staff;
use App\Group;
use App\Courses;
?>
@extends('master')
@section('pageTitle')
  Dashboard
@stop

@section('breadcrumb')
  <li><a href="javascript:void(0)">Dashboard</a></li>
@stop

@section('maincontent')
<div class="container-default row">
<div class="col-md-12">
  <ul class="topstats clearfix">
    <li class="arrow"></li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-dot-circle-o"></i> Staff</span>
      <?php $count=Staff::where('status','active')->count(); ?>
      <h3>{{$count}}</h3>
    </li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-calendar-o"></i> Students</span>
      <?php $count=Students::where('status','active')->count(); ?>
      <h3>{{$count}}</h3>
    </li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-shopping-cart"></i>Groups</span>
       <?php $count=Group::where('status','active')->count(); ?>
      <h3 class="color-up">{{$count}}</h3>
    </li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-users"></i> Courses</span>
      <?php $count=Courses::where('status','active')->count(); ?>
      <h3>{{$count}}</h3>
    </li>
  </ul>
  

  <form action="{!! URL::to('api/login') !!}" method="post">
    <button type="submit">Submit</button>
  </form>

  </div>
 </div>
@stop

