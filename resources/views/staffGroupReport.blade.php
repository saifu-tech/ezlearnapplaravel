
@extends('master')

@section('pageTitle')
Staff Groups 
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
                      {{Form::label('staff','Staff',['class'=>'form-label'])}}
                      {{Form::select('staff',$staffs,'',['class'=>'form-control','placeholder'=>'All staffs'])}}                 
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
            <i class="fa fa-lock"></i>
            <a href="javascript:void(0)" class="closed">×</a>
            Please select student.
          </div>

<div class="panel panel-default" id="statusResult" style="display:none;">
  <div class="panel-title">
    Staff Group
  </div>
  <div class="panel-body table-responsive">
    <table class="table table-hover table-striped" id="studentsTable">
      <thead>
        <tr>
          <td>S.No</td>
          <td>Group Name</td>
          <td>Staff</td>
          <td>Description</td>
          <td>Total Courses</td>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
    <!-- End Panel -->
<!--end data table-->
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
});
 

 $(document).on('click','#filterStudents',function(){
  $('#statusResult').hide();
  $('.errorMessage').hide();
  var staff=$('#staff').val();
  // if(staff==''){
  //   $('.errorMessage').show();
  //   setTimeout(function(){
  //     $('.errorMessage').hide();
  //   },5000);
  //   return false;
  // }
  $.ajax({
    type: 'POST',
    url: '{{URL::action('TestController@staffgroupspost')}}',
    data: {staff:staff},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      var oTable = $('#studentsTable').dataTable();
      oTable.fnClearTable();
      $.each(data.result,function(key,value){
        oTable.fnAddData([data.result[key]['sno'],data.result[key]['name'],data.result[key]['staff'],data.result[key]['description'],data.result[key]['courses']]);
      });
      $('#statusResult').show();
    },
    error: function(e){
      console.log(e.responseText);
    }
  });
 });
  </script>
  @stop

