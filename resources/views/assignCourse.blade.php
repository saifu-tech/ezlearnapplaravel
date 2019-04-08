<?php
use App\Groupcourse;
use App\Group;
use App\Courses;
use App\GroupMember;
use App\Students;
use App\GroupPostMeta;
use App\GroupPost;
use App\GroupComment;
use App\Vote;
use App\User;
use App\Votemeta;
use App\TaskComplete;
use App\CourseComplete;
use App\Options;
use App\Discussion;
$lable1=Options::getvalue('lable1');
$lable2=Options::getvalue('lable2');
?>
@extends('master')

@section('pageTitle')
Assign Course
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Assign Course</a></li>
@stop

@section('custom-header-scripts')
<style type="text/css">
  .active-menu{
    background: #399BFF;
  }

  .active-menu i {
    color: #fff !important;
  }

  .active-menu a {
    color: #fff !important;
  }

  .active-menu .from {
    color: #fff !important;
  }

  .tabTitle{
    margin-top: 0px;
    margin-bottom: 25px;
  }

  .titlePanel{
    display:none;
  }

  .taskBody .mailbox-inbox{
    border:none !important;
  }
  .panel {
    border-radius: 0px;
    border:none;
  }
  .saveComment{
    display:none;
  }
</style>
@stop

@section('maincontent')

