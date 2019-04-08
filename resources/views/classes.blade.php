<?php 
use App\Classname;
use App\Options;
use App\Privilege;
?>
@extends('master')

@section('pageTitle')
{{Options::getvalue('lable1')}}
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Masters</a></li>
  <li><a href="javascript:void(o)">{{Options::getvalue('lable1')}}</a></li>
@stop

@section('maincontent')




 <!-- START CONTAINER -->
<div class="container-default">

 <div aria-label="..." role="group" class="btn-group">
      @if(Privilege::getprivilegestatus(1,Auth::user()->id,'addStatus')=='yes')
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
          Add {{Options::getvalue('lable1')}}
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>  
        <?php
        $code=Classname::autogeneratecode();
        ?>

            <div class="panel-body">
              {{Form::open(['url'=>'admin/masters/classes/add/post'])}}
              @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif

                @if(Options::getvalue('countryBased')=='yes')
                    <div class="form-group">
                  {{Form::label('country','Country *',['class'=>'form-label'])}}
                  {{Form::select('country',$country,'',['class'=>'form-control','placeholder'=>'Select Country'])}}
                  @if ($errors->add->has('country')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('country') }}
                   </div> 
                 @endif
                </div>
                @endif

                <div class="form-group">
                  {{Form::label('classCode','Code *',['class'=>'form-label'])}}
                  {{Form::text('classCode',$code,['class'=>'form-control'])}}
                  @if ($errors->add->has('classCode')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('classCode') }}
                   </div> 
                 @endif
                </div>

                <div class="form-group">
                  {{Form::label('className','Name *',['class'=>'form-label'])}}
                  {{Form::text('className','',['class'=>'form-control'])}}
                  @if ($errors->add->has('className')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('className') }}
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
                Edit {{Options::getvalue('lable1')}}
                <ul class="panel-tools">
                  <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                  <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
                  <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                </ul>
              </div>

              <div class="panel-body">
                {{Form::open(['url'=>'admin/masters/classes/edit/post'])}}
                @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif


                  @if(Options::getvalue('countryBased')=='yes')
                    <div class="form-group">
                      {{Form::label('country','Country *',['class'=>'form-label'])}}
                      {{Form::select('country',$country,'',['class'=>'form-control editCountry','placeholder'=>'Select Country'])}}
                      @if ($errors->edit->has('country')) 
                        <div class="validation-error errorActive asterisk">
                           {{ $errors->edit->first('country') }}
                       </div> 
                     @endif
                    </div>
                  @endif

                  <div class="form-group">
                    {{Form::label('classCode','Code *',['class'=>'form-label'])}}
                    {{Form::text('classCode','',['class'=>'form-control editClassCode'])}}
                    @if ($errors->edit->has('classCode')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->edit->first('classCode') }}
                     </div> 
                   @endif
                  </div>

                  <div class="form-group">
                    {{Form::label('className','Name *',['class'=>'form-label'])}}
                    {{Form::text('className','',['class'=>'form-control editClassName'])}}
                    @if ($errors->edit->has('className')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->edit->first('className') }}
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
          List of {{Options::getvalue('lable1')}}
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
                        @if(Privilege::getprivilegestatus(1,Auth::user()->id,'editStatus')=='yes')
                        <th>Edit</th>
                        @endif
                        @if(Privilege::getprivilegestatus(1,Auth::user()->id,'deleteStatus')=='yes')
                        <th><i class="fa fa-trash"></i></th>
                        @endif
                    </tr>
                </thead>
             
                <tbody>
                  <?php $i=0; ?>
                  @foreach($records as $record)
                    <tr datarow={{$record->id}}>
                      <td>{{++$i}}</td>
                      <td>{{$record->code}}</td>
                      <td>{{$record->class_name}}</td>
                      @if(Privilege::getprivilegestatus(1,Auth::user()->id,'editStatus')=='yes')
                      <td><a href="javascript:void(0)" class="edit" editId="{{$record->id}}"><i class="fa fa-pencil-square-o"></i></a></td>
                      @endif
                      @if(Privilege::getprivilegestatus(1,Auth::user()->id,'deleteStatus')=='yes')
                      <td><div class="checkbox"><input type="checkbox" id="checkbox{{$i}}" class="selectRecords" data-record="{{$record->id}}"><label for="checkbox{{$i}}"></label></div></td>
                      @endif
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
       url: '{{URL::action('TestController@deleteclassespost')}}',
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
      url: '{{URL::action('TestController@getclassespost')}}',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success:function(data){
        console.log(data);
        if(data.status=='success'){
          var name= data.name;
          $('.editCountry').val(data.country);
          $('.editClassName').val(name);
          $('.editClassCode').val(data.code);
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

   @if(Session::has('classerror'))
    var value= "{{Session::get('classerror')}}";
    $('.'+value).show('slow');
  @endif
  </script>
  @stop

