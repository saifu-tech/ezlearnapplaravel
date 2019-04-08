<?php
use App\Group;
use App\Students;
use App\Dailytasksstatus;
?>


<?php $__env->startSection('pageTitle'); ?>
Daily Tasks Status
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <li><a href="javascript:void(o)">Daily Tasks Status</a></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('maincontent'); ?>




 <!-- START CONTAINER -->
<div class="container-default">
<?php if(Auth::user()->type=='student'): ?>
<div aria-label="..." role="group" class="btn-group">
        <a href="javascript:void(0)" class="btn btn-light btn-sm addJob"><i class="fa fa-plus"></i>Update Task</a>
      </div>


<div class="row add_row"  style="display: none">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Update Tasks
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>

            <div class="panel-body">
              <?php echo e(Form::open(['url'=>'admin/student/daily/task/update/post'])); ?>

              <?php if(Session::has('success')): ?> <?php echo HTML::display_success('success'); ?> <?php endif; ?>

                  <div class="form-group">
                    <?php echo e(Form::label('dailyGroup','Group *',['class'=>'form-label'])); ?>

                    <?php echo e(Form::select('dailyGroup',$dailyGroups,'',['class'=>'form-control','placeholder'=>'Select daily group'])); ?>

                    <?php if($errors->add->has('dailyGroup')): ?> 
                      <div class="validation-error errorActive asterisk">
                        <?php echo e($errors->add->first('dailyGroup')); ?>

                      </div> 
                    <?php endif; ?>
                  </div>

                  <div class="form-group">
                    <?php echo e(Form::label('option','Options *',['class'=>'form-label'])); ?>

                    <?php echo e(Form::select('option',[],'',['class'=>'form-control','placeholder'=>'Select option'])); ?>

                    <?php if($errors->add->has('option')): ?> 
                      <div class="validation-error errorActive asterisk">
                        <?php echo e($errors->add->first('option')); ?>

                      </div> 
                    <?php endif; ?>
                  </div>

                <div class="form-group">
                    <?php echo e(Form::label('statusDate','Date *',['class'=>'form-label'])); ?>

                    <?php echo e(Form::text('statusDate','',['class'=>'form-control statusDate'])); ?>

                    <?php if($errors->add->has('statusDate')): ?> 
                      <div class="validation-error errorActive asterisk">
                          <?php echo e($errors->add->first('statusDate')); ?>

                      </div> 
                  <?php endif; ?>
                </div>
                <?php 
                $status=Dailytasksstatus::all();
                ?>
                <div class="form-group statusDiv" style="display:none;">
                    <?php echo e(Form::label('status','Status *',['class'=>'form-label'])); ?>

                    <?php foreach($status as $sta): ?>
                      <?php echo e(Form::radio('status',$sta->id,'')); ?>&nbsp;<?php echo e($sta->name); ?>&nbsp;&nbsp;&nbsp;
                    <?php endforeach; ?>
                </div>

                <?php echo e(Form::submit('Save',['class'=>'btn btn-default'])); ?>

              <?php echo e(Form::close()); ?>

            </div>

      </div>
    </div>
    </div>
<?php endif; ?>

<?php if(count($groups)>0): ?>
 <div class="row userfilter">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default">
        <div class="panel-title">Filter</div>
            <div class="panel-body">
              <form id='manageEmployee'>
                <div class="row">

                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      <?php echo e(Form::label('taskType','Task Type *',['class'=>'form-label'])); ?>

                      <?php echo e(Form::select('taskType',['daily'=>'Daily Task','weekly'=>'Weekly Task','monthly'=>'Monthly Task'],'daily',['class'=>'form-control','placeholder'=>'Select Type'])); ?>                 
                  </div>
                </div>

                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      <?php echo e(Form::label('group','Group *',['class'=>'form-label'])); ?>

                      <?php echo e(Form::select('group',[],'',['class'=>'form-control','placeholder'=>'Select Group'])); ?>                 
                  </div>
                </div>
                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      <?php echo e(Form::label('fromDate','From Date',['class'=>'form-label'])); ?>

                      <?php echo e(Form::text('fromDate','',['class'=>'form-control'])); ?>                 
                  </div>
                </div>
                <div class="col-sm-4 col-md-3 col-lg-2">
                  <div class="form-group">
                      <?php echo e(Form::label('toDate','To Date',['class'=>'form-label'])); ?>

                      <?php echo e(Form::text('toDate','',['class'=>'form-control'])); ?>                 
                  </div>
                </div>
                </div>
                <button id="filterTask" class="btn btn-default btn-sm" type="button">Search</button>
              </form>
            </div>
      </div>
    </div>
  </div>
