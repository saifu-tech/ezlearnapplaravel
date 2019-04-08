<?php
use App\Group;
use App\Students;
use App\Dailytasks;
use App\Options;
?>
@extends('master')

@section('pageTitle')
Daily Tasks
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Daily Tasks</a></li>
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
          Add Daily Task
          <ul class="panel-tools">
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>

            <div class="panel-body">
              {{Form::open(['url'=>'admin/daily/tasks/add/post','class'=>'form-horizontal'])}}
              @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif


              <div class="form-group">
                  {{Form::label('taskTemplate','Select Template',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('taskTemplate',$templates,'',['class'=>'form-control','placeholder'=>'Select Template'])}}
                  @if ($errors->add->has('taskTemplate')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('taskTemplate') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('taskType','Task Type *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('taskType',['daily'=>'Daily Task','weekly'=>'Weekly Task','monthly'=>'Monthly Task'],'daily',['class'=>'form-control'])}}
                  @if ($errors->add->has('taskType')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('taskType') }}
                   </div> 
                 @endif
                 </div>
                </div>

              <div class="form-group">
                  {{Form::label('groupName','Group Name*',['class'=>'col-sm-2 control-label'])}}
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
                  {{Form::label('taskName','Task Name *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::text('taskName','',['class'=>'form-control','min'=>7])}}
                    @if ($errors->add->has('taskName')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->add->first('taskName') }}
                     </div> 
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  {{Form::label('startDate','Start Date *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::text('startDate','',['class'=>'form-control startDate'])}}
                    @if ($errors->add->has('startDate')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->add->first('startDate') }}
                     </div> 
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  {{Form::label('endDate','End Date *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::text('endDate','',['class'=>'form-control endDate'])}}
                    @if ($errors->add->has('endDate')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->add->first('endDate') }}
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

                <div class="form-group cloneTask">
                  {{Form::label('Options','Options *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('options[]','',['class'=>'form-control', 'autocomplete'=>'off'])}}
                 </div>
                 <a href="javascript:void(0)" class="addOption"  data-div='add_row'><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="javascript:void(0)" class="removeOption" data-div='add_row' style="display:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>


                <div class="form-group cloneStatus">
                  {{Form::label('status','Status *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-6">
                  {{Form::text('status[]','',['class'=>'form-control taskStatus', 'autocomplete'=>'off'])}}
                 </div>
                 <div class="col-sm-2">
                  {{Form::select('color[]',[''=>'Color','#00ff00'=>'Green','#ffff00'=>'Yellow','#ff0000'=>'Red','#5acbff'=>'Blue', '#636161'=>'Gray'],'',['class'=>'form-control statusColor'])}}
                 </div>
                 <a href="javascript:void(0)" class="addStatus"  data-div='add_row'><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="javascript:void(0)" class="removeStatus" data-div='add_row' style="display:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>

                <div class="form-group dailyTaskDiv">
                  {{Form::label('dailyDay','Select Day *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::checkbox('dailyDay[]',1,true,['class'=>'dailyDay'])}} Monday&nbsp;&nbsp;
                    {{Form::checkbox('dailyDay[]',2,true,['class'=>'dailyDay'])}} Tuesday&nbsp;&nbsp;
                    {{Form::checkbox('dailyDay[]',3,true,['class'=>'dailyDay'])}} Wednesday&nbsp;&nbsp;
                    {{Form::checkbox('dailyDay[]',4,true,['class'=>'dailyDay'])}} Thursday&nbsp;&nbsp;
                    {{Form::checkbox('dailyDay[]',5,true,['class'=>'dailyDay'])}} Friday&nbsp;&nbsp;
                    {{Form::checkbox('dailyDay[]',6,true,['class'=>'dailyDay'])}} Saturday&nbsp;&nbsp;
                    {{Form::checkbox('dailyDay[]',7,true,['class'=>'dailyDay'])}} Sunday&nbsp;&nbsp;
                  </div>
                  @if ($errors->add->has('dailyDay')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('dailyDay') }}
                   </div> 
                 @endif
                </div>

                <div class="form-group weeklyTaskDiv" style="display:none;">
                  {{Form::label('weeklyDay','Select Day *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::select('weeklyDay',[1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday'],'',['class'=>'weeklyDay','placeholder'=>'Select Day'])}}
                  </div>
                  @if ($errors->add->has('weeklyDay')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('weeklyDay') }}
                   </div> 
                 @endif
                </div>
                <?php
                $day=[];
                $i=1;
                while($i<=31){
                  $day[$i]=$i;
                  $i++;
                }
                ?>

                <div class="form-group monthlyTaskDiv" style="display:none;">
                  {{Form::label('monthlyDay','Select Day *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::select('monthlyDay',$day,'',['class'=>'monthlyDay','placeholder'=>'Select Day'])}}
                  </div>
                  @if ($errors->add->has('monthlyDay')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->add->first('monthlyDay') }}
                   </div> 
                 @endif
                </div>

                <div class="form-group templateDiv">
                  {{Form::label('','',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::checkbox('template','yes',false,['class'=>''])}}&nbsp; Make this template
                 </div>
                </div>

                <div class="alert alert-danger addErrorMessage" style="display:none;"></div>

                <div class="form-group">
                {{Form::label('',' ',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                {{Form::submit('Save',['class'=>'btn btn-default saveTask'])}}
                {{Form::reset('Cancel',['class'=>'btn btn-info'])}}
                </div>
                </div>
              {{Form::close()}}
            </div>
      </div>
    </div>
    </div>

    
      @if(Session::has('editsuccess')) {!! HTML::display_success('editsuccess') !!} @endif
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
                {{Form::open(['url'=>'admin/daily/tasks/edit/post','class'=>'form-horizontal'])}}
                
                <div class="form-group">
                  {{Form::label('taskType','Task Type *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('taskType',['daily'=>'Daily Task','weekly'=>'Weekly Task','monthly'=>'Monthly Task'],'daily',['class'=>'form-control'])}}
                  @if ($errors->edit->has('taskType')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('taskType') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('groupName','Group Name*',['class'=>'col-sm-2 control-label'])}}
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
                  {{Form::label('taskName','Task Name *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::text('taskName','',['class'=>'form-control editTaskName'])}}
                    @if ($errors->edit->has('taskName')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->edit->first('taskName') }}
                     </div> 
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  {{Form::label('startDate','Start Date *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::text('startDate','',['class'=>'form-control editStartDate'])}}
                    @if ($errors->edit->has('startDate')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->edit->first('startDate') }}
                     </div> 
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  {{Form::label('endDate','End Date *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::text('endDate','',['class'=>'form-control editEndDate'])}}
                    @if ($errors->edit->has('endDate')) 
                      <div class="validation-error errorActive asterisk">
                         {{ $errors->edit->first('endDate') }}
                     </div> 
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  {{Form::label('students','Students',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('students[]',$students,'',['class'=>'form-control editStudents','placeholder'=>'Select Students','multiple','id'=>'students'])}}
                  @if ($errors->edit->has('students')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('students') }}
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="optionsDiv">
                  <div class="form-group cloneTask">
                  {{Form::label('Options','Options *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::text('options[]','',['class'=>'form-control'])}}
                 </div>
                 <a href="javascript:void(0)" class="addOption" data-div='edit_row'><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="javascript:void(0)" class="removeOption" data-div='edit_row' style="display:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>
                </div>

                <div class="statusDiv">
                <div class="form-group cloneStatus">
                  {{Form::label('status','Status *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-6">
                  {{Form::text('status[]','',['class'=>'form-control taskStatus'])}}
                 </div>
                 <div class="col-sm-2">
                  {{Form::select('color[]',[''=>'Color','#00ff00'=>'Green','#ffff00'=>'Yellow','#ff0000'=>'Red','#5acbff'=>'Blue', '#636161'=>'Gray'],'',['class'=>'form-control statusColor'])}}
                 </div>
                 <a href="javascript:void(0)" class="addStatus"  data-div='edit_row'><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                 <a href="javascript:void(0)" class="removeStatus" data-div='edit_row' style="display:none;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>
                </div>

                <div class="form-group dailyTaskDiv" style="display:none;">
                  {{Form::label('dailyDay','Select Day *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::checkbox('dailyDay[]',1,true,['class'=>'dailyDay'])}} &nbsp;Monday&nbsp;
                    {{Form::checkbox('dailyDay[]',2,true,['class'=>'dailyDay'])}} &nbsp;Tuesday&nbsp;
                    {{Form::checkbox('dailyDay[]',3,true,['class'=>'dailyDay'])}} &nbsp;Wednesday&nbsp;
                    {{Form::checkbox('dailyDay[]',4,true,['class'=>'dailyDay'])}} &nbsp;Thursday&nbsp;
                    {{Form::checkbox('dailyDay[]',5,true,['class'=>'dailyDay'])}} &nbsp;Friday&nbsp;
                    {{Form::checkbox('dailyDay[]',6,true,['class'=>'dailyDay'])}} &nbsp;Saturday&nbsp;
                    {{Form::checkbox('dailyDay[]',7,true,['class'=>'dailyDay'])}} &nbsp;Sunday&nbsp;
                  </div>
                  @if ($errors->edit->has('dailyDay')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('dailyDay') }}
                   </div> 
                 @endif
                </div>

                <div class="form-group weeklyTaskDiv" style="display:none;">
                  {{Form::label('weeklyDay','Select Day *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::select('weeklyDay',[1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday',6=>'Saturday',7=>'Sunday'],'',['class'=>'weeklyDay','placeholder'=>'Select Day'])}}
                  </div>
                  @if ($errors->edit->has('weeklyDay')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('weeklyDay') }}
                   </div> 
                 @endif
                </div>
                <?php
                $day=[];
                $i=1;
                while($i<=31){
                  $day[$i]=$i;
                  $i++;
                }
                ?>

                <div class="form-group monthlyTaskDiv" style="display:none;">
                  {{Form::label('monthlyDay','Select Day *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                    {{Form::select('monthlyDay',$day,'',['class'=>'monthlyDay','placeholder'=>'Select Day'])}}
                  </div>
                  @if ($errors->edit->has('monthlyDay')) 
                    <div class="validation-error errorActive asterisk">
                       {{ $errors->edit->first('monthlyDay') }}
                   </div> 
                 @endif
                </div>


                {{Form::hidden('editId','',['class'=>'editId'])}}
                <div class="alert alert-danger editErrorMessage" style="display:none;"></div>

                <div class="form-group">
                {{Form::label('',' ',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                {{Form::submit('Save',['class'=>'btn btn-default updateTask'])}}
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
          List of Tasks
        </div>
        <div class="panel-body table-responsive">


            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Group Name</th>
                        <th>Task</th>
                        <th>Students</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th><i class="fa fa-trash"></i></th> 
                    </tr>
                </thead>
             
                <tbody>
                  <?php $i=0;  $dateFormat=Options::getvalue('dateFormat');?>
                  @foreach($records as $record)
                    <?php
                    $groupRecords=Dailytasks::where('serialNo',$record->serialNo)->get();
                    $students=[];
                    $options=[];
                    foreach($groupRecords as $groupRec){
                        $name=Students::getstudentname($groupRec->students);
                        if($name != ''){
                          array_push($students,$name);
                        }
                    }
                    if(count($students)>0){
                      $students=implode(', ',$students);
                    }else{
                      $students='';
                    }
                    ?>
                    <tr class='taskrow{{$record->serialNo}}'>
                      <td>{{++$i}}</td>
                      <td>{{$record->groupName}}</td>
                      <td>{{$record->taskName}}</td>
                      <td>{{$students}}</td>
                      <td>{{date($dateFormat,strtotime($record->startDate))}}</td>
                      <td>{{date($dateFormat,strtotime($record->endDate))}}</td>
                      <td>{{ucfirst($record->status)}}</td>
                      <td><a href="javascript:void(0)" class="edit" editId="{{$record->serialNo}}"><i class="fa fa-pencil-square-o"></i></a></td>
                      <!-- @if($record->status=='active')
                        <td><a href="javascript:void(0)" class="closeTask" data-id="{{$record->serialNo}}">Close</a></td>
                        
                      @else
                        <td>Closed on {{date($dateFormat,strtotime($record->endDate))}}</td>
                        <td>&nbsp;&nbsp;</td>
                      @endif -->
                      <td><div class="checkbox"><input type="checkbox" id="checkbox{{$i}}" class="selectRecords" data-record="{{$record->serialNo}}"><label for="checkbox{{$i}}"></label></div></td>
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

<!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Close Task</h4>
        </div>
        <div class="modal-body">
        {{Form::open()}}
        <div class="form-group">
          {{Form::label('endDate','End Date',['class'=>'col-sm-2 control-label'])}}
          <div class="col-sm-8">
          {{Form::text('endDate','',['class'=>'form-control endDate'])}}
          </div>
        </div>
        <div class="clearfix"></div>
        {{Form::close()}}
        {{Form::hidden('closeSerialNo','',['class'=>'closeSerialNo'])}}
        </div>
        <div class="alert alert-success successMessage" style="display:none;">Task Successfully Closed</div>
        <div class="alert alert-danger errorMessage" style="display:none;">Please select end date</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary closeTaskSubmit">Submit</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!--END Modal -->


</div>
<!-- END CONTAINER -->
  @stop

  @section('custom-footer-scripts')
  {{HTML::script('js/datatables/datatables.min.js')}}
  {{HTML::script('js/bootbox/bootbox.min.js')}}
  {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
  <script>
  $(document).ready(function() {
      $('#example0').DataTable();
      var template=$('#taskTemplate').val();
      if(template!=''){
        $('.templateDiv').hide();
      }else{
        $('.templateDiv').show();
        $('#template').prop('checked',false);
      }
  });

  $(document).on('change','#taskType',function(){
    $('.weeklyTaskDiv').hide();
    $('.monthlyTaskDiv').hide();
    $('.dailyTaskDiv').hide();
    var type=$(this).val();
    if($(this).closest('.row').hasClass('add_row')){
        var parent=$('.add_row');
    }else{
        var parent=$('.edit_row');
    }
    if(type=='weekly'){
      parent.find('.weeklyTaskDiv').show();
    }else if(type=='monthly'){
      parent.find('.monthlyTaskDiv').show();
    }else if(type=='daily'){
      parent.find('.dailyTaskDiv').show();
    }
    return false;
  }); 

  $(document).on('change','#taskTemplate',function(){
    $('.errorMessage').hide();
    $('.successMessage').hide();
    var serialNo=$('#taskTemplate').val();
    var parent=$('.add_row');
    parent.find('#groupName').val('');
    parent.find('#taskName').val('');
    parent.find('#startDate').val('');
    parent.find('#students').val('');
    //Options
    parent.find('.cloneTask:not(:first)').remove();
    parent.find('.cloneTask:first').find('input').val('');
    parent.find('.removeOption:first').hide();
    parent.find('.addOption:last').show();

    //Status
     parent.find('.cloneStatus:not(:first)').remove();
     parent.find('.cloneStatus:first').find('input').val('');
     parent.find('.addStatus:last').show();
     parent.find('.removeStatus:first').hide();
    if(serialNo!=''){
        $.ajax({
          type: 'POST',
           url: '{{URL::action('TestController@gettemplatedetails')}}',
           data: {serialNo:serialNo},
           dataType: 'json',
           headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
           success: function(data){
            console.log(data);
            $('.templateDiv').hide();
            parent.find('#groupName').val(data.groupName);
            parent.find('#taskName').val(data.taskName);
            parent.find('#startDate').val(data.startDate);
            parent.find('#endDate').val(data.endDate);
            parent.find('#students').val(data.students);
            parent.find('#taskType').val(data.type);

            var options=data.options;
            var status=data.status;
            var i=0;
            $.each(options,function(key,ele){
              if(i==0){
                i++;
                parent.find('.cloneTask:first :input').val(ele.optionName);
              }else{
                parent.find(".cloneTask:last").clone().insertAfter('.add_row .cloneTask:last');
                parent.find('.addOption').hide();
                parent.find('.addOption:last').show();
                parent.find('.removeOption').show();
                parent.find('.cloneTask:last label').text('');
                parent.find('.cloneTask:last :input').removeAttr('readonly').val(ele.optionName);
              }
            });

            var i=0;
            $.each(status,function(key,ele){
              if(i==0){
                i++;
                parent.find('.cloneStatus:first :input').val(ele.name);
                parent.find('.cloneStatus:first .statusColor').val(ele.color);
              }else{
                parent.find( ".cloneStatus:last" ).clone().insertAfter('.add_row .cloneStatus:last');
                parent.find('.addStatus').hide();
                parent.find('.addStatus:last').show();
                parent.find('.removeStatus').show();
                parent.find('.cloneStatus:last label').text('');
                parent.find('.cloneStatus:last :input').removeAttr('readonly').val(ele.name);
                parent.find('.cloneStatus:last .statusColor').val(ele.color);
              }
            });

            var type=data.type;
            parent.find('.dailyTaskDiv').hide();
            parent.find('.monthlyTaskDiv').hide();
            parent.find('.weeklyTaskDiv').hide();
            var day=data.day;
            if(type=='daily'){
              parent.find('.dailyTaskDiv').show();
              parent.find('.dailyDay').each(function(){
                var val=$(this).val();
                if(jQuery.inArray(val,data.day) !== -1){
                  $(this).prop('checked',true);
                }else{
                  $(this).prop('checked',false);
                }
              });
            }else if(type=='weekly'){
              parent.find('.weeklyDay').val(data.day);
              parent.find('.weeklyTaskDiv').show();
            }else if(type=='monthly'){
              parent.find('.monthlyDay').val(data.day);
              parent.find('.monthlyTaskDiv').show();
            }
            return false;
          },
          error: function(e){
            console.log(e.responseText);
          }
        });
    }else{
      $('.templateDiv').show();
      $('#template').prop('checked',false);
    }
    return false;
  });

  $('.endDate,.startDate,.editStartDate,.editEndDate').daterangepicker({
    singleDatePicker: true, 
    format: "DD-MM-YYYY"
  });


  $(document).on('click','.saveTask',function(){
    $('.addErrorMessage').hide();
    var parent=$('.add_row');
    var groupName=parent.find('#groupName').val();
    var taskName=parent.find('#taskName').val();
    var startDate=parent.find('#startDate').val();
    var endDate=parent.find('#endDate').val();
    var students=parent.find('#students').val();
    var type=parent.find('#taskType').val();
    if(groupName==''){
      $('.addErrorMessage').show().html('Please enter group name.');
      return false;
    }

    if(taskName==''){
      $('.addErrorMessage').show().html('Please enter task name.');
      return false;
    }

    if(startDate==''){
      $('.addErrorMessage').show().html('Please enter start date.');
      return false;
    }

    if(endDate==''){
      $('.addErrorMessage').show().html('Please enter end date.');
      return false;
    }

    if(students==''){
      $('.addErrorMessage').show().html('Please select students.');
      return false;
    }

    var error='no';
    parent.find('.cloneTask').each(function(){
      var val=$(this).find('input').val();
      if(val==''){
          $('.addErrorMessage').show().html('Please enter option name in all fields.');
          error='yes';
          return false;
      }
    });

    if(error=='yes'){
      return false;
    }
    var colors=[];
    parent.find('.cloneStatus').each(function(){
      var val=$(this).find('.taskStatus').val();
      var color=$(this).find('.statusColor').val();
      if(val==''){
          $('.addErrorMessage').show().html('Please enter status name in all fields.');
          error='yes';
          return false;
      }
      if(jQuery.inArray(color,colors) !== -1){
          $('.addErrorMessage').show().html('Please select different color name in all fields.');
          error='yes';
          return false;
      }
      if(color==''){
          $('.addErrorMessage').show().html('Please select color name in all fields.');
          error='yes';
          return false;
      }else{
        colors.push(color);
      }
    });

    if(error=='yes'){
      return false;
    }

    if(type=='daily'){
      var length=parent.find('.dailyDay:checked').length;
      if(length==0){
        $('.addErrorMessage').show().html('Please select atleast one day.');
        return false;
      }
    }else if(type=='weekly'){
      var day=parent.find('.weeklyDay').val();
      if(day==''){
        $('.addErrorMessage').show().html('Please select day.');
        return false;
      }
    }else if(type=='monthly'){
      var day=parent.find('.monthlyDay').val();
      if(day==''){
        $('.addErrorMessage').show().html('Please select day.');
        return false;
      }
    }
    return true;
  });


  $(document).on('click','.updateTask',function(){
    $('.editErrorMessage').hide();
    var parent=$('.edit_row');
    var groupName=parent.find('#groupName').val();
    var taskName=parent.find('#taskName').val();
    var startDate=parent.find('#startDate').val();
    var endDate=parent.find('#endDate').val();
    var students=parent.find('#students').val();
    var type=parent.find('#taskType').val();
    if(groupName==''){
      $('.editErrorMessage').show().html('Please enter group name.');
      return false;
    }

    if(taskName==''){
      $('.editErrorMessage').show().html('Please enter task name.');
      return false;
    }

    if(startDate==''){
      $('.editErrorMessage').show().html('Please enter start date.');
      return false;
    }

    if(endDate==''){
      $('.editErrorMessage').show().html('Please enter end date.');
      return false;
    }

    if(students==''){
      $('.editErrorMessage').show().html('Please select students.');
      return false;
    }
    var error='no';
    parent.find('.cloneTask').each(function(){
      var val=$(this).find('input').val();
      if(val==''){
          $('.editErrorMessage').show().html('Please enter option name in all fields.');
          error='yes';
          return false;
      }
    });
    if(error=='yes'){
      return false;
    }

    var colors=[];
    parent.find('.cloneStatus').each(function(){
      var val=$(this).find('.taskStatus').val();
      var color=$(this).find('.statusColor').val();

      if(val==''){
          $('.editErrorMessage').show().html('Please enter status name in all fields.');
          error='yes';
          return false;
      }
      if(jQuery.inArray(color,colors) !== -1){
          $('.editErrorMessage').show().html('Please select different color name in all fields.');
          error='yes';
          return false;
      }
      if(color==''){
          $('.editErrorMessage').show().html('Please select color name in all fields.');
          error='yes';
          return false;
      }else{
        colors.push(color);
      }
    });

    if(error=='yes'){
      return false;
    }
    if(type=='daily'){
      var length=parent.find('.dailyDay:checked').length;
      if(length==0){
        $('.editErrorMessage').show().html('Please select atleast one day.');
        return false;
      }
    }else if(type=='weekly'){
      var day=parent.find('.weeklyDay').val();
      if(day==''){
        $('.editErrorMessage').show().html('Please select day.');
        return false;
      }
    }else if(type=='monthly'){
      var day=parent.find('.monthlyDay').val();
      if(day==''){
        $('.editErrorMessage').show().html('Please select day.');
        return false;
      }
    }
    return true;
  });

  $(document).on('click','.closeTask',function(){
    $('.errorMessage,.successMessage').hide();
    var serialNo=$(this).attr('data-id');
    $('.closeSerialNo').val(serialNo);
    $('#myModal').modal('show');
    return false;
  });

  $(document).on('click','.closeTaskSubmit',function(){
    $('.errorMessage,.successMessage').hide();
     var serialNo=$('.closeSerialNo').val();
     var endDate=$('.endDate').val();
     if(endDate==''){
      $('.errorMessage').show();
      setTimeout(function(){
        $('.errorMessage').hide();
      },5000);
      return false;
     }
     $.ajax({
        type: 'POST',
       url: '{{URL::action('TestController@closetaskpost')}}',
       data: {serialNo:serialNo,endDate:endDate},
       dataType: 'json',
       headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
       success: function(data){
          console.log(data);
          $('.errorMessage').hide();
          $('.successMessage').show();
          setTimeout(function(){
            $('.successMessage').hide();
            $('#myModal').modal('hide');
          },5000);
          $('.taskrow'+serialNo).find('.closeTask').html('Closed on '+endDate).removeClass('closeTask');
          $('.taskrow'+serialNo).find('.edit').html('').removeClass('edit');
        },
        error: function(e){
          console.log(e.responseText);
        }
      });
  });


  $(document).on('click','.addStatus',function(){
    var parent=$(this).attr('data-div');
    var length=$('.'+parent).find('.cloneStatus').length;
    if(length>=4){
      alert('You can add 4 status only.');
      return false;
    }else{
      $('.'+parent).find( ".cloneStatus:last" ).clone().insertAfter('.'+parent+' .cloneStatus:last');
      $('.'+parent).find('.addStatus').hide();
      $('.'+parent).find('.removeStatus').show();
      $('.'+parent).find('.cloneStatus:last label').text('');
      $('.'+parent).find('.cloneStatus:last :input').removeAttr('readonly').val('');
      var length=$('.'+parent).find('.cloneStatus').length;
      if(length<4){
        $('.'+parent).find('.addStatus:last').show();
      }
    }
    return false;
  });


  $(document).on('click','.removeStatus',function(){
    var parent=$(this).attr('data-div');
    $(this).closest('.cloneStatus').remove();
    $('.'+parent).find('.addStatus').hide();
    $('.'+parent).find('.addStatus:last').show();
    $('.'+parent).find('.cloneStatus:first label').text('Status *');
    $('.'+parent).find('.removeStatus').hide();
    var length=$('.'+parent).find('.cloneStatus').length;
    if(length>1){
      $('.'+parent).find('.removeStatus').show();
    }
    if(length==1){
      $('.'+parent).find('.removeStatus:first').hide();
    }
    return false;
  });

  $(document).on('click','.addOption',function(){
    var parent=$(this).attr('data-div');
    $('.'+parent).find( ".cloneTask:last" ).clone().insertAfter('.'+parent+' .cloneTask:last');
    $('.'+parent).find('.addOption').hide();
    $('.'+parent).find('.addOption:last').show();
    $('.'+parent).find('.removeOption').show();
    $('.'+parent).find('.cloneTask:last label').text('');
    $('.'+parent).find('.cloneTask:last :input').removeAttr('readonly').val('');
    return false;
  });


  $(document).on('click','.removeOption',function(){
    var parent=$(this).attr('data-div');
    $(this).closest('.cloneTask').remove();
    $('.'+parent).find('.addOption').hide();
    $('.'+parent).find('.addOption:last').show();
    $('.'+parent).find('.removeOption').hide();
    $('.'+parent).find('.cloneTask:first label').text('Options *');
    var length=$('.'+parent).find('.cloneTask').length;
    if(length>1){
      $('.'+parent).find('.removeOption').show();
    }
    if(length==1){
      $('.'+parent).find('.removeOption:first').hide();
    }
    return false;
  });

  $(document).on('click','.deleteButton',function(){
    $('.edit_row,.add_row').hide('slow');
    $('.successMessage').hide('slow');
    $('.errorMessage').hide('slow');
    var len=$('.selectRecords:checked').length;
    if(len==0){
      $('.errorMessage span').html('Please select atleast one record.');
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
       url: '{{URL::action('TestController@deletedailytaskspost')}}',
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
      url: '{{URL::action('TestController@getdailytaskspost')}}',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success:function(data){
        console.log(data);
        if(data.result=='success'){
          var parent=$('.edit_row');
          parent.find('#taskType').val(data.type);
          $('.editGroupName').val(data.group);
          $('.editTaskName').val(data.task);
          $('.editStudents').val(data.students);
          $('.editStartDate').val(data.startDate);
          $('.editEndDate').val(data.endDate);
          $('.editId').val(editId);
          var type=data.type;
          parent.find('.dailyTaskDiv').hide();
          parent.find('.monthlyTaskDiv').hide();
          parent.find('.weeklyTaskDiv').hide();
          var day=data.day;
          if(type=='daily'){
            parent.find('.dailyTaskDiv').show();
            parent.find('.dailyDay').each(function(){
              var val=$(this).val();
              if(jQuery.inArray(val,data.day) !== -1){
                $(this).prop('checked',true);
              }else{
                $(this).prop('checked',false);
              }
            });
          }else if(type=='weekly'){
            parent.find('.weeklyDay').val(data.day);
            parent.find('.weeklyTaskDiv').show();
          }else if(type=='monthly'){
            parent.find('.monthlyDay').val(data.day);
            parent.find('.monthlyTaskDiv').show();
          }


          $('.edit_row').show('slow');
          if(data.options!=''){
            $('.optionsDiv').html(data.options);
          }
          var length=$('.optionsDiv .cloneTask').length;
          if(length>1){
            $('.optionsDiv .addOption').hide();
            $('.optionsDiv .removeOption').show();
            $('.optionsDiv .addOption:last').show();
          }

          if(data.status!=''){
            $('.statusDiv').html(data.status);
          }
          var length=$('.statusDiv .cloneStatus').length;
          if(length>1){
            $('.statusDiv .addStatus').hide();
            $('.statusDiv .removeStatus').show();
            var length=$('.edit_row').find('.cloneStatus').length;
            if(length<4){
              $('.statusDiv .addStatus:last').show();
            }
          }

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

   @if(Session::has('taskserror'))
    var value= "{{Session::get('taskserror')}}";
    $('.'+value).show('slow');
  @endif
  </script>
  @stop

