<?php
use App\Group;
use App\Students;
use App\Dailytasksstatus;
?>
@extends('master')

@section('pageTitle')
Courses Status
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Courses Status</a></li>
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
              </div>
              <button id="filterTask" class="btn btn-default btn-sm" type="button">Search</button>
            </form>
          </div>
      </div>
    </div>
  </div>
@else
<div class="kode-alert kode-alert-icon alert6-light">
  <i class="fa fa-lock"></i>
  <a href="javascript:void(0)" class="closed">×</a>
  No groups available.
</div>
@endif
<div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;">
  <i class="fa fa-lock"></i>
  <a href="javascript:void(0)" class="closed">×</a>
  Please select group.
</div>

<div class="panel panel-default" id="statusResult" style="display:none;">
        <div class="panel-title">
          <span class="col-sm-6 tableGroupName"></span>
          <span class="col-sm-6" style="float:right">
              Pending: <span class="label" style="background-color:#ff0000">&nbsp;&nbsp;&nbsp;</span> &nbsp;&nbsp;
              Completed: <span class="label" style="background-color:#00ff00">&nbsp;&nbsp;&nbsp;</span> &nbsp;&nbsp;
          </span>
        </div>

        <div class="panel-body" style="margin-top:30px;">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          </div>
        </div>
      </div>
    <!-- End Panel -->
<!--end data table-->
</div>
<!-- END CONTAINER -->


