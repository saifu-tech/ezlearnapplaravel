<?php
use App\Options;
$lable1=Options::getvalue('lable1');
$lable2=Options::getvalue('lable2');
?>
@extends('master')

@section('pageTitle')
Masters Data Details
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Report</a></li>
@stop

@section('maincontent')

 <!-- START CONTAINER -->
<div class="container-default" ng-app="mastersReportFilter" ng-controller="mastersReportController">
 <div class="row userfilter">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default">
        <div class="panel-title">Filter</div>
            <div class="panel-body">
              <form id='manageEmployee'>
                <div class="row">
                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      {{Form::label('class',$lable1,['class'=>'form-label'])}}
                      {{Form::select('class',$classes,'',['class'=>'form-control','placeholder'=>'All '.$lable1])}}                 
                  </div>
                  </div>
                  <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      {{Form::label('subject',$lable2,['class'=>'form-label'])}}
                      {{Form::select('subject',[''=>'All '.$lable2],'',['class'=>'form-control'])}}                 
                  </div>
                </div>

                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      {{Form::label('categories','Categories',['class'=>'form-label'])}}
                      {{Form::select('categories',[''=>'All Categories'],'',['class'=>'form-control'])}}                 
                  </div>
                </div>

                </div>
                <button class="btn btn-default btn-sm" type="button" ng-click="getresult()" >Search</button>
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
          Master Data Details
        </div>
        <div style="float: left;"><b>Shows</b> &nbsp;&nbsp;<select ng-model="recordLimit" ng-init="recordLimit=10" ng-options="item for item in recordArray">
    </select></div>
    <div style="float: right;"><b>Search</b> &nbsp;&nbsp;<input type="text" ng-model="filterSearch"></div>
          <table class="table table-hover table-striped" id="mastersTable">
            <thead>
              <tr>
                <td ng-click="sort('s_no')">S.No</td>
                <td ng-click="sort('class')">{{$lable1}}</td>
                <td ng-click="sort('subject')">{{$lable2}}</td>
                <td ng-click="sort('category')">Categories</td>
                <td ng-click="sort('course')">Courses</td>
              </tr>
            </thead>
            <tbody>
            <tr dir-paginate="rec in records |orderBy:sortKey:reverse | filter: filterSearch|itemsPerPage:recordLimit">
            <td>@{{rec.sno}}</td>
             <td>@{{rec.class}}</td>
             <td>@{{rec.subject}}</td>
             <td>@{{rec.category}}</td>
             <td>@{{rec.course}}</td>
            </tr>
            </tbody>
          </table>

          <dir-pagination-controls
       max-size="10"
       direction-links="true"
       boundary-links="true" >
    </dir-pagination-controls>
</div>
</div>
<!-- END CONTAINER -->
  @stop

  @section('custom-footer-scripts')
    {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
  {{HTML::script('js/datatables/datatables.min.js')}}
   {{HTML::script('js/angular.min.js')}}
  {{HTML::script('js/dirPagination.js')}}
  {{HTML::script('js/mastersreportfilter.js')}}
  <script>
 $('#fromDate,#toDate').daterangepicker({
    singleDatePicker: true, 
    format: "DD-MM-YYYY"
  });

 $(document).on('change','#class',function(){
      var val=$('#class').val();
      $.ajax({
        type:'POST',
        data: {val},
        dataType:'JSON',
        url: '{{URL::action('TestController@getclasssubjects')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          var subjects=data.subjects;
          var options='<option value="">All '+'{{$lable2}}'+'</option>';
          $.each(subjects,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
          });
          $('#subject').empty().append(options);
          $('#categories').empty().append('<option value="">All Category</option>');
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
    });

    $(document).on('change','#subject',function(){
      var classId=$('#class').val();
      var subject=$('#subject').val();
      $('#categories').empty();
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
            var options='<option value="">All Category</option>';
            $.each(category,function(index,ele){
              options+='<option value='+ele['id']+'>'+ele['category_name']+'</option>';
            });
            $('#categories').empty().append(options);
          },
          error:function(e){
            console.log(e.responseText);
          }
        });
      }
    });
  </script>
  @stop

