<?php
use App\Options;
use App\Privilege;
?>
<div class="sidebar clearfix">

<ul class="sidebar-panel nav">
  <li>
  <a href="{{URL::to('admin/')}}" class="{{HTML::activeState('admin/')}}"><span class="icon color5"><i class="fa fa-home"></i></span>Dashboard</a>
  </li>

 
@if(Auth::user()->type=='admin')

 <li>
  <a href="{{URL::to('admin/user/privilege/get')}}" class="{{HTML::activeState('admin/user/privilege/get')}}"><span class="icon color5"><i class="fa fa-home"></i></span>Privilege</a>
  </li>

  @if(Options::getvalue('countryBased')=='yes')
    <li><a href="{{URL::to('admin/masters/country/get')}}"><span class="icon color5"><i class="fa fa-graduation-cap"></i></span>Country</a></li>
  @endif
  <li><a href="{{URL::to('admin/staff/get')}}"><span class="icon color5"><i class="fa fa-graduation-cap"></i></span>Staff</a></li>
  <li><a href="{{URL::to('admin/student/get')}}"><span class="icon color5"><i class="fa fa-users"></i></span>Student</a></li>
  <li><a href="javascript:void(0)" class="{{HTML::activeState('admin/reports/*')}}"><span class="icon color7"><i class="fa fa-flask"></i></span>Reports<span class="caret"></span></a>
    <ul style="{{HTML::ulState('admin/reports/*')}}">
      <li><a href="{{URL::to('admin/reports/staff/groups/get')}}" class="{{HTML::activeState('admin/reports/staff/groups/get')}}">Groups managed by staff</a></li>
      <li><a href="{{URL::to('admin/reports/courses/assigned/student/get')}}" class="{{HTML::activeState('admin/reports/courses/assigned/student/get')}}">Courses assigned to each student</a></li>
      <li><a href="{{URL::to('admin/reports/staff/courses/get')}}" class="{{HTML::activeState('admin/reports/staff/courses/get')}}">Courses managed by staff</a></li>
      <li><a href="{{URL::to('admin/reports/completed/courses/get')}}" class="{{HTML::activeState('admin/reports/completed/courses/get')}}">Completed Courses</a></li>
      <li><a href="{{URL::to('admin/reports/pending/courses/get')}}" class="{{HTML::activeState('admin/reports/pending/courses/get')}}">Pending Courses</a></li>
      <li><a href="{{URL::to('admin/reports/overdue/courses/get')}}" class="{{HTML::activeState('admin/reports/overdue/courses/get')}}">Overdue Courses</a></li>
      <li><a href="{{URL::to('admin/reports/masters/get')}}" class="{{HTML::activeState('admin/reports/masters/get')}}">Master Details</a></li>
    </ul>
  </li>
  <li><a href="{{URL::to('admin/users/get')}}"><span class="icon color5"><i class="fa fa-photo"></i></span>Users</a></li>
  <li><a href="{{URL::to('admin/settings/get')}}"><span class="icon color5"><i class="fa fa-photo"></i></span>Settings</a></li>

@endif
<?php $userId=Auth::user()->id; ?>
@if(Privilege::getprivilegearraystatus([1,2,3,4],$userId)=='yes')
  <li><a href="javascript:void(0)" class="{{HTML::activeState('admin/masters/*')}}"><span class="icon color7"><i class="fa fa-flask"></i></span>Masters<span class="caret"></span></a>
    <ul style="{{HTML::ulState('admin/masters/*')}}">
    @if(Privilege::getprivilegestatus(1,$userId,'viewStatus')=='yes')
      <li><a href="{{URL::to('admin/masters/classes/get')}}" class="{{HTML::activeState('admin/masters/classes/*')}}">{{Options::getvalue('lable1')}}</a></li>
    @endif
    @if(Privilege::getprivilegestatus(1,$userId,'viewStatus')=='yes')
      <li><a href="{{URL::to('admin/masters/subjects/get')}}" class="{{HTML::activeState('admin/masters/subjects/*')}}">{{Options::getvalue('lable2')}}</a></li>
    @endif
    @if(Privilege::getprivilegestatus(3,$userId,'viewStatus')=='yes')
      <li><a href="{{URL::to('admin/masters/category/get')}}" class="{{HTML::activeState('admin/masters/category/*')}}">Categories</a></li>
    @endif
    @if(Privilege::getprivilegestatus(4,$userId,'viewStatus')=='yes')
      <li><a href="{{URL::to('admin/masters/courses/get')}}" class="{{HTML::activeState('admin/masters/courses/*')}}">Courses</a></li>
    @endif
    </ul>
  </li>
  @endif
  @if(Auth::user()->type=='staff')
  <li><a href="{{URL::to('admin/import/category/get')}}"><span class="icon color5"><i class="fa fa-download"></i></span>Import Category</a></li>
  <li><a href="{{URL::to('admin/import/courses/get')}}"><span class="icon color5"><i class="fa fa-download"></i></span>Import Courses</a></li>
  <li><a href="{{URL::to('admin/library/get')}}"><span class="icon color5"><i class="fa fa-photo"></i></span>Media Library</a></li>
@endif

@if(Auth::user()->type=='staff' || Auth::user()->type=='admin')
  <li><a href="{{URL::to('admin/groups/get')}}"><span class="icon color5"><i class="fa fa-cubes"></i></span>Groups</a></li>
@endif

@if(Auth::user()->type=='staff')
  <li><a href="{{URL::to('admin/assign/course/get')}}"><span class="icon color5"><i class="fa fa-users"></i></span>Assign Courses</a></li>
  <li><a href="{{URL::to('admin/daily/tasks/get')}}"><span class="icon color5"><i class="fa fa-users"></i></span>Daily Tasks</a></li>
@endif
  

  @if(Auth::user()->type=='student' || Auth::user()->type=='staff')
  <li><a href="{{URL::to('admin/daily/tasks/status/get')}}"><span class="icon color5"><i class="fa fa-users"></i></span>Daily Tasks Status</a></li>
  @endif

   @if(Auth::user()->type=='staff')
  <li><a href="{{URL::to('admin/optiontypelist')}}"><span class="icon color5"><i class="fa fa-users"></i></span>Option master</a></li>
  @endif

  @if(Auth::user()->type=='staff')
  <li><a href="{{URL::to('admin/tracker')}}"><span class="icon color5"><i class="fa fa-users"></i></span>Add Tracker</a></li>
  @endif
  

  @if(Auth::user()->type=='staff' || Auth::user()->type=='student')
  <li><a href="{{URL::to('admin/group/courses/status/get')}}"><span class="icon color5"><i class="fa fa-users"></i></span>Courses Status</a></li>
  @endif

  @if(Auth::user()->type=='student')
  <li><a href="{{URL::to('admin/student/assign/course/get')}}"><span class="icon color5"><i class="fa fa-users"></i></span>Student Courses</a></li>
  @endif

</ul>
</div>
<!-- END SIDEBAR