<?php
use App\Group;
use App\Students;
use App\Dailytasksstatus;
?>
@extends('master')

@section('pageTitle')
User Privilege 
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Staff</a></li>
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
                      {{Form::label('user','User *',['class'=>'form-label'])}}
                      {{Form::select('user',$users,'',['class'=>'form-control','placeholder'=>'Select User'])}}                 
                  </div>
                </div>
                </div>
              </form>
            </div>
      </div>
    </div>
  </div>


<div class="panel panel-default" id="statusResult" style="display:none">
        <div class="panel-title">
          <span class="col-sm-6 tableGroupName"></span><span class="col-sm-6 statusColors" style="float:right">

          </span>
        </div>

          <table class="table table-striped" id="privilegeTable">
            <thead>
              <tr>
                <th>Page </th>
                <th>View &nbsp;<input class="viewAllClass" name="viewAllClass" type="checkbox"></th>
                <th>Add &nbsp;<input class="addAllClass" name="addAllClass" type="checkbox"></th>
                <th>Edit &nbsp;<input class="editAllClass" name="editAllClass" type="checkbox"></th>
                <th>Delete &nbsp;<input class="deleteAllClass" name="deleteAllClass" type="checkbox"></th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>

          <button id="savePrivilege" class="btn btn-default btn-sm" type="button">Save</button>
      </div>
      <div class="alert alert-success privilegeMessage" style="display:none;"> User privilege saved successfully.</div>
    <!-- End Panel -->
<!--end data table-->
</div>
<!-- END CONTAINER -->


  @stop

  @section('custom-footer-scripts')
    {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
  <script>
 $('#fromDate,#toDate,#statusDate').daterangepicker({
    singleDatePicker: true, 
    format: "DD-MM-YYYY"
  });

 $(document).on('click','.pageClass .addClass,.editClass,.deleteClass',function(){
    var len=$(this).parent().parent().find('.pageCheckbox:checked').length;
    if(len>0){
      $(this).parent().parent().find('.pageCheckbox:first').prop('checked',true);
    }
    checkallcheckbox()
 });

 $(document).on('click','.viewClass',function(){
  if(!$(this).is(':checked')){
    $(this).parent().parent().find('.pageCheckbox').prop('checked',false);
  }
  checkallcheckbox()
 });

 $(document).on('click','.viewAllClass,.addAllClass,.editAllClass,.deleteAllClass',function(){
    var name=$(this).attr('name');

    if(name=='viewAllClass'){
      name='viewClass';
    }else if(name=='addAllClass'){
      name='addClass';
    }else if(name=='editAllClass'){
      name='editClass';
    }else if(name=='deleteAllClass'){
      name='deleteClass';    }
    if($(this).is(':checked')){
      $('.'+name).prop('checked',true);
      $('.viewClass').prop('checked',true);
      $('.viewAllClass').prop('checked',true);
    }else{
      if(name=='viewClass'){
        $('.pageCheckbox').prop('checked',false);
        $('.viewAllClass,.addAllClass,.editAllClass,.deleteAllClass').prop('checked',false);
      }
      $('.'+name).prop('checked',false);
    }
 });

 function checkallcheckbox(){
    var view=$('.viewClass').length;
    var viewChecked=$('.viewClass:checked').length;

    var add=$('.addClass').length;
    var addChecked=$('.addClass:checked').length;

    var edit=$('.editClass').length;
    var editChecked=$('.editClass:checked').length;

    var deleted=$('.deleteClass').length;
    var deletedChecked=$('.deleteClass:checked').length;

    if(view==viewChecked){
      $('.viewAllClass').prop('checked',true);
    }else{
      $('.viewAllClass').prop('checked',false);
    }

    if(add==addChecked){
      $('.addAllClass').prop('checked',true);
    }else{
      $('.addAllClass').prop('checked',false);
    }

    if(edit==editChecked){
      $('.editAllClass').prop('checked',true);
    }else{
      $('.editAllClass').prop('checked',false);
    }

    if(deleted==deletedChecked){
      $('.deleteAllClass').prop('checked',true);
    }else{
      $('.deleteAllClass').prop('checked',false);
    }
 }

 $(document).on('change','#user',function(){
  var user=$('#user').val();
  $('#statusResult').hide();
  $('.privilegeMessage').hide();
  if(user!=''){
    $.ajax({
      type: 'POST',
      url: '{{URL::action('TestController@getuserprivilege')}}',
      data: {user:user},
      dataType: 'json',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success: function(data){
        console.log(data);
        $('#privilegeTable').find('tbody').html(data.html);
        $('#statusResult').show();
        checkallcheckbox();
      },
      error: function(e){
        console.log(e.responseText);
      }
    });
  }
  return false;
 });

 $(document).on('click','#savePrivilege',function(){
    var user=$('#user').val();
    $('.privilegeMessage').hide();
    var records=[];
    $('.pageClass').each(function(){
      var pageId=$(this).attr('data-page');
      var viewStatus='no';
      var addStatus='no'
      var editStatus='no';
      var deleteStatus='no';
      if($('#view'+pageId).is(':checked')){
        viewStatus='yes';
      }
      if($('#add'+pageId).is(':checked')){
        addStatus='yes';
      }
      if($('#edit'+pageId).is(':checked')){
        editStatus='yes';
      }
      if($('#delete'+pageId).is(':checked')){
        deleteStatus='yes';
      }
      var record={page:pageId,view:viewStatus,add:addStatus,edit:editStatus,delete:deleteStatus};
      records.push(record);
    });
    console.log(records);
    var details=JSON.stringify(records);
    $.ajax({
      type: 'POST',
      url: '{{URL::action('TestController@saveuserprivilege')}}',
      data: {details:details,user:user},
      dataType: 'json',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success: function(data){
        console.log(data);
        $('.privilegeMessage').show();
        setTimeout(function(){
          $('.privilegeMessage').hide();
        },5000);
      },
      error: function(e){
        console.log(e.responseText);
      }
    });
    return false;
 });



  </script>
  @stop