<div class="container-mailbox">
  <div class="mailbox clearfix">
        <!-- Start Mailbox Inbox -->
        <div class="row">
        <div class="col-lg-3 col-md-4 padding-0">
        <ul class="mailbox-inbox">
            <li class="search">
              <form>
                <input type="text" class="mailbox-search" id="mailboxsearch" placeholder="Search">
                <span class="searchbutton"><i class="fa fa-search"></i></span>
              </form>
            </li>
            @if(count($detail)==1)
            <li class="ligroup">
              <a href="{!! URL::to('admin/assign/course/get/'.$detail->id) !!}" class="item clearfix">
                <span class="from groupName">{{$detail->group_name}}</span>
                {{$detail->group_short_description}}
                <span class="date">{{date('d M Y',strtotime($detail->created_at))}}</span>
              </a>
            </li>
            @endif
            @foreach($groups as $group)
              @if($group->id!=$groupId)
            <li class="ligroup">
              <a href="{!! URL::to('admin/assign/course/get/'.$group->id) !!}" class="item clearfix">
                <span class="from groupName">{{$group->group_name}}</span>
                {{$group->group_short_description}}
                <span class="date">{{date('d M Y',strtotime($group->created_at))}}</span>
              </a>
            </li>
            @endif
            @endforeach
        </ul>
        </div>
        <!-- End Mailbox Inbox -->

        <!-- Start Chat -->
        <div class="chat col-lg-9 col-md-8 padding-0">

            <div class="mailbox-menu">
              <ul class="menu">
                <li class="panelTitle" id="coursePanel">
                  <a href="javascript:void(0)"><i class="fa fa-book"></i> Courses</a>
                </li>
                <li class="panelTitle" id="studentsPanel">
                  <a href="javascript:void(0)"><i class="fa fa-graduation-cap"></i> Students</a>
                </li>
                <li class="panelTitle" id="taskPanel">
                  <a href="javascript:void(0)"><i class="fa fa-tasks"></i> Tasks</a>
                </li>
                <li class="panelTitle" id="discussionPanel">
                  <a href="javascript:void(0)"><i class="fa fa-comments-o"></i> Discussions</a>
                </li>
                <li class="panelTitle" id="votePanel">
                  <a href="javascript:void(0)"><i class="fa fa-star"></i> Vote</a>
                </li>
                <li class="panelTitle" id="statusPanel">
                  <a href="javascript:void(0)"><i class="fa fa-thumbs-up"></i> Task Status</a>
                </li>
              </ul>
            </div>
      <!-- End Title -->

      <!-- <div class="panel panel-default">
        <div class="panel-title">
          Course Name
            <a href="#" class="btn btn-success" style="float:right;">Assign Course</a>
        </div>
      </div> -->

      <!-- Start Courses -->
      <div class="titlePanel coursePanel">
        <?php
        $courseName='';
        if($courseId!=''){
          $courseName=Courses::getcoursename($courseId);
        }
        $courses=Groupcourse::where('group_id',$groupId)->where('status','active')->get();
        $i=0;
        ?>

        <div class="title">
        <h1>Courses</h1>
        <p><b>Total Course:</b> <span class="label label-warning">{{count($courses)}}</span></p>
          <div aria-label="..." role="group" class="btn-group">
            <button class="btn btn-icon btn-sm btn-light addCourse" type="button"><i class="fa fa-link"></i> Assign Course</button>
          </div>
        </div>

        @if(Session::has('courseSuccess')) {!! HTML::display_success('courseSuccess') !!} @endif

        <div class="row add_row_course" style="display:none;">
      <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Add Course
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
          </ul>
        </div>
        {{Form::hidden('currentCourseId',$courseId,['class'=>'currentCourseId'])}}
          @if(count($staffcourses)>0)
            <div class="panel-body">
              {{Form::open(['url'=>'admin/assign/courses/add/post','class'=>'form-horizontal'])}}

                {{Form::hidden('groupId',$groupId,['class'=>'groupId'])}}
               
                <div class="form-group">
                  {{Form::label('course','Course',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('course',$staffcourses,'',['class'=>'form-control courseName','placeholder'=>'Select Course'])}}
                  @if ($errors->add->has('course')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('course') }}
                   </div> 
                 @endif
                 </div>
                </div>


                <div class="form-group">
                  {{Form::label('','',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::checkbox('sendnotification','yes',true)}}&nbsp;&nbsp;Send notification to group students
                 </div>
                </div>
                <?php
                $acceptanceStatus=false;
                $groupDetails=Group::find($groupId);
                if(count($groupDetails)==1 && $groupDetails->acceptance_mandatory=='no'){
                  $acceptanceStatus=true;
                }
                ?>


                <div class="form-group">
                  {{Form::label('','',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::checkbox('studentAcceptance','no',$acceptanceStatus)}}&nbsp;&nbsp;Student acceptance not required
                 </div>
                </div>


                <div class="form-group">
                {{Form::label('',' ',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                {{Form::submit('Save',['class'=>'btn btn-default'])}}
                {{Form::button('Cancel',['class'=>'btn btn-info hideAssignCourse'])}}
                </div>
                </div>
              {{Form::close()}}
            </div>
          @else
          <div class="alert alert-danger">No courses available. Please create courses under masters.</div>
          @endif

      </div>
    </div>
    </div>



        <div class="panel-body">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          @if(count($courses)>0)
            @foreach($courses as $course)
            <?php
            $courseDetails=Courses::find($course->course_id);
            $class='';
            // if($i==0){
            //   $class='in';
            //   $i++;
            // }
            $subscribed=GroupMember::where('group_course_id',$course->id)->where('status','active')->count();
            $completed=CourseComplete::where('group_course_id',$course->id)->count();
            ?>
              <div class="panel panel-default panel-collapse">
                <div class="panel-heading" role="tab" id="heading{{$course->course_id}}">
                  <a data-toggle="collapse" data-parent="#accordion" href="#course{{$course->course_id}}" aria-expanded="true" aria-controls="collapse{{$course->course_id}}" class=""><i class="more-less fa fa-plus"></i><h4 class="panel-title">
                    <i class="fa fa-file"></i>&nbsp; 
                      {{$courseDetails->name}}
                  </h4></a>
                </div>
                <div id="course{{$course->course_id}}" class="panel-collapse collapse {{$class}}" role="tabpanel" aria-labelledby="heading{{$course->course_id}}" aria-expanded="true">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-3">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Start Date:</b> {{date('d-m-Y',$course->start_date)}}</p>
                      </div>
                      <div class="col-md-3">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>End Date:</b> {{date('d-m-Y',$course->end_date)}}</p>
                      </div>
                      <div class="col-md-3">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Subscribed:</b> {{$subscribed}}</p>
                      </div>
                      <div class="col-md-3">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Completed:</b> {{$completed}}</p>
                      </div>
                    </div>
                    {{$courseDetails->description}}                    
                  </div>

                  <?php
                    $students=GroupMember::where('groupid',$groupId)->where('courseid',$course->course_id)->where('status','!=','deleted')->get();
                    $i=0;
                  ?>
                  <?php $viewCourseUrl=URL::to('admin/assign/course/get/'.$groupId.'/students/'.$course->course_id); ?>
                  <a href="{{$viewCourseUrl}}" class="btn btn-default changeCourseId" data-id="{{$course->course_id}}">View Course</a>
                  <h4><b>Students&nbsp;({{count($students)}})</b></h4>

                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <td>S.No</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Status</td>
                        <td>Completed Date</td>
                      </tr>
                    </thead>
                    <tbody>
                    @if(count($students)>0)
                      @foreach($students as $student)
                        <?php
                          $record=CourseComplete::where('group_course_id',$course->course_id)->where('student_id',$student->studentid)->first();
                          $status='';
                          $completedDate='';
                          if(count($record)==1){
                            $status="Completed";
                            $completedDate=date('d M Y, H:i A',$record->time);
                          }elseif($student->status=='rejected'){
                            $status='Rejected';
                          }elseif($student->status=='inactive'){
                            $status='Pending';
                          }elseif($student->status=='active'){
                            $status='Accepted';
                          }
                          
                        ?>
                        <tr>
                          <td><b>{{++$i}}</b></td>
                          <td>{{Students::getstudentname($student->studentid)}}</td>
                          <td>{{Students::getstudentemail($student->studentid)}}</td>
                          <td>{{$status}}</td>
                          <td>{{$completedDate}}</td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                        <td colspan=5><b>No students available</b></td>
                      </tr>
                    @endif
                    </tbody>
                  </table>

                   @if($course->video_url!='')
                  <h4><b>Youtube Link</b></h4>
                  <?php 
                  $url= $course->video_url;
                  $explode=explode('watch?v=',$url);
                  $youtubeLink='';
                  if(count($explode)==2){
                    $youtubeLink=$explode[1];
                  }
                  ?>
                  <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$youtubeLink}}" frameborder="0" allowfullscreen></iframe>
                  @endif

                </div>
              </div>
              
            @endforeach
          @else
          <div class="kode-alert kode-alert-icon alert6-light">
            <i class="fa fa-lock"></i>
            <a href="javascript:void(0)" class="closed">×</a>
            No courses available. Please assign courses for this group.
          </div>
          @endif
          </div>
        </div>
      </div>
      <!-- End Courses -->

      <!-- Start Students -->
      <?php
      $groupCountry='';
      $groupDetails=Group::find($groupId);
      if(count($groupDetails)==1 && $groupDetails->countryId!=''){
        $groupCountry=$groupDetails->countryId;
      }
      $students=GroupMember::where('groupid',$groupId)->where('courseid',$courseId)->where('added_by',Auth::user()->id)->where('status','!=','deleted')->lists('studentid');
      $studentsCount=GroupMember::where('groupid',$groupId)->where('courseid',$courseId)->where('added_by',Auth::user()->id)->where('status','active')->lists('studentid');
      $reqStudents=Students::whereNotIn('id',$students)->where('status','active');
      if($groupCountry!=''){
        $reqStudents=$reqStudents->where('countryId',$groupCountry);
      }
      $reqStudents=$reqStudents->get();
      ?>
      <div class="titlePanel studentsPanel" >

      <div class="title">
        <h1>{{$courseName}}</h1>
        <p><b>Students:</b> <span class="label label-warning">{{count($studentsCount)}}</span></p>
          <div aria-label="..." role="group" class="btn-group">
            <button class="btn btn-icon btn-sm btn-light addStudents" type="button"><i class="fa fa-graduation-cap"></i> Invite Students</button>
          </div>
        </div>
         @if(Session::has('studentSuccess')) {!! HTML::display_success('studentSuccess') !!} @endif
         <div class="panel-body table-responsive inviteStudents" style="display:none">
          @if(count($reqStudents)>0)
            <div class="panel panel-default">
              {{Form::open(['url'=>'admin/assign/members/add/post'])}}
              <div class="panel-title">
                Select Students 
              </div>
              <table class="table table-hover table-striped">
                <thead>
                  <tr>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Select</td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($reqStudents as $student)
                    <tr>
                      <td>{{$student->fullname}}</td>
                      <td>{{$student->email}}</td>
                      <td class="text-center"><div class="checkbox margin-t-0"><input id="checkbox{{$student->id}}" class="selectStudent checkbox{{$student->id}}" type="checkbox" data-id="{{$student->id}}"><label for="checkbox{{$student->id}}"></label></div></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <br>
              {{Form::hidden('groupId',$groupId)}}
              {{Form::hidden('courseId',$courseId,['class'=>'currentCourseId'])}}
              {{Form::hidden('students','',['id'=>'studentsId'])}}
              {{Form::submit('Invite',['class'=>'btn btn-default saveStudents'])}}
              {{Form::button('Cancel',['class'=>'btn btn-info hideStudents'])}}
              {{Form::close()}}
              </div>
          @else
            <div class="kode-alert kode-alert-icon alert6-light">
              <i class="fa fa-lock"></i>
              <a href="javascript:void(0)" class="closed">×</a>
              All students are added in this group.
            </div>
          @endif
        </div>
        <div class="panel-body">
        <ul class="mailbox-inbox">
        <?php $students=GroupMember::where('groupid',$groupId)->where('courseid',$courseId)->where('added_by',Auth::user()->id)->where('status','active')->get(); ?>
        @if(count($students)>0)
        @foreach($students as $student)
          <?php
          $details=Students::find($student->studentid);
          $name='';
          $email='';
          if(count($details)==1){
            $name=$details->fullname;
            $email=$details->email;
          }
          ?>
            <li class="student{{$student->id}}">
              <a href="javascript:void(0)" class="item clearfix">
                <!-- <img src="{!! User::getstaffprofileimage($student->studentid,'student') !!}" alt="img" class="img"> -->
                <span class="from">{{$name}} <em>{{date('d M Y',$student->added_on)}}</em></span>
                {{$email}}
                <span class="date removeStudent"  data-id="{{$student->id}}"><i class="fa fa-trash"></i> Remove</span>

              </a>
            </li>
        @endforeach
        @else
        <div class="kode-alert kode-alert-icon alert6-light">
            <i class="fa fa-lock"></i>
            <a href="javascript:void(0)" class="closed">×</a>
            No students available. Please invite students.
          </div>
        @endif
        </ul>
        </div>
      </div>
      <!-- End Students -->

      <!-- Start Task -->
      <div class="titlePanel taskPanel" >

      <div class="title">
        <h1>{{$courseName}}</h1>
        <p><b>Tasks</p>
          <div aria-label="..." role="group" class="btn-group">
            <button class="btn btn-icon btn-sm btn-light addTask" type="button"><i class="fa fa-plus"></i> Add Task</button>
          </div>
        </div>

        @if(Session::has('taskSuccess')) {!! HTML::display_success('taskSuccess') !!} @endif

        <div class="row add_row_task" style="display:none;">
      <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

          <div class="panel-title">
            Add Task
            <ul class="panel-tools">
              <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            </ul>
          </div>

            <div class="panel-body">
              {{Form::open(['url'=>'admin/assign/task/add/post','class'=>'form-horizontal'])}}

                {{Form::hidden('groupId',$groupId,['class'=>'groupId'])}}

                <div class="form-group">
                  {{Form::label('shortDescription','Short Description *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('shortDescription','',['class'=>'form-control','rows'=>5])}}
                  @if ($errors->add->has('shortDescription')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('shortDescription') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('message','Your Message *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::textarea('message','',['class'=>'form-control','rows'=>5])}}
                  @if ($errors->add->has('message')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('message') }}
                   </div> 
                 @endif
                 </div>
                </div>

                {{Form::hidden('course',$courseId,['class'=>'currentCourseId'])}}

                <div class="form-group">
                  {{Form::label('dueDate','Due Date *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('dueDate','',['class'=>'form-control dueDate'])}}
                  @if ($errors->add->has('dueDate')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('dueDate') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('youtubeLink','Youtube Link',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('youtubeLink','',['class'=>'form-control'])}}
                  @if ($errors->add->has('youtubeLink')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('youtubeLink') }}
                   </div> 
                 @endif
                 </div>
                </div>


                <div class="form-group">
                {{Form::label('',' ',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                {{Form::submit('Save',['class'=>'btn btn-default'])}}
                {{Form::button('Cancel',['class'=>'btn btn-info hideTask'])}}
                </div>
                </div>
              {{Form::close()}}
            </div>

      </div>
    </div>
    </div>


    <div class="row edit_row_task" style="display:none;">
      <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

          <div class="panel-title">
            Edit Task
            <ul class="panel-tools">
              <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            </ul>
          </div>

            <div class="panel-body">
              {{Form::open(['url'=>'admin/assign/task/edit/post','class'=>'form-horizontal'])}}

                {{Form::hidden('editTaskId','',['class'=>'editTaskId'])}}
                {{Form::hidden('course',$courseId,['class'=>'currentCourseId'])}}
                {{Form::hidden('groupId',$groupId,['class'=>'groupId'])}}

                <div class="form-group">
                  {{Form::label('shortDescription','Short Description *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('shortDescription','',['class'=>'form-control editTaskShortDescription','rows'=>5])}}
                  @if ($errors->edit->has('shortDescription')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('shortDescription') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('message','Your Message *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::textarea('message','',['class'=>'form-control editTaskMessage','rows'=>5])}}
                  @if ($errors->edit->has('message')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('message') }}
                   </div> 
                 @endif
                 </div>
                </div>

                {{Form::hidden('course',$courseId,['class'=>'currentCourseId'])}}

                <div class="form-group">
                  {{Form::label('dueDate','Due Date *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('dueDate','',['class'=>'form-control editTaskDueDate'])}}
                  @if ($errors->edit->has('dueDate')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('dueDate') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('youtubeLink','Youtube Link',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('youtubeLink','',['class'=>'form-control editTaskYoutube'])}}
                  @if ($errors->edit->has('youtubeLink')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('youtubeLink') }}
                   </div> 
                 @endif
                 </div>
                </div>


                <div class="form-group">
                {{Form::label('',' ',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                {{Form::submit('Save',['class'=>'btn btn-default'])}}
                {{Form::button('Cancel',['class'=>'btn btn-info hideTask'])}}
                </div>
                </div>
              {{Form::close()}}
            </div>

      </div>
    </div>
    </div>

@if($courseId=='')
<div class="taskBody" style="display:none;"></div>
@else
        <div class="panel-body taskBody">
        <?php
          $tasks=GroupPost::where('post_type','task')->where('group_id',$groupId)->where('course_id',$courseId)->get();
          $taskCount=count($tasks);
          $i=0;
        ?>
        @if($taskCount>0)
          @foreach($tasks as $task)
            <?php
              $userName=User::find($task->author)->full_name;
              $comments=GroupComment::where('postid',$task->id)->get();
              $class='';
              // if($i==0){
              //   $class='in';
              // }
            ?>
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default panel-collapse">
              <div class="panel-heading" role="tab" id="heading{{$task->id}}">
              <a class="" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$task->id}}" aria-expanded="true" aria-controls="collapse{{$task->id}}">
                <h4 class="panel-title">
                  
                    {{$task->short_description}}
                  
                </h4>
                </a>
              </div>
              <div id="collapse{{$task->id}}" class="panel-collapse collapse {{$class}}" role="tabpanel" aria-labelledby="heading{{$task->id}}" aria-expanded="true">
                <div class="panel-body">
                  <div class="status">
                    <div class="who clearfix">
                      <!-- <img src="{!! User::getprofileimage($task->author) !!}" alt="img"> -->
                      <span class="name"><b>{{$userName}}</b> </span>
                      <span class="from">at <b>{{date("d M Y, H:i A",$task->time)}}</b></span>
                      <span style="float:right"><a href="javascript:void(0)" data-id="{{$task->id}}" class="editTask"> Edit Task </a></span>
                    </div>
                  </div>
                 <div><br/>{{$task->text}}</div> 
                 <?php
                    $students=GroupMember::where('groupid',$groupId)->where('courseid',$courseId)->where('status','active')->get();
                    $i=0;
                  ?>
                  <h4><b>Students&nbsp;({{count($students)}})</b></h4>
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <td>S.No</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Status</td>
                        <td>Completed Date</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($students as $student)
                        <?php
                          $record=TaskComplete::where('student_id',$student->studentid)->where('post_id',$task->id)->first();
                          $status='Pending';
                          $completedDate='';
                          if(count($record)==1){
                            $status="Completed";
                            $completedDate=date('d M Y, H:i A',$record->time);
                          }
                        ?>
                        <tr>
                          <td><b>{{++$i}}</b></td>
                          <td>{{Students::getstudentname($student->studentid)}}</td>
                          <td>{{Students::getstudentemail($student->studentid)}}</td>
                          <td>{{$status}}</td>
                          <td>{{$completedDate}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <?php
                   $taskMeta=GroupPostMeta::where('postid',$task->id)->first();
                   $taskUrl='';
                   if(count($taskMeta)==1 && $taskMeta->video_url!=''){
                    $taskUrl=$taskMeta->video_url;
                   }
                  ?>
                  @if($taskUrl!='')
                    <h4><b>Youtube Link</b></h4>
                    <?php 
                    $url= $taskUrl;
                    $explode=explode('watch?v=',$url);
                    $youtubeLink='';
                    if(count($explode)==2){
                      $youtubeLink=$explode[1];
                    }
                    ?>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$youtubeLink}}" frameborder="0" allowfullscreen></iframe>
                  @endif
                  <?php
                    $comments=GroupComment::where('postid',$task->id)->get();
                  ?>
                  <h4><b>Comments&nbsp;({{count($comments)}})</b></h4>
                  <ul class="mailbox-inbox">
                    @foreach($comments as $comment)
                      <?php $userName=User::find($comment->commenter)->full_name; ?>
                      <li>
                        <a href="javascript:void(0)" class="item clearfix">
                          <!-- <img src="{{User::getprofileimage($comment->commenter)}}" alt="{{$userName}}" class="img"> -->
                          <span class="from">{{$userName}}</span>
                          {{$comment->comment}}
                          <span class="date">{{date('d M Y, H:i A',$comment->time)}}</span>
                        </a>
                      </li>
                    @endforeach
                      <li>
                        <a href="javascript:void(0)" class="item clearfix">
                          <!-- <img src="{{User::getprofileimage(Auth::user()->id)}}" alt="{{Auth::user()->full_name}}" class="img"> -->
                          <span class="from">{{Auth::user()->full_name}}</span>
                          <br/>
                          <p><input type="text" class="form-control newComment comment{{$task->id}}" placeholder="Post your comment..."></p>
                          <input type="button" class="btn btn-default saveComment" id="{{$task->id}}" data-panel="task" value="Submit">
                        </a>
                      </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
         @endforeach
      @else
      <div class="kode-alert kode-alert-icon alert6-light">
        <i class="fa fa-lock"></i>
        <a href="javascript:void(0)" class="closed">×</a>
        No task details available.
      </div>
      @endif
    </div>
@endif
      </div>
      <!-- End Task -->

       <!-- Start Discussion -->
      <div class="titlePanel discussionPanel" >
      <div class="title">
        <h1>{{$courseName}}</h1>
        <p><b>Discussions</b></p>
        </div>

@if($courseId=='')
<div class="panel panel-default discussionBody" style="display:none;"></div>
@else
<div class="panel panel-default discussionBody" style="height: 600px;overflow-y:scroll;">
    <?php
    $discussions=Discussion::where('groupId',$groupId)->get();
    $previousDate='';
    $previousUser='';
    $onlineUser=Auth::user()->id;
    ?>
      <ul class="conv discussionComments">
      @foreach($discussions as $discussion)
        <?php
          $discussionDate=date('Y-m-d',$discussion->time);
          $disColor='ballon color2';
          if($discussion->userId==$onlineUser){
            $disColor='ballon color1';
          }
        ?>
        @if($previousDate!=$discussionDate)
          <li class="date"><b>{{date('F d',$discussion->time)}}</b></li>
        @endif

        <li> 
          <p class="{{$disColor}}">
            @if($previousUser!=$discussion->userId)
              <span style="color:red">{{User::getuserfullname($discussion->userId)}}</span></br>
            @endif
            {{$discussion->message}}
            </br> <span>{{date('h:i A',$discussion->time)}}</span>
          </p><br>
        </li>

        <?php
          $previousUser=$discussion->userId;
          $previousDate=date('Y-m-d',$discussion->time);
        ?>

      @endforeach

      </ul>

          <div class="write" id="discussionSubmitDiv">
              {{Form::open(['class'=>'form-horizontal'])}}
                {{Form::hidden('groupId',$groupId,['class'=>'groupId'])}}
                {{Form::hidden('course',$courseId,['class'=>'currentCourseId'])}}
                <p>{{Form::text('discussionMessage','',['class'=>'form-control discussionMessage'])}}</p>
                <button class="btn btn-default saveDiscussion">Send</button>
                <button type="reset" class="btn margin-l-5">Clear</button>
              {{Form::close()}}
          </div>

</div>
@endif
      </div>
      <!-- End Discussion -->

      <!-- Start Vote -->
      <div class="titlePanel votePanel" >
      <div class="title">
        <h1>{{$courseName}}</h1>
        <p><b>Vote</b></p>
          <div aria-label="..." role="group" class="btn-group">
            <button class="btn btn-icon btn-sm btn-light addVote" type="button"><i class="fa fa-plus"></i> Add Vote</button>
          </div>
        </div>
        @if(Session::has('voteSuccess')) {!! HTML::display_success('voteSuccess') !!} @endif
        <div class="row add_row_vote" style="display:none;">
      <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">
        <div class="panel-title">
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
          </ul>
        </div>
            <div class="panel-body">
              {{Form::open(['url'=>'admin/assign/vote/add/post','class'=>'form-horizontal'])}}

                {{Form::hidden('groupId',$groupId,['class'=>'groupId'])}}
                {{Form::hidden('course',$courseId,['class'=>'currentCourseId'])}}

                <div class="form-group">
                  {{Form::label('shortDescription','Short Description *',['class'=>'control-label col-sm-2'])}}
                  <div class="col-sm-8">
                  {{Form::text('shortDescription','',['class'=>'form-control'])}}
                  @if ($errors->add->has('shortDescription')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('shortDescription') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('message','Your Message *',['class'=>'control-label col-sm-2'])}}
                  <div class="col-sm-8">
                  {{Form::textarea('message','',['class'=>'form-control','rows'=>5])}}
                  @if ($errors->add->has('message')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('message') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('endDate','End Date *',['class'=>'control-label col-sm-2'])}}
                  <div class="col-sm-8">
                  {{Form::text('endDate','',['class'=>'form-control endDate'])}}
                  @if ($errors->add->has('endDate')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('endDate') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('options','Options',['class'=>'control-label col-sm-2'])}}
                  <div class="col-sm-8">
                  {{Form::text('options[]','Yes',['class'=>'form-control','readonly'])}}
                 </div>
                </div>

                <div class="form-group cloneOption">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-8">
                  {{Form::text('options[]','No',['class'=>'form-control','readonly'])}}
                 </div>
                 <a href="javascript:void(0)" class="addOption"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="javascript:void(0)" class="removeOption" style="display:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>
                <div class="form-group">
                {{Form::label('',' ',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                {{Form::submit('Save',['class'=>'btn btn-default'])}}
                {{Form::button('Cancel',['class'=>'btn btn-info hideVote'])}}
                </div>
                </div>
              {{Form::close()}}
            </div>
      </div>
    </div>
    </div>



    <div class="panel-body">
      <?php
        $votes=Vote::where('groupId',$groupId)->where('courseId',$courseId)->get();
        $i=0;
      ?>
        @if(count($votes)>0)
            @foreach($votes as $vote)
            <?php
            $class='';
            // if($i==0){
            //   $class='in';
            //   $i++;
            // }
            $options=Votemeta::where('voteId',$vote->id)->get();
            ?>
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default panel-collapse">
              <div class="panel-heading" role="tab" id="voteheading{{$vote->id}}">
              <a class="" data-toggle="collapse" data-parent="#accordion" href="#votecollapse{{$vote->id}}" aria-expanded="true" aria-controls="votecollapse{{$vote->id}}">
                <h4 class="panel-title">
                  
                    {{$vote->short_description}}
                  
                </h4>
                </a>
              </div>
              <div id="votecollapse{{$vote->id}}" class="panel-collapse collapse {{$class}}" role="tabpanel" aria-labelledby="voteheading{{$vote->id}}" aria-expanded="true">
                <div class="panel-body">
                  <div class="status">
                    <div class="who clearfix">
                    <?php $userName=User::find($vote->created_by)->full_name; ?>
                      <!-- <img src="{!! User::getprofileimage($vote->created_by) !!}" alt="img"> -->
                      <span class="name"><b>{{$userName}}</b> </span>
                      <span class="from">at <b>{{date("d M Y, H:i A",strtotime($vote->created_at))}}</b></span>
                    </div>
                  </div>
                 <div><br/>{{$vote->message}}</div> 
                 <?php
                    $options=Votemeta::where('voteId',$vote->id)->get();
                    $i=0;
                  ?>
                  <p><h4><b>Options</b></h4></p>
                  
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <td>S.No</td>
                        <td>Name</td>
                        <td>Count</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($options as $option)
                        <tr>
                          <td><b>{{++$i}}</b></td>
                          <td>{{$option->optionName}}</td>
                          <td>{{$option->countNo}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>
         @endforeach
      @else
      <div class="kode-alert kode-alert-icon alert6-light">
        <i class="fa fa-lock"></i>
        <a href="javascript:void(0)" class="closed">×</a>
        No vote details available.
      </div>
      @endif
    </div>
      </div>
      <!-- End Vote -->


      <!-- Start Task Status -->
      <div class="titlePanel statusPanel" >

      <div class="title">
        <h1>Courses</h1>
        <p><b>Task Status</b></p>
        </div>
        <div class="panel panel-default">
    <div class="panel-body">
        <?php
          $tasks=GroupPost::where('group_id',$groupId)->where('course_id',$courseId)->where('post_type','task')->where('author',Auth::user()->id)->get();
          $i=0;
        ?>
        @if(count($tasks)>0)
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <td>S.No</td>
                        <td>Task</td>
                        <td>Student</td>
                        <td>Status</td>
                        <td>Due Date</td>
                        <td>Completed Date & Time</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($tasks as $task)
                        <?php
                          $records=GroupMember::where('groupid',$groupId)->where('courseid',$courseId)->where('status','active')->where('added_by',Auth::user()->id)->get();
                        ?>
                        @foreach($records as $record)
                          <?php
                          $recordStatus=TaskComplete::where('post_id',$task->id)->where('student_id',$record->studentid)->first();
                          $status='Pending';
                          $completedTime='';
                          if(count($recordStatus)==1){
                            $status='Completed';
                            $completedTime=date("d-M-Y, H:i A",$recordStatus->time);
                          }
                          ?>
                          <tr>
                            <td><b>{{++$i}}</b></td>
                            <td>{{$task->short_description}}</td>
                            <td>{{Students::getstudentname($record->studentid)}}</td>
                            <td>{{$status}}</td>
                            <td>{{date('d-M-Y',strtotime($task->dueDate))}}</td>
                            <td>{{$completedTime}}</td>
                          </tr>
                        @endforeach
                      @endforeach
                    </tbody>
                  </table>
      @else
      <div class="kode-alert kode-alert-icon alert6-light">
        <i class="fa fa-lock"></i>
        <a href="javascript:void(0)" class="closed">×</a>
        No task details available.
      </div>
      @endif
    </div>

    </div>


      </div>
      <!-- End Task Status -->
    </div>
  </div>
  </div>
  </div>
</div>





</div>
@stop

@section('custom-footer-scripts')
  {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
  <script type="text/javascript">
    $(document).ready(function(){
      $('.mailbox-inbox .ligroup:first').addClass('active-menu');
      $('.panelTitle').removeClass('active-menu');
      @if($courseId=='')
        $('.panelTitle:not(:first)').hide();
      @endif
      $('.addOption').hide();
      $('.removeOption').hide();
      $('.addOption:last').show();

      $(document).on('click','.changeCourseId',function(){
        var id=$(this).attr('data-id');
        $('.currentCourseId').val(id);
      });

      $(document).on('keyup','.newComment',function(){
        var text=$(this).val();
        if(text!=''){
          $(this).parent().parent().find('.saveComment').show();
        }else{
          $(this).parent().parent().find('.saveComment').hide();
        }
        return false;
      });

      $(document).on('click','.editTask',function(){
        var taskId=$(this).attr('data-id');
        $.ajax({
        type:'POST',
        data: {taskId},
        dataType:'JSON',
        url: '{{URL::action('TestController@getgrouptaskdetails')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          $('.editTaskShortDescription').val(data.shortDescription);
          $('.editTaskMessage').val(data.message);
          $('.editTaskDueDate').val(data.dueDate);
          $('.editTaskYoutube').val(data.link);
          $('.editTaskId').val(taskId);
          $('.add_row_task').hide();
          $('.edit_row_task').show('slow');
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
        return false;
      });

      $(document).on('click','.addOption',function(){
        $( ".cloneOption:last" ).clone().insertAfter('.cloneOption:last');
        $('.addOption').hide();
        $('.addOption:last').show();
        $('.removeOption').hide();
        var length=$('.cloneOption').length;
        if(length>1){
          $('.removeOption:not(:first)').show();
        }
        $('.cloneOption:last :input').removeAttr('readonly').val('');
        return false;
      });

      $(document).on('click','.removeStudent',function(){
        var id=$(this).attr('data-id');
        $.ajax({
          type:'POST',
          data: {id},
          dataType:'JSON',
          url: '{{URL::action('TestController@removestudentfromcourse')}}',
          headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
          success:function(data){
            console.log(data);
            alert('Student removed successfully.');
            $('.student'+id).remove();
          },
          error:function(e){
            console.log(e.responseText);
          }
        });
      });

      $(document).on('click','.removeOption',function(){
        $(this).closest('.cloneOption').remove();
        $('.addOption').hide();
        $('.addOption:last').show();
        $('.removeOption').hide();
        var length=$('.cloneOption').length;
        if(length>1){
          $('.removeOption:not(:first)').show();
        }
        return false;
      });

      @if($panel=='course')
      $('.coursePanel').show();
      $('#coursePanel').addClass('active-menu');
      @elseif($panel=='students')
      $('.studentsPanel').show();
      $('#studentsPanel').addClass('active-menu');
      @elseif($panel=='task')
      $('.taskPanel').show();
      $('#taskPanel').addClass('active-menu');
      @elseif($panel=='vote')
      $('.votePanel').show();
      $('#votePanel').addClass('active-menu');
      @elseif($panel=='status')
      $('.statusPanel').show();
      $('#statusPanel').addClass('active-menu');
      @elseif($panel=='discussion')
      $('.discussionPanel').show();
      $('#discussionPanel').addClass('active-menu');
      $('html, body').animate({
        scrollTop: $("#discussionSubmitDiv").offset().top
    }, 2000);
      @endif
      $('.startDate,.endDate,.dueDate,.editTaskDueDate').daterangepicker({
        singleDatePicker: true, 
        format: "DD-MM-YYYY"
      });
    });

    $(document).on('click','.saveDiscussion',function(){
      var message=$('.discussionMessage').val();
      if(message!=''){
        var groupId='{{$groupId}}';
        var type='staff';
        $.ajax({
          type:'POST',
          data: {message:message,groupId:groupId,type:type},
          dataType:'JSON',
          url: '{{URL::action('TestController@addassigndiscussionpost')}}',
          headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
          success:function(data){
            console.log(data);
            $('.discussionComments').append(data.html);
            $('.discussionMessage').val('');
          },
          error:function(e){
            console.log(e.responseText);
          }
        });
      }
      return false;
    });

    $(document).on('click','.panelTitle',function(){
      $('.panelTitle').removeClass('active-menu');
      $(this).addClass('active-menu');
      var id=$(this).attr('id');
      $('.titlePanel').hide();
      // if(id=='discussionPanel'){
      //   setTimeout(function(){

      //   var element = document.getElementById("discussionSubmitDiv");
      //   element.scrollTop = element.scrollHeight();

      //   },1000);
      // }
      $('.'+id).show();
      return false;
    });

    $(document).on('click','.addCourse',function(){
      $('.add_row_course').hide();
      $('.add_row_course').show('slow');
      return false;
    });

    $(document).on('click','.addStudents',function(){
      $('.inviteStudents').hide();
      $('.inviteStudents').show('slow');
    });

    $(document).on('click','.addTask',function(){
      $('.add_row_task').hide();
      $('.edit_row_task').hide();
      $('.add_row_task').show('slow');
    });

    $(document).on('click','.addDiscussion',function(){
      $('.add_row_discussion').hide();
      $('.add_row_discussion').show('slow');
    });

    $(document).on('click','.addVote',function(){
      $('.add_row_vote').hide();
      $('.add_row_vote').show('slow');
    });

    $(document).on('click','.hideAssignCourse',function(){
      $('.add_row_course').hide('slow');
      return false;
    });

    $(document).on('click','.hideStudents',function(){
      $('.inviteStudents').hide('slow');
    });

    $(document).on('click','.hideTask',function(){
      $('.add_row_task').hide('slow');
    });

    $(document).on('click','.hideDiscussion',function(){
      $('.add_row_discussion').hide('slow');
    });

    $(document).on('click','.hideVote',function(){
      $('.add_row_vote').hide('slow');
    });

    $(document).on('change','.className',function(){
      var val=$('.className').val();
      $.ajax({
        type:'POST',
        data: {val},
        dataType:'JSON',
        url: '{{URL::action('TestController@getclasssubjects')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          var subjects=data.subjects;
          var options='<option value="">Select Subject</option>';
          $.each(subjects,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
          });
          $('.subjectName').empty().append(options);
          $('.categoryName').empty().append('<option value="">Select Category</option>');
          $('.subcategoryName').empty().append('<option value="">Select Sub Category</option>');
          $('.courseName').empty().append('<option value="">Select Course</option>');
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
      getcourses();
    });

    $(document).on('change','.subjectName',function(){
      var classId=$('.className').val();
      var subject=$('.subjectName').val();
      $('.subcategoryName').empty();
      $('.courseName').empty();
      $('.categoryName').empty();
      if(classId!='' && subject!=''){
        $.ajax({
          type:'POST',
          data: {classId,subject},
          dataType:'JSON',
          url: '{{URL::action('TestController@getclasscategory')}}',
          headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
          success:function(data){
            console.log(data);
            var category=data.category;
            var options='<option value="">Select Category</option>';
            $.each(category,function(index,ele){
              options+='<option value='+ele['id']+'>'+ele['category_name']+'</option>';
            });
            $('.categoryName').empty().append(options);
            $('.subcategoryName').empty().append('<option value="">Select Sub Category</option>');
            $('.courseName').empty().append('<option value="">Select Course</option>');
          },
          error:function(e){
            console.log(e.responseText);
          }
        });
      }
      getcourses();
    });

    $(document).on('change','.categoryName',function(){
      var val=$(this).val();
      $.ajax({
        type:'POST',
        data: {val},
        dataType:'JSON',
        url: '{{URL::action('TestController@getcategorysub')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          var subcategory=data.subcategory;
          var options='<option value="">Select Sub Category</option>';
          $.each(subcategory,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
          });
          $('.subcategoryName').empty().append(options);
          $('.courseName').empty().append('<option value="">Select Course</option>');
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
      getcourses();
    });

    function getcourses(){
      var classs=$('.className').val();
      var subject=$('.subjectName').val();
      var category=$('.categoryName').val();
      var sub=$('.subcategoryName').val();
      var groupId=$('.groupId').val();
      $.ajax({
        type:'POST',
        data: { class:classs,subject:subject,category:category,sub:sub,groupId:groupId },
        dataType:'JSON',
        url: '{{URL::action('TestController@getsubcategorycourses')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          var courses=data.courses;
          var options='<option value="">Select Courses</option>';
          $.each(courses,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
          });
          $('.courseName').empty().append(options);
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
    }

    $(document).on('change','.subcategoryName',function(){
      getcourses();
    });

    $(document).on('click','.selectStudent',function(){
      var students='';
      $('.selectStudent:checked').each(function(){
        var val=$(this).attr('data-id');
        if(students==''){
          students=val;
        }else{
          students+=','+val;
        }
      });
      $('#studentsId').val(students);
    });

    $(document).on('click','.saveStudents',function(){
      var len=$('.selectStudent:checked').length;
      var groupId=$('.groupId').val();
      if(len==0){
        alert('Please select atlease one student');
        return false;
      }
    });

    $(document).on('change','#selectCourse',function(){
      var val=$(this).val();
      var groupId='{{$groupId}}';
      $('.taskBody').html('');
      if(val!=''){
        $.ajax({
          type:'POST',
          data: { course:val,groupId:groupId },
          dataType:'JSON',
          url: '{{URL::action('TestController@getcoursetasks')}}',
          headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
          success:function(data){
            console.log(data);
            $('.taskBody').html(data.html).show();
          },
          error:function(e){
            console.log(e.responseText);
          }
        });
      }
    });

    $(document).on('change','#discussionCourse',function(){
      var val=$(this).val();
      var groupId='{{$groupId}}';
      $('.discussionBody').html('');
      if(val!=''){
        $.ajax({
          type:'POST',
          data: { course:val,groupId:groupId },
          dataType:'JSON',
          url: '{{URL::action('TestController@getcoursediscussion')}}',
          headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
          success:function(data){
            console.log(data);
            $('.discussionBody').html(data.html).show();
          },
          error:function(e){
            console.log(e.responseText);
          }
        });
      }
    });

    $(document).on('click','.saveComment',function(){
      var postId=$(this).attr('id');
      var message=$('.comment'+postId).val();
      var groupId='{{$groupId}}';
      var courseId='{{$courseId}}';
      var panel=$(this).attr('data-panel');
      if(message==''){
        alert('Please enter comment');
        return false;
      }
      $.ajax({
        type:'POST',
        data: { message:message, postId:postId,groupId:groupId,panel:panel,courseId:courseId },
        dataType:'JSON',
        url: '{{URL::action('TestController@addtaskcommentpost')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          alert('Comment added successfully');
          window.location = data.url;
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
    });

    $(document).on('click','.completedStudent',function(){
      var id=$(this).attr('data-id');
    });

    @if(Session::has('classerror'))
      var value= "{{Session::get('classerror')}}";
      $('.'+value).show('slow');
  @endif
  </script>
@stop

