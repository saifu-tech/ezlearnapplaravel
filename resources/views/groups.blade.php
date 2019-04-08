<?php
use App\Group;
use App\Options;
?>
@extends('master')

@section('pageTitle')
Groups
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Groups</a></li>
@stop

@section('maincontent')

 <!-- START CONTAINER -->
<div class="container-default">

 <div aria-label="..." role="group" class="btn-group">
      @if(Auth::user()->type=='staff')
        <a href="javascript:void(0)" class="btn btn-light btn-sm addJob"><i class="fa fa-plus"></i>Add</a>
      @endif
        <a class="btn btn-light btn-sm deleteButton" type="button"><i class="fa fa-trash"></i>Delete</a>
      </div>

<div class="row add_row"  style="display: none">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Add Group
          <ul class="panel-tools">
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>

            <div class="panel-body">
              {{Form::open(['url'=>'admin/groups/add/post','class'=>'form-horizontal'])}}
              @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif

              <div class="form-group">
                  {{Form::label('country','Country',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('country',$country,'',['class'=>'form-control','placeholder'=>'All Countries'])}}
                  @if ($errors->add->has('country')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('country') }}
                   </div> 
                 @endif
                 </div>
                </div>

              <div class="form-group">
                  {{Form::label('groupCode','Group Code *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('groupCode',Group::autogeneratecode(),['class'=>'form-control'])}}
                  @if ($errors->add->has('groupCode')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('groupCode') }}
                   </div> 
                 @endif
                 </div>
                </div>


                <div class="form-group">
                  {{Form::label('groupName','Group Name *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('groupName','',['class'=>'form-control'])}}
                  @if ($errors->add->has('groupName')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('groupName') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('students','Students',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('students[]',$students,'',['class'=>'form-control','placeholder'=>'Select Students','multiple','id'=>'students'])}}
                  @if ($errors->add->has('students')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('students') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('shortDescription','Short Description',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('shortDescription','',['class'=>'form-control'])}}
                  </div>
                </div>

                <div class="form-group">
                  {{Form::label('longDescription','Long Description',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::textarea('longDescription','',['class'=>'form-control','rows'=>5])}}
                  </div>
                </div>

                <div class="form-group">
                  {{Form::label('','',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::checkbox('acceptance_mandatory','no',false)}} &nbsp; Student acceptance not required
                  </div>
                </div>

                <div class="form-group">
                {{Form::label('',' ',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                {{Form::submit('Save',['class'=>'btn btn-default'])}}
                </div>
                </div>
              {{Form::close()}}
            </div>

      </div>
    </div>
    </div>

      <div class="row edit_row" style="display: none">
        <div class="col-md-12 col-lg-12">
            <div class="panel panel-default">

              <div class="panel-title">
                Edit Group
                <ul class="panel-tools">
                  <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                </ul>
              </div>

              <div class="panel-body">
                {{Form::open(['url'=>'admin/groups/edit/post','class'=>'form-horizontal', 'method'=>'POST'])}}
                @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif


                <div class="form-group">
                  {{Form::label('country','Country',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('country',$country,'',['class'=>'form-control editCountry','placeholder'=>'All Countries'])}}
                  @if ($errors->edit->has('country')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('country') }}
                   </div> 
                 @endif
                 </div>
                </div>


                <div class="form-group">
                  {{Form::label('groupCode','Group Code *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('groupCode','',['class'=>'form-control editGroupCode'])}}
                  @if ($errors->edit->has('groupCode')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('groupCode') }}
                   </div> 
                 @endif
                 </div>
                </div>

                  <div class="form-group">
                  {{Form::label('groupName','Group Name *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('groupName','',['class'=>'form-control editGroupName'])}}
                  @if ($errors->edit->has('groupName')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('groupName') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('students','Students',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('students[]',$students,'',['class'=>'form-control editStudents','placeholder'=>'Select Students','multiple','id'=>'students'])}}
                  @if ($errors->add->has('students')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('students') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('shortDescription','Short Description',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('shortDescription','',['class'=>'form-control editShortDescription'])}}
                  </div>
                </div>

                <div class="form-group">
                  {{Form::label('longDescription','Long Description',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::textarea('longDescription','',['class'=>'form-control editLongDescription','rows'=>5])}}
                  </div>
                </div>

                <div class="form-group">
                  {{Form::label('','',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::checkbox('acceptance_mandatory','no','',['class'=>'editAcceptance'])}} &nbsp; Student acceptance not required
                  </div>
                </div>

                <div class="form-group">
                {{Form::label('',' ',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                  {{Form::hidden('editId','',['class'=>'editRowId'])}}
                  {{Form::submit('Update',['class'=>'btn btn-default'])}}
                </div>
                </div>
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
          List of Group
        </div>
        <div class="panel-body table-responsive">

          <div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;">
            <i class="fa fa-lock"></i>
            <a href="#" class="closed">×</a>
            <span></span>
          </div>

            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Edit</th>
                        <th><i class="fa fa-trash"></i></th>
                    </tr>
                </thead>
             
                <tbody>
                  <?php $i=0; ?>
                  @foreach($records as $record)
                    <tr datarow={{$record->id}}>
                      <td>{{++$i}}</td>
                      <td>{{$record->code}}</td>
                      <td>{{$record->group_name}}</td>
                      <td><a href="javascript:void(0)" class="edit" editId="{{$record->id}}"><i class="fa fa-pencil-square-o"></i></a></td>
                      <td><div class="checkbox"><input type="checkbox" id="checkbox{{$i}}" class="selectRecords" data-record="{{$record->id}}"><label for="checkbox{{$i}}"></label></div></td>
                    </tr>
                  @endforeach
                </tbody>
            </table>


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
  <script>
  $(document).ready(function() {
      $('#example0').DataTable();
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
       url: '{{URL::action('TestController@deletegroupspost')}}',
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
      url: '{{URL::action('TestController@getgroupspost')}}',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success:function(data){
        console.log(data);
        if(data.status=='success'){
          $('.edit_row #students').empty();
          var options='<option value="">Select Students</option>';
            $.each(data.countryStudents,function(key,ele){
              options+='<option value="'+key+'">'+ele+'</option>';
            });
            $('.edit_row').find('#students').append(options);
          $('.editCountry').val(data.country);
          $('.editGroupName').val(data.name);
          $('.editGroupCode').val(data.code);
          $('.editShortDescription').val(data.short);
          $('.editLongDescription').val(data.long);
          $('.editStudents').val(data.students);
          $('.editCountry').val(data.country);
          if(data.acceptance=='yes'){
            $('.editAcceptance').prop('checked',false);
          }else{
            $('.editAcceptance').prop('checked',true);
          }
          $('.editRowId').val(editId);
          $('.edit_row').show('slow');
        }
      },
      error:function(e){
        console.log(e.responseText);
      }
    });
  });
    $(document).on('change','.add_row #country',function(){
      getcountrystudents('add_row');
  });

    $(document).on('change','.edit_row #country',function(){
      getcountrystudents('edit_row');
  });

    function getcountrystudents(panel){
      var parent=$('.'+panel);
      var country=parent.find('#country').val();
      parent.find('#students').empty();
      if(country!=''){
        $.ajax({
          type:'POST',
          data: {country:country},
          dataType:'JSON',
          url: '{{URL::action('TestController@getcountrystudents')}}',
          headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
          success:function(data){
            console.log(data);
            var options='<option value="">Select Students</option>';
            $.each(data.students,function(key,ele){
              options+='<option value="'+key+'">'+ele+'</option>';
            });
            parent.find('#students').append(options);
          },
          error:function(e){
            console.log(e.responseText);
          }
        });
      }
    }

  $(document).on('click','.addJob',function(){
      $('.edit_row').hide('slow');
      $('.successMessage').hide('slow');
      $('.errorMessage').hide('slow');
      // $('.add_row input[type="text"]').val('');
      $('.add_row').show('slow');
  });

   @if(Session::has('groupserror'))
    var value= "{{Session::get('groupserror')}}";
    $('.'+value).show('slow');
  @endif
  </script>
  @stop

