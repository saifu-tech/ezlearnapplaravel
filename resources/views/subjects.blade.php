<?php
  use App\Subjects;
  use App\Classname;
  use App\Options;
  use App\Privilege;
  $lable1=Options::getvalue('lable1');
  $lable2=Options::getvalue('lable2');
?>

@extends('master')

@section('pageTitle')
{{$lable2}}
@stop

<style type="text/css">
  .sort-icon {
    font-size: 9px;
    margin-left: 5px;
}

th {
    cursor:pointer;
}
</style>

@section('breadcrumb')
  <li><a href="javascript:void(0)">Masters</a></li>
  <li><a href="javascript:void(0)">{{$lable2}}</a></li>
@stop

@section('maincontent')

 <!-- START CONTAINER -->
<div class="container-default" ng-app="subjectFilter" ng-controller="subjectController">

 <div aria-label="..." role="group" class="btn-group">
 @if(Privilege::getprivilegestatus(2,Auth::user()->id,'addStatus')=='yes')
    <a href="javascript:void(0)" class="btn btn-light btn-sm addJob"><i class="fa fa-plus"></i>Add</a>
  @endif
  @if(Privilege::getprivilegestatus(2,Auth::user()->id,'deleteStatus')=='yes')
    <a class="btn btn-light btn-sm deleteButton" type="button"><i class="fa fa-trash"></i>Delete</a>
  @endif
  </div>

<div class="row add_row"  style="display: none">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Add {{$lable2}}
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>

            <div class="panel-body">
              {{Form::open(['url'=>'admin/masters/subjects/add/post'])}}
              @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif

                <div class="form-group">
                  {{Form::label('class',$lable1." *",['class'=>'form-label'])}}
                  {{Form::select('class',$classes,'',['class'=>'form-control','placeholder'=>'Select '.$lable1])}}
                  @if ($errors->add->has('class')) 
                    <div class="validation-error errorActive asterisk">
                       The {{$lable1}} field is required.
                   </div> 
                 @endif
                </div>

                <div class="form-group">
                  {{Form::label('subjectCode','Code *',['class'=>'form-label'])}}
                  {{Form::text('subjectCode',Subjects::autogeneratecode(),['class'=>'form-control'])}}
                  @if ($errors->add->has('subjectCode')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('subjectCode') }}
                   </div> 
                 @endif
                </div>
                <div class="form-group">
                  {{Form::label('subjectName','Name *',['class'=>'form-label'])}}
                  {{Form::text('subjectName','',['class'=>'form-control'])}}
                  @if ($errors->add->has('subjectName')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('subjectName') }}
                   </div> 
                 @endif
                </div>
                {{Form::submit('Save',['class'=>'btn btn-default'])}}
              {{Form::close()}}
            </div>

      </div>
    </div>
    </div>

      <div class="row edit_row" style="display: none">
        <div class="col-md-12 col-lg-12">
            <div class="panel panel-default">

              <div class="panel-title">
                Edit {{$lable2}}
                <ul class="panel-tools">
                  <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                  <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
                  <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                </ul>
              </div>

              <div class="panel-body">
                {{Form::open(['url'=>'admin/masters/subjects/edit/post'])}}
                @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif

                <div class="form-group">
                  {{Form::label('class',$lable1." *",['class'=>'form-label'])}}
                  {{Form::select('class',$classes,'',['class'=>'form-control editClass','placeholder'=>'Select '.$lable1])}}
                  @if ($errors->edit->has('class')) 
                    <div class="validation-error errorActive asterisk">
                       The {{$lable1}} field is required.
                   </div> 
                 @endif
                </div>

                  <div class="form-group">
                    {{Form::label('subjectCode','Code *',['class'=>'form-label'])}}
                    {{Form::text('subjectCode','',['class'=>'form-control editSubjectCode'])}}
                    @if ($errors->edit->has('subjectCode')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->edit->first('subjectCode') }}
                     </div> 
                   @endif
                  </div>

                  <div class="form-group">
                    {{Form::label('subjectName','Name *',['class'=>'form-label'])}}
                    {{Form::text('subjectName','',['class'=>'form-control editSubjectName'])}}
                    @if ($errors->edit->has('subjectName')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->edit->first('subjectName') }}
                     </div> 
                   @endif
                  </div>
                  {{Form::hidden('editId','',['class'=>'editRowId'])}}
                  {{Form::submit('Update',['class'=>'btn btn-default'])}}
                {{Form::close()}}
              </div>

            </div>
          </div>
          </div>

