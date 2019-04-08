<?php
use App\Group;
use App\Students;
use App\Dailytasksstatus;
?>
@extends('master')

@section('pageTitle')
Student Daily Tasks
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Daily Tasks</a></li>
@stop

@section('maincontent')




 <!-- START CONTAINER -->
<div class="container-default">
 <div class="row userfilter" style="display:none;">
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
                      {{Form::label('fromDate','From Date',['class'=>'form-label'])}}
                      {{Form::text('fromDate','',['class'=>'form-control'])}}                 
                  </div>
                </div>
                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      {{Form::label('toDate','To Date',['class'=>'form-label'])}}
                      {{Form::text('toDate','',['class'=>'form-control'])}}                 
                  </div>
                </div>
                </div>
                <button id="filterTask" class="btn btn-default btn-sm" type="button">Search</button>
              </form>
            </div>
      </div>
    </div>
  </div>

  <div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;">
            <i class="fa fa-lock"></i>
            <a href="javascript:void(0)" class="closed">×</a>
            Please select group.
          </div>

<div class="panel panel-default" id="statusResult">
        <div class="panel-title"> {{Auth::user()->full_name}} - Daily Tasks
        </div>

        <div class="panel-body" style="margin-top:30px;">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


            <div class="panel panel-default panel-collapse">
                <div class="panel-heading" role="tab" id="heading12345">
                  <h4 class="panel-title">
                    <i class="fa fa-file"></i>&nbsp; <a data-toggle="collapse" data-parent="#accordion" href="#course12345" aria-expanded="true" aria-controls="collapse12345" class="">
                      GroupName
                    </a>
                  </h4>
                </div>
                <div id="course12345" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading12345" aria-expanded="true">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <td>Tasks</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Parthasarathi</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>



          </div>
        </div>
      </div>
    <!-- End Panel -->
<!--end data table-->
</div>
<!-- END CONTAINER -->
  @stop

  @section('custom-footer-scripts')
    {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
  <script>
 $('#fromDate,#toDate').daterangepicker({
    singleDatePicker: true, 
    format: "DD-MM-YYYY"
  });

 $(document).on('click','#filterTask',function(){
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
  var fromDate=$('#fromDate').val();
  var toDate=$('#toDate').val();
  $.ajax({
    type: 'POST',
    url: '{{URL::action('TestController@taskstatusreport')}}',
    data: {group:group,fromDate:fromDate,toDate:toDate},
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
  </script>
  @stop

