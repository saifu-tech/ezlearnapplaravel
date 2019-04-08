@extends('master')

@section('pageTitle')
Change Password
@stop

@section('breadcrumb')
  <li>password</li>
@stop

@section('maincontent')

    <!-- Start Panel -->
  <div class="col-md-9 col-lg-10">

          <div class="panel panel-default">
              <div class="panel-body">
              
                {{Form::open(['url'=>'admin/changepassword','class'=>'form-horizontal','id'=>'changePasswordForm'])}}

                      <div class="form-group">
                        {{Form::label('currentPassword','Current Password *',['class'=>'col-lg-2 col-md-3 control-label'])}}
                        <div class="col-sm-10 col-md-9 col-lg-8">
                          {{Form::password('currentPassword','',['placeholder'=>'Current Password','class'=>'form-control','id'=>'currentPassword'])}}
                          @if ($errors->has('currentPassword')) 
                          <div class="validation-error errorActive asterisk">
                             {{ $errors->first('currentPassword') }}
                         </div> 
                       @endif
                        </div>
                      </div>

                      <div class="form-group">
                        {{Form::label('newPassword','New Password *',['class'=>'col-lg-2 col-md-3 control-label'])}}
                        <div class="col-sm-10 col-md-9 col-lg-8">
                          {{Form::password('newPassword','',['placeholder'=>'New Password','class'=>'form-control','id'=>'newPassword'])}}
                          @if ($errors->has('newPassword')) 
                          <div class="validation-error errorActive asterisk">
                             {{ $errors->first('newPassword') }}
                         </div> 
                       @endif
                        </div>
                      </div>

                      <div class="form-group">
                        {{Form::label('newPassword_confirmation','Confirm Password *',['class'=>'col-lg-2 col-md-3 control-label'])}}
                        <div class="col-sm-10 col-md-9 col-lg-8">
                          {{Form::password('newPassword_confirmation','',['placeholder'=>'Confirm Password','class'=>'form-control','id'=>'newPassword_confirmation'])}}
                          @if ($errors->has('newPassword_confirmation')) 
                          <div class="validation-error errorActive asterisk">
                             {{ $errors->first('newPassword_confirmation') }}
                         </div> 
                       @endif
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          {{Form::submit('Change',['class'=>'btn btn-default','id'=>'changePassword'])}}
                        </div>
                      </div>

                {{Form::close()}}

                 @if(Session::has('success')) 
                  <div class="kode-alert kode-alert-icon alert3-light">
                      Password changed successfully.
                  </div>
                 @endif

                @if(Session::has('error')) 
                  @if(Session::has('error')) 
                  <div class="kode-alert kode-alert-icon alert6">
                     {{Session::get('error')}}
                  </div>
                 @endif
                @endif 
               
             </div>
          </div>



  </div>

@stop

@section('custom-footer-scripts')
  {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
  <script src="{{asset('js/datatables/datatables.min.js')}}"></script>
<script type="text/javascript">

</script>
@stop