<!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Change Task Status</h4>
        </div>
        <div class="modal-body">
        
        {{Form::open(['class'=>'form-horizontal'])}}
        <div class="form-group">
          {{Form::label('courseGroup','Group Name',['class'=>'col-sm-3 control-label'])}}
            <div class="col-sm-8 groupNameDiv">
            </div>
          </div>

          <div class="form-group">
          {{Form::label('courseName','Course Name',['class'=>'col-sm-3 control-label'])}}
            <div class="col-sm-8 courseNameDiv">
            </div>
          </div>

        <div class="form-group">
          {{Form::label('courseStatus','Status',['class'=>'col-sm-3 control-label'])}}
          <div class="col-sm-8 modalTaskStatus">
            {{Form::radio('courseStatus','pending',true)}}&nbsp;Pending&nbsp;&nbsp;&nbsp;
            {{Form::radio('courseStatus','completed',false)}}&nbsp;Completed&nbsp;&nbsp;&nbsp;
          </div>
        </div>

        <div class="form-group completedDateDiv" style="display:none;">
          {{Form::label('completedDate','Date',['class'=>'col-sm-3 control-label'])}}
            <div class="col-sm-8">
            {{Form::text('comletedDate','',['class'=>'form-control completedDate'])}}
            </div>
          </div>

        <div class="clearfix"></div>
        {{Form::hidden('courseId','',['class'=>'courseId'])}}
        {{Form::hidden('studentId','',['class'=>'studentId'])}}
        {{Form::close()}}
        
        </div>
        <div class="alert alert-success modalSuccess" style="display:none;"></div>
        <div class="alert alert-danger modalError" style="display:none;"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary saveTaskUpdate">Update</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!--END Modal -->
  @stop

  @section('custom-footer-scripts')
    {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
  <script>
 $('.completedDate').daterangepicker({
    singleDatePicker: true, 
    format: "DD-MM-YYYY"
  });


 $(document).on('click','.addJob',function(){
      $('.add_row').toggle();
      $('.add_row:input').val('');
      $('.successMessage').hide('slow');
      $('.errorMessage').hide('slow');
       $('#statusResult').hide();
       return false;
  });

 $(document).on('click','.saveTaskUpdate',function(){
   var course=$('.courseId').val();
   var student=$('.studentId').val();
   var status=$('input[name="courseStatus"]:checked').val();
   if(status=='completed'){
    var completedDate=$('.completedDate').val();
   }else{
    var completedDate='';
   }
   $.ajax({
    type: 'POST',
    url: '{{URL::action('TestController@updatestudentcoursesstatus')}}',
    data: {course:course,student:student,status:status,completedDate:completedDate},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      $('.currentUpdateStatus').css( "background-color",data.color );
      $('.modalSuccess').show().html('Course status updated successfully.');
      $('#myModal').modal('show');
      setTimeout(function(){
        $('.modalSuccess,.modalError').hide();
        $('#myModal').modal('hide');
      },5000);
    },
    error: function(e){
      console.log(e.responseText);
    }
  });

 });

 $(document).on('click','.updateStatus',function(){
  $('.modalSuccess,.modalError').hide();
  $('.updateStatus').removeClass('currentUpdateStatus');
  $(this).addClass('currentUpdateStatus');
  var course=$(this).attr('data-course');
  var student=$(this).attr('data-student');
  $.ajax({
    type: 'POST',
    url: '{{URL::action('TestController@getdailytaskdetails')}}',
    data: {course:course,student:student},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      var parent=$('#myModal');
      parent.find('.courseId').val(course);
      parent.find('.studentId').val(student);
      var status=data.status;
      if(status!=''){
        $('.modalTaskStatus input').each(function(){
          var val=$(this).val();
          if(val==status){
            $(this).prop('checked',true);
          }
        });
      }
      $('.groupNameDiv').text(data.groupName);
      $('.courseNameDiv').text(data.courseName);
      if(data.completedDate!=''){
        $('.completedDate').val(data.completedDate);
        $('.completedDateDiv').show();
      }else{
        $('.completedDate').val('');
        $('.completedDateDiv').hide();
      }
      $('#myModal').modal('show');
    },
    error: function(e){
      console.log(e.responseText);
    }
  });

  return false;
 });

 $(document).on('click','#courseStatus',function(){
  var val=$(this).val();
  if(val=='completed'){
    $('.completedDateDiv').show();
  }else{
    $('.completedDateDiv').hide();
  }
 });

 $(document).on('click','#filterTask',function(){
  $('.add_row').hide();
  $('#statusResult').hide();
  $('.errorMessage').hide();
  var group=$('#group').val();
  if(group==''){
    $('.errorMessage').show();
    setTimeout(function(){
      $('.errorMessage').hide();
    },5000);
    return false;
  }
  $.ajax({
    type: 'POST',
    url: '{{URL::action('TestController@groupcoursestatusreport')}}',
    data: {group:group},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      $('.panel-group').html(data.html);
      $('.tableGroupName').html(data.groupName);
      $('#statusResult').show();
    },
    error: function(e){
      console.log(e.responseText);
    }
  });
 });

 $(document).on('change','#dailyGroup',function(){
   var group=$('#dailyGroup').val();
   $.ajax({
    type: 'POST',
    url: '{{URL::action('TestController@getdailygroupoptions')}}',
    data: {group:group},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      var options=data.options;
      var html='<option value="">Select option</option>';
      $.each(options,function(ele,val){
        html+='<option value="'+ele+'">'+val+'</option>';
      });
      $('#option').empty().append(html);

      var status=data.status;
      if(status!=''){
        $('.statusDiv').html(status);
      }
      $('.statusDiv').show();
      getcurrenttaskstatus();
    },
    error: function(e){
      console.log(e.responseText);
    }
  });
 });

 $(document).on('change','#option,#statusDate',function(){
  getcurrenttaskstatus();
 });

 function getcurrenttaskstatus(){
    var group=$('#dailyGroup').val();
    var statusDate=$('#statusDate').val();
    var option=$('#option').val();
    if(group!='' && statusDate!='' && option!=''){
      $.ajax({
        type: 'POST',
        url: '{{URL::action('TestController@getdailytaskstatuspost')}}',
        data: {group:group,statusDate:statusDate,option:option},
        dataType: 'json',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success: function(data){
          console.log(data);
          var status=data.currentStatus;
          if(status!=''){
            $('.statusDiv input').each(function(){
              var val=$(this).val();
              if(val==status){
                $(this).prop('checked',true);
              }
            });
          }
        },
        error: function(e){
          console.log(e.responseText);
        }
      });
    }
    return true;
 }

 @if(Session::has('taskserror'))
    var value= "{{Session::get('taskserror')}}";
    $('.'+value).show('slow');
  @endif
  </script>
  @stop

