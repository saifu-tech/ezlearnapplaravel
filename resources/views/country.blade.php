<?php 
use App\Country;
?>
@extends('master')

@section('pageTitle')
Country
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Masters</a></li>
  <li><a href="javascript:void(o)">Country</a></li>
@stop

@section('maincontent')




 <!-- START CONTAINER -->
<div class="container-default">

 <div aria-label="..." role="group" class="btn-group">
        <a href="javascript:void(0)" class="btn btn-light btn-sm addJob"><i class="fa fa-plus"></i>Add</a>
        <a class="btn btn-light btn-sm deleteButton" type="button"><i class="fa fa-trash"></i>Delete</a>
      </div>

<div class="row add_row"  style="display: none">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Add Country
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>  

            <div class="panel-body">
              {{Form::open(['url'=>'admin/masters/country/add/post'])}}
              @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif

                <div class="form-group">
                  {{Form::label('countryName','Country Name *',['class'=>'form-label'])}}
                  {{Form::text('countryName','',['class'=>'form-control'])}}
                  @if ($errors->add->has('countryName')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('countryName') }}
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
                Edit Country
                <ul class="panel-tools">
                  <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                  <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
                  <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                </ul>
              </div>

              <div class="panel-body">
                {{Form::open(['url'=>'admin/masters/country/edit/post'])}}
                @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif


                  <div class="form-group">
                    {{Form::label('countryName','Country Name *',['class'=>'form-label'])}}
                    {{Form::text('countryName','',['class'=>'form-control editCountryName'])}}
                    @if ($errors->edit->has('countryName')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->edit->first('countryName') }}
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
          List of Country
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
                      <td>{{$record->name}}</td>
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
       url: '{{URL::action('TestController@deletecountrypost')}}',
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
      url: '{{URL::action('TestController@getcountrypost')}}',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success:function(data){
        console.log(data);
        if(data.status=='success'){
          var name= data.name;
          $('.editCountryName').val(name);
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

   @if(Session::has('countryerror'))
    var value= "{{Session::get('countryerror')}}";
    $('.'+value).show('slow');
  @endif
  </script>
  @stop

