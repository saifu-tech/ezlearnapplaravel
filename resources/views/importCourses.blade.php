@extends('master')

@section('pageTitle')
Import Courses
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Import</a></li>
  <li><a href="javascript:void(o)">Courses</a></li>
@stop

@section('maincontent')




 <!-- START CONTAINER -->
<div class="container-default">


<div class="row">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Import
        </div>

            <div class="panel-body">

            @if(Session::has('failed')) 

            <div class="kode-alert kode-alert-icon alert6-light">
            <i class="fa fa-lock"></i>
            <a href="#" class="closed">×</a>
            <span> {!! Session::get('failed')!!}</span>
          </div>


            @endif

              {{Form::open(['url'=>'admin/import/courses/add/post','files'=>'true'])}}
              @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif
                <div class="form-group">
                  {{Form::label('importFile','Import File *',['class'=>'form-label'])}}
                  {{Form::file('importFile','',['class'=>'form-control'])}}
                  @if ($errors->has('importFile')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->first('importFile') }}
                   </div> 
                 @endif
                </div>
                {{Form::submit('Save',['class'=>'btn btn-default'])}}
              {{Form::close()}}
            </div>

      </div>
    </div>
    </div>

</div>
<!-- END CONTAINER -->
  @stop

