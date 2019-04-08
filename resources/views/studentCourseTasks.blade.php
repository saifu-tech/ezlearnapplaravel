<?php
use App\Group;
use App\Students;
use App\Dailytasksstatus;
?>
@extends('master')

@section('pageTitle')
Course Tasks
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Course Tasks</a></li>
@stop

@section('maincontent')




 <!-- START CONTAINER -->
<div class="container-default">
@if(count($groups)>0)
 <div class="row userfilter">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default">
        <div class="panel-title">Filter</div>
            <div class="panel-body">
              <form id='manageEmployee'>
                <div class="row">

                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      {{Form::label('group','Group *',['class'=>'form-label'])}}
                      {{Form::select('group',$groups,'',['class'=>'form-control','placeholder'=>'Select Group'])}}                 
                  </div>
                </div>

                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      {{Form::label('course','Courses *',['class'=>'form-label'])}}
                      {{Form::select('course',[],'',['class'=>'form-control','placeholder'=>'Select Course'])}}                 
                  </div>
                </div>

                </div>
                <button id="filterTask" class="btn btn-default btn-sm" type="button">Search</button>
              </form>
            </div>
      </div>
    </div>
  </div>
@else
<div class="alert alert-danger">No courses assinged to you.</div>
@endif

  <div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;"></div>
<?php
        $status=Dailytasksstatus::all();
        ?>
<div class="panel panel-default" id="statusResult" style="display:none;">
        <div class="panel-title"> Tasks</div>

        <div class="panel-body" style="margin-top:30px;">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">



          







          </div>
        </div>
      </div>
    <!-- End Panel -->
<!--end data table-->
</div>
<!-- END CONTAINER -->
  @stop

  @section('custom-footer-scripts')
  <script>
 $(document).on('click','#filterTask',function(){
  $('.add_row').hide();
  $('#statusResult').hide();
  $('.errorMessage').hide();
  var group=$('#group').val();
  var course=$('#course').val();
  if(group==''){
    $('.errorMessage').show().html('Please select Group.');
    setTimeout(function(){
      $('.errorMessage').hide();
    },5000);
    return false;
  }

  if(course==''){
    $('.errorMessage').show().html('Please select Course.');
    setTimeout(function(){
      $('.errorMessage').hide();
    },5000);
    return false;
  }
  $.ajax({
    type: 'POST',
    url: '{{URL::action('TestController@getstudentcoursetask')}}',
    data: {group:group,course:course},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      $('.panel-group').html(data.html);
      $('#statusResult').show();
    },
    error: function(e){
      console.log(e.responseText);
    }
  });
 });

 $(document).on('change','#group',function(){
   var group=$('#group').val();
   $.ajax({
    type: 'POST',
    url: '{{URL::action('TestController@studentgroupcourseget')}}',
    data: {group:group},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      var courses=data.courses;
      var html='<option value="">Select Course</option>';
      $.each(courses,function(ele,val){
        html+='<option value="'+ele+'">'+val+'</option>';
      });
      $('#course').empty().append(html);
    },
    error: function(e){
      console.log(e.responseText);
    }
  });
 });


 $(document).on('click','.saveComment',function(){
      var postId=$(this).attr('id');
      var message=$('.comment'+postId).val();
      if(message==''){
        alert('Please enter comment');
        return false;
      }
      $.ajax({
        type:'POST',
        data: { message:message, postId:postId},
        dataType:'JSON',
        url: '{{URL::action('TestController@addstudenttaskcommentpost')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          $( data.html ).insertBefore( ".mailbox-inbox li:last" );
          $('.comment'+postId).val('');
          $('.mailbox-inbox li:last').append('<div class="alert alert-success commentSuccess">New comment added successfully.</div>');
          $('.commentTitle'+postId).html(data.commentTitle);
          setTimeout(function(){
            $('.commentSuccess').hide();
          },5000);
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
    });

  </script>
  @stop