<?php else: ?>
<div class="kode-alert kode-alert-icon alert6-light">
  <i class="fa fa-lock"></i>
  <a href="javascript:void(0)" class="closed">×</a>
  No daily task available.
</div>
<?php endif; ?>
<div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;">
  <i class="fa fa-lock"></i>
  <a href="javascript:void(0)" class="closed">×</a>
  Please select group.
</div>
<?php
        $status=Dailytasksstatus::all();
        ?>
<div class="panel panel-default" id="statusResult" style="display:none;">
        <div class="panel-title">
          <span class="col-sm-6 tableGroupName"></span><span class="col-sm-6 statusColors" style="float:right">

          </span>
        </div>

        <div class="panel-body" style="margin-top:30px;">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          </div>
        </div>
      </div>
    <!-- End Panel -->
<!--end data table-->
</div>
<!-- END CONTAINER -->


<!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Change Task Status</h4>
        </div>
        <div class="modal-body">
        
        <?php echo e(Form::open(['class'=>'form-horizontal'])); ?>

        <div class="form-group">
          <?php echo e(Form::label('taskGroup','Group',['class'=>'col-sm-2 control-label'])); ?>

            <div class="col-sm-8 taskGroupDiv">
            </div>
          </div>

          <div class="form-group">
          <?php echo e(Form::label('taskOption','Option',['class'=>'col-sm-2 control-label'])); ?>

            <div class="col-sm-8 taskOptionDiv">
            </div>
          </div>

          <div class="form-group">
          <?php echo e(Form::label('taskTime','Date',['class'=>'col-sm-2 control-label'])); ?>

            <div class="col-sm-8 taskTimeDiv">
            </div>
          </div>
         <?php $status=Dailytasksstatus::all(); ?>
        <div class="form-group">
          <?php echo e(Form::label('taskStatus','Status',['class'=>'col-sm-2 control-label'])); ?>

          <div class="col-sm-8 modalTaskStatus">
          <?php foreach($status as $sta): ?>
            <?php echo e(Form::radio('taskStatus',$sta->id,'')); ?>&nbsp;<?php echo e($sta->name); ?>&nbsp;&nbsp;&nbsp;
          <?php endforeach; ?>
          </div>
        </div>
        <div class="clearfix"></div>
        <?php echo e(Form::hidden('taskOption','',['class'=>'taskOption'])); ?>

        <?php echo e(Form::hidden('taskTime','',['class'=>'taskTime'])); ?>

        <?php echo e(Form::hidden('taskGroup','',['class'=>'taskGroup'])); ?>

        <?php echo e(Form::close()); ?>

        
        </div>
        <div class="alert alert-success modalSuccess" style="display:none;"></div>
        <div class="alert alert-danger modalError" style="display:none;"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary saveTaskUpdate">Update</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!--END Modal -->
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('custom-footer-scripts'); ?>
    <?php echo e(HTML::script('js/moment/moment.min.js')); ?>

  <?php echo e(HTML::script('js/date-range-picker/daterangepicker.js')); ?>

  <script>
 $('#fromDate,#toDate,#statusDate').daterangepicker({
    singleDatePicker: true, 
    format: "DD-MM-YYYY"
  });

 gettaskgroups();

 $(document).on('change','#taskType',function(){
  gettaskgroups();
  return false;
 });

 function gettaskgroups(){
  var type=$('#taskType').val();
  $.ajax({
    type: 'POST',
    url: '<?php echo e(URL::action('TestController@gettaskgroups')); ?>',
    data: {type:type},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      var html='<option value="">Select Group</option>';
      $('#group').empty();
      $.each(data.groups,function(ele,val){
        html+='<option value="'+ele+'">'+val+'</option>';
      });
      $('#group').append(html);
    },
    error: function(e){
      console.log(e.responseText);
    }
  });
 }


 $(document).on('click','.addJob',function(){
      $('.add_row').toggle();
      $('.add_row:input').val('');
      $('.successMessage').hide('slow');
      $('.errorMessage').hide('slow');
       $('#statusResult').hide();
       return false;
  });

 $(document).on('click','.saveTaskUpdate',function(){
   var option=$('.taskOption').val();
   var time=$('.taskTime').val();
   var group=$('.taskGroup').val();
   var status=$('input[name="taskStatus"]:checked').val();
   $.ajax({
    type: 'POST',
    url: '<?php echo e(URL::action('TestController@updatestudenttaskstatus')); ?>',
    data: {group:group,option:option,time:time,status:status},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      $('.currentUpdateStatus').css( "background-color",data.color );
      $('.modalSuccess').show().html('Task status updated successfully.');
      $('#myModal').modal('show');
      setTimeout(function(){
        $('.modalSuccess,.modalError').hide();
        $('#myModal').modal('hide');
      },5000);
    },
    error: function(e){
      console.log(e.responseText);
    }
  });

 });

 $(document).on('click','.updateStatus',function(){
  $('.modalSuccess,.modalError').hide();
  $('.updateStatus').removeClass('currentUpdateStatus');
  $(this).addClass('currentUpdateStatus');
  var option=$(this).attr('data-option');
  var group=$(this).attr('data-group');
  var time=$(this).attr('data-time');
  $.ajax({
    type: 'POST',
    url: '<?php echo e(URL::action('TestController@getdailytaskdetailsget')); ?>',
    data: {group:group,option:option,time:time},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      var parent=$('#myModal');
      parent.find('.taskOption').val(option);
      parent.find('.taskGroup').val(group);
      parent.find('.taskTime').val(time);
      $('.modalTaskStatus').html(data.html);
      var status=data.currentStatus;
      if(status!=''){
        $('.modalTaskStatus input').each(function(){
          var val=$(this).val();
          if(val==status){
            $(this).prop('checked',true);
          }
        });
      }
      $('.taskOptionDiv').text(data.optionName);
      $('.taskGroupDiv').text(data.groupName);
      $('.taskTimeDiv').text(data.taskTime);
      $('#myModal').modal('show');
    },
    error: function(e){
      console.log(e.responseText);
    }
  });

  return false;
 });

 $(document).on('click','#filterTask',function(){
  $('.add_row').hide();
  $('#statusResult').hide();
  $('.errorMessage').hide();
  var group=$('#group').val();
  if(group==''){
    $('.errorMessage').show();
    setTimeout(function(){
      $('.errorMessage').hide();
    },5000);
    return false;
  }
  var fromDate=$('#fromDate').val();
  var toDate=$('#toDate').val();
  var type=$('#taskType').val();
  $.ajax({
    type: 'POST',
    url: '<?php echo e(URL::action('TestController@taskstatusreport')); ?>',
    data: {group:group,fromDate:fromDate,toDate:toDate,type:type},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      $('.panel-group').html(data.html);
      $('.tableGroupName').html(data.groupName);
      $('.statusColors').html(data.statusHtml);
      $('#statusResult').show();
    },
    error: function(e){
      console.log(e.responseText);
    }
  });
 });

 $(document).on('change','#dailyGroup',function(){
   var group=$('#dailyGroup').val();
   $.ajax({
    type: 'POST',
    url: '<?php echo e(URL::action('TestController@getdailygroupoptions')); ?>',
    data: {group:group},
    dataType: 'json',
    headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
    success: function(data){
      console.log(data);
      var options=data.options;
      var html='<option value="">Select option</option>';
      $.each(options,function(ele,val){
        html+='<option value="'+ele+'">'+val+'</option>';
      });
      $('#option').empty().append(html);

      var status=data.status;
      if(status!=''){
        $('.statusDiv').html(status);
      }
      $('.statusDiv').show();
      getcurrenttaskstatus();
    },
    error: function(e){
      console.log(e.responseText);
    }
  });
 });

 $(document).on('change','#option,#statusDate',function(){
  getcurrenttaskstatus();
 });

 function getcurrenttaskstatus(){
    var group=$('#dailyGroup').val();
    var statusDate=$('#statusDate').val();
    var option=$('#option').val();
    if(group!='' && statusDate!='' && option!=''){
      $.ajax({
        type: 'POST',
        url: '<?php echo e(URL::action('TestController@getdailytaskstatuspost')); ?>',
        data: {group:group,statusDate:statusDate,option:option},
        dataType: 'json',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success: function(data){
          console.log(data);
          var status=data.currentStatus;
          if(status!=''){
            $('.statusDiv input').each(function(){
              var val=$(this).val();
              if(val==status){
                $(this).prop('checked',true);
              }
            });
          }
        },
        error: function(e){
          console.log(e.responseText);
        }
      });
    }
    return true;
 }

 <?php if(Session::has('taskserror')): ?>
    var value= "<?php echo e(Session::get('taskserror')); ?>";
    $('.'+value).show('slow');
  <?php endif; ?>
  </script>
  <?php $__env->stopSection(); ?>


<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>