<?php
  use App\Students;
  use App\Country;
?>


<?php $__env->startSection('pageTitle'); ?>
Students
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <li><a href="javascript:void(o)">Students</a></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('maincontent'); ?>
<style type="text/css">
  .hideDiv{
    display:none;
  }
</style>



 <!-- START CONTAINER -->
<div class="container-default" ng-app="studentFilter" ng-controller="studentController">

 <div aria-label="..." role="group" class="btn-group">
        <a href="javascript:void(0)" class="btn btn-light btn-sm addJob"><i class="fa fa-plus"></i>Add</a>
        <a class="btn btn-light btn-sm deleteButton" type="button"><i class="fa fa-trash"></i>Delete</a>
      </div>

<div class="row add_row"  style="display: none">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Add Student
          <ul class="panel-tools">
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>

            <div class="panel-body">
              <?php echo e(Form::open(['url'=>'admin/student/add/post','files'=>true, 'class'=>'form-horizontal'])); ?>

              <?php if(Session::has('success')): ?> <?php echo HTML::display_success('success'); ?> <?php endif; ?>

              <div class="form-group">
                  <?php echo e(Form::label('studentCode','Student Code *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('studentCode',Students::autogeneratecode(),['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('studentCode')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('studentCode')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('fullname','Full Name *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('fullname','',['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('fullname')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('fullname')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('email','Email *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('email','',['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('email')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('email')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('gender','Gender *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::select('gender',['male'=>'Male','female'=>'Female'],'',['class'=>'form-control','placeholder'=>'Select Gender'])); ?>

                  <?php if($errors->add->has('gender')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('gender')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('dob','Date of Birth',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('dob','',['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('dob')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('dob')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('mobile','Mobile',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('mobile','',['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('mobile')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('mobile')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('address','Address',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('address','',['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('address')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('address')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('country','Country',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::select('country',$country,'',['class'=>'form-control','placeholder'=>'Select Country'])); ?>

                  <?php if($errors->add->has('country')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('country')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('studentPic','Profile Picture',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::file('studentPic',['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('studentPic')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('studentPic')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>
                <fieldset>
                  <legend>Login Details</legend>
                  <div class="form-group">
                  <?php echo e(Form::label('loginId','Login Id *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('loginId','',['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('loginId')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('loginId')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('password','Password *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::password('password',['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('password')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('password')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('confirmPassword','Confirm Password *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::password('confirmPassword',['class'=>'form-control'])); ?>

                  <?php if($errors->add->has('confirmPassword')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->add->first('confirmPassword')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>
                </fieldset>

                <div class="form-group">
                <?php echo e(Form::label('',' ',['class'=>'col-sm-2 control-label'])); ?>

                <div class="col-sm-8">
                <?php echo e(Form::submit('Save',['class'=>'btn btn-default'])); ?>

                </div>
                </div>
              <?php echo e(Form::close()); ?>

            </div>

      </div>
    </div>
    </div>

      <div class="row edit_row" style="display: none">
        <div class="col-md-12 col-lg-12">
            <div class="panel panel-default">

              <div class="panel-title">
                Edit Student
                <ul class="panel-tools">
                  <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                </ul>
              </div>

              <div class="panel-body">
                <?php echo e(Form::open(['url'=>'admin/student/edit/post','class'=>'form-horizontal'])); ?>

                <?php if(Session::has('success')): ?> <?php echo HTML::display_success('success'); ?> <?php endif; ?>

                <div class="form-group">
                  <?php echo e(Form::label('studentCode','Student Code *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('studentCode','',['class'=>'form-control editStudentCode'])); ?>

                  <?php if($errors->edit->has('studentCode')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->edit->first('studentCode')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>


                  <div class="form-group">
                  <?php echo e(Form::label('fullname','Full Name *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('fullname','',['class'=>'form-control editFullname'])); ?>

                  <?php if($errors->edit->has('fullname')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->edit->first('fullname')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('email','Email *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('email','',['class'=>'form-control editEmail'])); ?>

                  <?php if($errors->edit->has('email')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->edit->first('email')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('gender','Gender *',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::select('gender',['male'=>'Male','female'=>'Female'],'',['class'=>'form-control editGender','placeholder'=>'Select Gender'])); ?>

                  <?php if($errors->edit->has('gender')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->edit->first('gender')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('dob','Date of Birth',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('dob','',['class'=>'form-control editDob'])); ?>

                  <?php if($errors->edit->has('dob')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->edit->first('dob')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('mobile','Mobile',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('mobile','',['class'=>'form-control editMobile'])); ?>

                  <?php if($errors->edit->has('mobile')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->edit->first('mobile')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('address','Address',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::text('address','',['class'=>'form-control editAddress'])); ?>

                  <?php if($errors->edit->has('address')): ?> 
                    <div class="validation-error errorActive asterisk">
                       <?php echo e($errors->edit->first('address')); ?>

                   </div> 
                  <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <?php echo e(Form::label('country','Country',['class'=>'col-sm-2 control-label'])); ?>

                  <div class="col-sm-8">
                  <?php echo e(Form::select('country',$country,'',['class'=>'form-control editCountry','placeholder'=>'Select Country'])); ?>

                  <?php if($errors->edit->has('country')): ?> 
                  <div class="validation-error errorActive asterisk">
                    <?php echo e($errors->edit->first('country')); ?>

                  </div> 
                  <?php endif; ?>
                  </div>
                </div>


                <div class="form-group">
                <?php echo e(Form::label('',' ',['class'=>'col-sm-2 control-label'])); ?>

                <div class="col-sm-8">
                  <?php echo e(Form::hidden('editId','',['class'=>'editRowId'])); ?>

                  <?php echo e(Form::submit('Update',['class'=>'btn btn-default'])); ?>

                </div>
                </div>
                <?php echo e(Form::close()); ?>

              </div>

            </div>
          </div>
          </div>

<div class="row manage_row" id="">

        

    <!-- Start Panel -->
    <div class="col-md-12">

      <div class="panel panel-default">
        <div class="panel-title">
          List of Students
        </div>
        <div class="panel-body table-responsive">

          <div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;">
            <i class="fa fa-lock"></i>
            <a href="#" class="closed">×</a>
            <span></span>
          </div>
          <div style="float: left;"><b>Shows</b> &nbsp;&nbsp;<select ng-model="recordLimit" ng-init="recordLimit=10" ng-options="item for item in recordArray">
    </select></div>
    <div style="float: right;"><b>Search</b> &nbsp;&nbsp;<input type="text" ng-model="filterSearch"></div>
            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th ng-click="sort('s_no')">S.No</th>
                        <th ng-click="sort('code')">Code</th>
                        <th ng-click="sort('name')">Name</th>
                        <th ng-click="sort('gender')">gender</th>
                        <th ng-click="sort('dob')">DOB</th>
                        <th ng-click="sort('country')">Country</th>
                        <th ng-click="sort('email')">Email</th>
                        <th>Edit</th>
                        <th><i class="fa fa-trash"></i></th>
                    </tr>
                </thead>
             
                <tbody>
                    <tr dir-paginate="rec in records |orderBy:sortKey:reverse | filter: filterSearch|itemsPerPage:recordLimit">
                      <td>{{rec.sno}}</td>
                      <td>{{rec.code}}</td>
                      <td>{{rec.name}}</td>
                      <td>{{rec.gender | capitalize}}</td>
                      <td>{{rec.dob | date:'dd-MM-yyyy'}}</td>
                      <td>{{rec.country}}</td>
                      <td>{{rec.email}}</td>
                      <td><a href="javascript:void(0)" class="edit" editId="{{rec.id}}"><i class="fa fa-pencil-square-o"></i></a></td>
                      <td><div class="checkbox"><input type="checkbox" id="checkbox{{rec.sno}}" class="selectRecords" data-record="{{rec.id}}"><label for="checkbox{{rec.sno}}"></label></div></td>
                    </tr>
                </tbody>
            </table>

            <dir-pagination-controls
       max-size="10"
       direction-links="true"
       boundary-links="true" >
    </dir-pagination-controls>


        </div>

      </div>
    </div>
    </div>
    <!-- End Panel -->
<!--end data table-->
</div>
<!-- END CONTAINER -->
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('custom-footer-scripts'); ?>
  <?php echo e(HTML::script('js/datatables/datatables.min.js')); ?>

  <?php echo e(HTML::script('js/bootbox/bootbox.min.js')); ?>

  <?php echo e(HTML::script('js/moment/moment.min.js')); ?>

  <?php echo e(HTML::script('js/date-range-picker/daterangepicker.js')); ?>

  <?php echo e(HTML::script('js/angular.min.js')); ?>

  <?php echo e(HTML::script('js/dirPagination.js')); ?>

  <?php echo e(HTML::script('js/studentfilter.js')); ?>

    
  <script>
  $(document).ready(function() {
      // $('#example0').DataTable();
  });

  $('#dob,.editDob').daterangepicker({
        singleDatePicker: true, 
        format: "DD-MM-YYYY"
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
       url: '<?php echo e(URL::action('TestController@deletestudentpost')); ?>',
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
      url: '<?php echo e(URL::action('TestController@getstudentpost')); ?>',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success:function(data){
        console.log(data);
        if(data.status=='success'){
          $('.editCountry').val(data.country);
          $('.editStudentCode').val(data.code);
          $('.editFullname').val(data.fullname);
          $('.editEmail').val(data.email);
          $('.editDob').val(data.dob);
          $('.editGender').val(data.gender);
          $('.editMobile').val(data.mobile);
          $('.editAddress').val(data.editAddress);
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

   <?php if(Session::has('studenterror')): ?>
    var value= "<?php echo e(Session::get('studenterror')); ?>";
    $('.'+value).show('slow');
  <?php endif; ?>
  </script>
  <?php $__env->stopSection(); ?>


<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>