<div class="row manage_row" id="">

        

    <!-- Start Panel -->
    <div class="col-md-12">

      <div class="panel panel-default">
        <div class="panel-title">
          List of {{$lable2}}
        </div>
        <div class="panel-body table-responsive">

          <div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;">
            <i class="fa fa-lock"></i>
            <a href="#" class="closed">×</a>
            <span></span>
          </div>
            <div style="float: left;"><b>Shows</b> &nbsp;&nbsp;<select ng-model="recordLimit"  ng-init="recordLimit=10" ng-options="item for item in recordArray">
    </select></div>
    <div style="float: right;"><b>Search</b> &nbsp;&nbsp;<input type="text" ng-model="filterSearch"></div>
            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th ng-click="sort('s_no')">S.No <span class="glyphicon sort-icon" ng-show="sortKey=='s_no'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                        
                        <th ng-click="sort('code')">Code <span class="glyphicon sort-icon" ng-show="sortKey=='code'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                        
                        <th ng-click="sort('name')">Name <span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                        
                        <th ng-click="sort('class')">{{$lable1}} <span class="glyphicon sort-icon" ng-show="sortKey=='class'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                        @if(Privilege::getprivilegestatus(2,Auth::user()->id,'editStatus')=='yes')
                        <th>Edit</th>
                        @endif
                        @if(Privilege::getprivilegestatus(2,Auth::user()->id,'deleteStatus')=='yes')
                        <th><i class="fa fa-trash"></i></th>
                        @endif
                    </tr>
                </thead>
             
                <tbody>
                  <tr dir-paginate="rec in records |orderBy:sortKey:reverse | filter: filterSearch|itemsPerPage:recordLimit">
                      <td>@{{rec.sno}}</td>
                      <td>@{{rec.code}}</td>
                      <td>@{{rec.name}}</td>
                      <td>@{{rec.class}}</td>
                      @if(Privilege::getprivilegestatus(2,Auth::user()->id,'editStatus')=='yes')
                      <td><a href="javascript:void(0)" class="edit" editId="@{{rec.id}}"><i class="fa fa-pencil-square-o"></i></a></td>
                      @endif
                      @if(Privilege::getprivilegestatus(2,Auth::user()->id,'deleteStatus')=='yes')
                      <td><div class="checkbox"><input type="checkbox" id="checkbox@{{rec.sno}}" class="selectRecords" data-record="@{{rec.id}}"><label for="checkbox@{{rec.sno}}"></label></div></td>
                      @endif
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
    </div>
    </div>
    <!-- End Panel -->
<!--end data table-->
</div>
<!-- END CONTAINER -->
  @stop
  @section('custom-footer-scripts')
  {{HTML::script('js/datatables/datatables.min.js')}}
  {{HTML::script('js/bootbox/bootbox.min.js')}}
  {{HTML::script('js/angular.min.js')}}
  {{HTML::script('js/dirPagination.js')}}
  {{HTML::script('js/subjectfilter.js')}}
  <script>
  $(document).ready(function() {
      // $('#example0').DataTable();
  });


  $(document).on('click','.deleteButton',function(){
    $('.edit_row,.add_row').hide('slow');
    $('.successMessage').hide('slow');
    $('.errorMessage').hide('slow');
    var len=$('.selectRecords:checked').length;
    if(len==0){
      $('.errorMessage span').html('Please select atlease one record.');
      $('.errorMessage').show('slow');
      return false;
    }
    var ids=[];
    $('.selectRecords:checked').each(function(){
      var id=$(this).attr('data-record');
      ids.push(id);
    });
    ids=JSON.stringify(ids);
     $.ajax({
        type: 'POST',
       url: '{{URL::action('TestController@deletesubjectspost')}}',
       data: {ids:ids},
       dataType: 'json',
       headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
       success: function(data){
          console.log(data);
          $('.selectRecords:checked').closest('tr').remove();
          $('.errorMessage span').html('Selected record deleted successfull.');
          $('.errorMessage').show('slow');
      return false;
        },
        error: function(e){
          console.log(e.responseText);
        }
      });
    return false;
  });

  $(document).on('click','.edit',function(){
    $('.add_row').hide('slow');
    $('.edit_row').hide('slow');
    $('.successMessage').hide('slow');
    $('.errorMessage').hide('slow');
    var editId= $(this).attr('editId');
    $.ajax({
      type:'POST',
      data: {editId},
      dataType:'JSON',
      url: '{{URL::action('TestController@getsubjectspost')}}',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success:function(data){
        console.log(data);
        if(data.status=='success'){
          var name= data.name;
          $('.editClass').val(data.class);
          $('.editSubjectName').val(name);
          $('.editSubjectCode').val(data.code);
          $('.editRowId').val(editId);
          $('.edit_row').show('slow');
        }
      },
      error:function(e){
        console.log(e.responseText);
      }
    });
    
  });

  $(document).on('click','.addJob',function(){
      $('.edit_row').hide('slow');
      $('.successMessage').hide('slow');
      $('.errorMessage').hide('slow');
      // $('.add_row input[type="text"]').val('');
       $('.add_row').show('slow');
  });

   @if(Session::has('subjectserror'))
    var value= "{{Session::get('subjectserror')}}";
    $('.'+value).show('slow');
  @endif
  </script>
  @stop

