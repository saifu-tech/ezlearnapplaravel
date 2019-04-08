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
use App\Discussion;
?>
@extends('master')

@section('pageTitle')
Student Courses
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Student Courses</a></li>
@stop

@section('custom-header-scripts')
<style type="text/css">
  .active-menu{
    background: #cec7c7;
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
              <a href="{!! URL::to('admin/student/assign/course/get/'.$detail->id) !!}" class="item clearfix">
                <span class="from groupName">{{$detail->group_name}}</span>
                {{$detail->group_short_description}}
                <span class="date">{{date('d M Y',strtotime($detail->created_at))}}</span>
              </a>
            </li>
            @endif
            @foreach($groups as $group)
              @if($group->id!=$groupId)
            <li class="ligroup">
              <a href="{!! URL::to('admin/student/assign/course/get/'.$group->id) !!}" class="item clearfix">
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
                <li class="panelTitle" id="taskPanel">
                  <a href="javascript:void(0)"><i class="fa fa-tasks"></i> Tasks</a>
                </li>
                <li class="panelTitle" id="discussionPanel">
                  <a href="javascript:void(0)"><i class="fa fa-comments-o"></i> Discussions</a>
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
        </div>

        @if(Session::has('courseSuccess')) {!! HTML::display_success('courseSuccess') !!} @endif

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
                <a data-toggle="collapse" data-parent="#accordion" href="#course{{$course->course_id}}" aria-expanded="true" aria-controls="collapse{{$course->course_id}}" class="">
                  <h4 class="panel-title">
                    <i class="fa fa-file"></i>&nbsp; 
                      {{$courseDetails->name}}
                  </h4>
                  </a>
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
                      <div class="col-md-2">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Subscribed:</b> {{$subscribed}}</p>
                      </div>
                      <div class="col-md-2">
                      <p class="course_info"><i class="fa fa-calendar"></i><b>Completed:</b> {{$completed}}</p>
                      </div>
                      <?php
                          $count=CourseComplete::where('group_course_id',$course->id)->where('student_id',Auth::user()->userLink)->count();
                      ?>
                      @if($count==0)
                      <div class="col-md-2 courseComplete{{$course->id}}">
                      <p class="course_info"><a href="javascript:void(0)" class="courseComplete" data-id="{{$course->id}}"><i class="fa fa-calendar"></i><b>Complete Course</b></a><p>
                      </div>
                      @endif
                    </div>
                    {{$courseDetails->description}}                    
                  </div>

                   <?php $viewCourseUrl=URL::to('admin/student/assign/course/get/'.$groupId.'/task/'.$course->course_id); ?>
                   <a href="{{$viewCourseUrl}}" class="btn btn-default changeCourseId" data-id="{{$course->course_id}}">View Course</a>

                  <?php
                    $students=GroupMember::where('groupid',$groupId)->where('courseid',$course->course_id)->where('status','!=','deleted')->get();
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
                    @if(count($students)>0)
                      @foreach($students as $student)
                        <?php
                          $record=CourseComplete::where('group_course_id',$course->id)->where('student_id',$student->studentid)->first();
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


      <!-- Start Task -->
      <div class="titlePanel taskPanel" >

      <div class="title">
        <h1>{{$courseName}}</h1>
        <p><b>Tasks</p>
        </div>

        @if(Session::has('taskSuccess')) {!! HTML::display_success('taskSuccess') !!} @endif

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
                      <span class="name"><b>{{$userName}}</b> </span>
                      <span class="from">at <b>{{date("d M Y, H:i A",$task->time)}}</b></span>
                      <?php
                        $count=TaskComplete::where('student_id',Auth::user()->userLink)->where('post_id',$task->id)->count();
                      ?>
                      @if($count==0)
                      <div style="float:right" class="taskComplete{{$task->id}}"><a href="javascript:void(0)" class="taskComplete" data-id="{{$task->id}}">Complete Task</a> </div>
                      @endif
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
                    $comments=GroupComment::where('postid',$task->id)->get();
                  ?>
                  <h4><b>Comments&nbsp;({{count($comments)}})</b></h4>
                  <ul class="mailbox-inbox">
                    @foreach($comments as $comment)
                      <?php $userName=User::find($comment->commenter)->full_name; ?>
                      <li>
                        <a href="javascript:void(0)" class="item clearfix">
                          <span class="from">{{$userName}}</span>
                          {{$comment->comment}}
                          <span class="date">{{date('d M Y, H:i A',$comment->time)}}</span>
                        </a>
                      </li>
                    @endforeach
                      <li>
                        <a href="javascript:void(0)" class="item clearfix">
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
          $currentDate=date('Y-m-d',$discussion->time);
          $disColor='ballon color2';
          if($discussion->userId==$onlineUser){
            $disColor='ballon color1';
          }
        ?>
        @if($previousDate!=$currentDate)
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

          <div class="write">
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

      $(document).on('click','.saveDiscussion',function(){
      var message=$('.discussionMessage').val();
      if(message!=''){
        var groupId='{{$groupId}}';
        var type='student';
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
      @endif
      $('.startDate,.endDate,.dueDate').daterangepicker({
        singleDatePicker: true, 
        format: "DD-MM-YYYY"
      });
    });

    $(document).on('click','.panelTitle',function(){
      $('.panelTitle').removeClass('active-menu');
      $(this).addClass('active-menu');
      var id=$(this).attr('id');
      $('.titlePanel').hide();
      $('.'+id).show();
      return false;
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

    $(document).on('click','.courseComplete',function(){
      var groupCourseId=$(this).attr('data-id');
      $.ajax({
        type:'POST',
        data: { groupCourseId:groupCourseId},
        dataType:'JSON',
        url: '{{URL::action('TestController@studentcoursecompletepost')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          $('.courseComplete'+groupCourseId).remove();
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
    });


    $(document).on('click','.taskComplete',function(){
      var postId=$(this).attr('data-id');
      $.ajax({
        type:'POST',
        data: { postId:postId},
        dataType:'JSON',
        url: '{{URL::action('TestController@studenttaskcompletepost')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          $('.taskComplete'+postId).remove();
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
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
      var loginUser='student';
      if(message==''){
        alert('Please enter comment');
        return false;
      }
      $.ajax({
        type:'POST',
        data: { message:message, postId:postId,groupId:groupId,panel:panel,courseId:courseId,loginUser:loginUser },
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

