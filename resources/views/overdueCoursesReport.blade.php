
@extends('master')

@section('pageTitle')
Overdue Courses
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Report</a></li>
@stop

@section('maincontent')

 <!-- START CONTAINER -->
<div class="container-default">
 <div class="row userfilter">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default">
        <div class="panel-title">Filter</div>
            <div class="panel-body">
              <form id='manageEmployee'>
                <div class="row">
                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      {{Form::label('group','Group',['class'=>'form-label'])}}
                      {{Form::select('group',$groups,'',['class'=>'form-control','placeholder'=>'All Group'])}}                 
                  </div>
                  </div>
                  <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      {{Form::label('type','Type',['class'=>'form-label'])}}
                      {{Form::select('type',['student'=>'Student','course'=>'Course'],'',['class'=>'form-control'])}}                 
                  </div>
                </div>
                </div>
                <button id="filterStudents" class="btn btn-default btn-sm" type="button">Search</button>
              </form>
            </div>
      </div>
    </div>
  </div>

  <div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;">
            Please select group.
          </div>

<div class="panel panel-default" id="statusResult" style="display:none;">
        <div class="panel-title">
          Overdue Courses
        </div>
        <div class="panel-body table-responsive groupsTable"  style="display:none;">
          <table class="table table-hover table-striped" id="groupsTable">
            <thead>
              <tr>
                <td>S.No</td>
                <td>Group</td>
                <td>Course</td>
                <td>Total Students</td>
                <td>Start Date</td>
                <td>End Date</td>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          </div>
          <div class="panel-body table-responsive studentsTable" style="display:none;">
          <table class="table table-hover table-striped" id="studentsTable">
            <thead>
              <tr>
                <td>S.No</td>
                <td>Group</td>
                <td>Course</td>
                <td>Student Name</td>
                <td>Invited Date</td>
                <td>Status</td>
                <td>Course Due Date</td>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
      </div>
</div>
<!-- END CONTAINER -->
  @stop

  @section('custom-footer-scripts')
    {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
  {{HTML::script('js/datatables/datatables.min.js')}}
  <script>
 $('#fromDate,#toDate').daterangepicker({
    singleDatePicker: true, 
    format: "DD-MM-YYYY"
  });
$(document).ready(function(){
  $('#studentsTable').dataTable();
  $('#groupsTable').dataTable();
});
 

 $(document).on('click','#filterStudents',function(){
  $('#statusResult').hide();
  $('.groupsTable').hide();
  $('.studentsTable').hide();
  $('.errorMessage').hide();
  var group=$('#group').val();
  var type=$('#type').val();
  // if(group==''){
  //   $('.errorMessage').show();
  //   setTimeout(function(){
  //     $('.errorMessage').hide();
  //   },5000);
  //   return false;
  // }
  $.ajax({
    type: 'POST',
    url: '{{URL::action('TestController@overduecoursespost')}}',
    data: {group:group,type:type},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      if(data.count>0){
        if(type=='course'){
          var oTable = $('#groupsTable').dataTable();
          oTable.fnClearTable();
          $.each(data.result,function(key,value){
            oTable.fnAddData([data.result[key]['sno'],data.result[key]['group'],data.result[key]['course'],data.result[key]['students'],data.result[key]['startDate'],data.result[key]['endDate']]);
          });
          $('.groupsTable').show();
        }else{
          var oTable = $('#studentsTable').dataTable();
          oTable.fnClearTable();
          $.each(data.result,function(key,value){
            oTable.fnAddData([data.result[key]['sno'],data.result[key]['group'],data.result[key]['course'],data.result[key]['students'],data.result[key]['invitedDate'],data.result[key]['status'],data.result[key]['overdueDate']]);
          });
          $('.studentsTable').show();
        }
        $('#statusResult').show();
      }else{
        $('.errorMessage').show().html('No overdue courses available.');
        setTimeout(function(){
            $('.errorMessage').hide();
          },5000);
      }
    },
    error: function(e){
      console.log(e.responseText);
    }
  });
 });
  </script>
  @stop

