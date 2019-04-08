<?php
use App\Options;
use App\Dailytasksstatus;
?>
@extends('master')

@section('pageTitle')
Settings
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Settings</a></li>
@stop

@section('maincontent')




 <!-- START CONTAINER -->
<div class="container-default">

<div class="row">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">
            <div class="panel-body">
              {{Form::open(['url'=>'admin/settings/add/post','class'=>'form-horizontal'])}}
              @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif
              @if(Session::has('failed')) 
              <div class="kode-alert kode-alert-icon alert6-light">
                <i class="fa fa-lock"></i>
                <a href="javascript:void(0)" class="closed">×</a>
                {{Session::get('failed')}}
              </div>
              @endif

              <div class="form-group">
                  {{Form::label('libraryFileSize','Library max. file size (MB) *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('libraryFileSize',Options::getvalue('libraryFileSize'),['class'=>'form-control'])}}
                  @if ($errors->add->has('libraryFileSize')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('libraryFileSize') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('lable1','Menu Label 1 *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('lable1',Options::getvalue('lable1'),['class'=>'form-control'])}}
                  @if ($errors->add->has('lable1')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('lable1') }}
                   </div> 
                 @endif
                 </div>
                </div>

                 <div class="form-group">
                  {{Form::label('lable2','Menu Label 2 *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('lable2',Options::getvalue('lable2'),['class'=>'form-control'])}}
                  @if ($errors->add->has('lable2')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('lable2') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('libraryFileSize','Library max. file size (MB) *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('libraryFileSize',Options::getvalue('libraryFileSize'),['class'=>'form-control'])}}
                  @if ($errors->add->has('libraryFileSize')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('libraryFileSize') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('countryBased','Country Based Classes',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  <?php
                  $countryBased=Options::getvalue('countryBased');
                  ?>
                  {{Form::checkbox('countryBased',$countryBased,($countryBased=='yes'))}}
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


    <div class="row" style="display:none;">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">
        <div class="panel-title">Daily task status</div>
            <div class="panel-body">
              {{Form::open(['url'=>'admin/settings/status/add/post','class'=>'form-horizontal'])}}
              @if(Session::has('statussuccess')) {!! HTML::display_success('statussuccess') !!} @endif
              @if(Session::has('failed')) 
              <div class="kode-alert kode-alert-icon alert6-light">
                <i class="fa fa-lock"></i>
                <a href="javascript:void(0)" class="closed">×</a>
                {{Session::get('failed')}}
              </div>
              @endif
              <?php
              $status=Dailytasksstatus::all();
              $i=0;
              ?>
              @if(count($status)>0)
                @foreach($status as $sta)
                <div class="form-group cloneStatus">
                  @if($i==0)
                    {{Form::label('status','Default Status *',['class'=>'col-sm-2 control-label'])}}
                  @else
                  {{Form::label('','',['class'=>'col-sm-2 control-label'])}}
                  @endif
                    <div class="col-sm-8">
                    {{Form::text('status[]',$sta->name,['class'=>'form-control taskStatus'])}}
                   </div>
                   <a href="javascript:void(0)" class="addOption"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                   <a href="javascript:void(0)" class="removeOption" style="display:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>
                <?php $i++; ?>
                @endforeach
              @else
                <div class="form-group cloneStatus">
                  {{Form::label('status','Default Status *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('status[]','',['class'=>'form-control taskStatus'])}}
                  </div>
                   <a href="javascript:void(0)" class="addOption"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                   <a href="javascript:void(0)" class="removeOption" style="display:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>
              @endif

              <div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;"></div>
              <div class="form-group">
                {{Form::label('',' ',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                {{Form::submit('Save',['class'=>'btn btn-default saveStatus'])}}
                </div>
              </div>

              {{Form::close()}}
            </div>

      </div>
    </div>
    </div>

</div>
<!-- END CONTAINER -->
  @stop

  @section('custom-footer-scripts')
  {{HTML::script('js/datatables/datatables.min.js')}}
  {{HTML::script('js/bootbox/bootbox.min.js')}}
  <script>
  $(document).ready(function() {
      $('#example0').DataTable();

      var length=$('.cloneStatus').length;
      if(length>1){
        $('.removeOption:not(:first)').show();
        $('.addOption').hide();
        if(length<3){
          $('.addOption:last').show();
        }
      }

  });

  $(document).on('click','.saveStatus',function(){
    var error='no';
    $('.taskStatus').each(function(){
        var value=$(this).val();
        if(value==''){
          $('.errorMessage').show().html('Please enter status name in all fields.');
          error='yes';
          return false;
        }
    });
    if(error=='yes'){
      return false;
    }
    return true;
  });

  $(document).on('click','.addOption',function(){
    $( ".cloneStatus:last" ).clone().insertAfter('.cloneStatus:last');
    $('.addOption').hide();
    $('.removeOption').hide();
    var length=$('.cloneStatus').length;
    if(length<3){
      $('.addOption:last').show();
    }
    $('.removeOption:not(:first)').show();
    $('.cloneStatus:last label').text('');
    $('.cloneStatus:last :input').removeAttr('readonly').val('');
    return false;
  });


  $(document).on('click','.removeOption',function(){
    $(this).closest('.cloneStatus').remove();
    $('.addOption').hide();
    $('.addOption:last').show();
    $('.removeOption').hide();
    var length=$('.cloneStatus').length;
    if(length>0){
      $('.removeOption:not(:first)').show();
    }
    // if(length==1){
    //   $('.removeOption:first').hide();
    // }
    return false;
  });

  </script>
  @stop

