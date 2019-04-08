<?php
use App\Group;
use App\Options;
?>
@extends('master')

@section('pageTitle')
Users
@stop



@section('maincontent')

 <!-- START CONTAINER -->
<div class="container-default">

<div aria-label="..." role="group" class="btn-group">
  <a class="btn btn-light btn-sm deleteButton" type="button"><i class="fa fa-trash"></i>Delete</a>
</div>
  <div class="row manage_row" id="">
    <!-- Start Panel -->
    <div class="col-md-12">

      <div class="panel panel-default">
        <div class="panel-title">
          List of Users
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
                        <th>Full Name</th>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Status</th>
                        <th><i class="fa fa-trash"></i></th>
                    </tr>
                </thead>
             
                <tbody>
                  <?php $i=0; ?>
                  @foreach($records as $record)
                    <tr datarow={{$record->id}}>
                      <td>{{++$i}}</td>
                      <td>{{$record->full_name}}</td>
                      <td>{{$record->user_id}}</td>
                      <td>{{$record->email}}</td>
                      <td>{{ucfirst($record->type)}}</td>
                      <td>{{ucfirst($record->status)}}</td>
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
       url: '{{URL::action('TestController@deleteuserspost')}}',
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

  </script>
  @stop

