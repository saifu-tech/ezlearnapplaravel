<?php 
use App\Subcategory;
use App\Courses;
use App\Subjects;
use App\Classname;
use App\Category;
use App\Options;
use App\Privilege;
$lable1=Options::getvalue('lable1');
$lable2=Options::getvalue('lable2');
?>
@extends('master')

@section('pageTitle')
  Courses
@stop

<style type="text/css">
  .subcategoryDiv,.editSubcategoryDiv{
    display:none;
  }
</style>
@section('breadcrumb')
  <li><a href="javascript:void(o)">Masters</a></li>
  <li><a href="javascript:void(o)">Courses</a></li>
@stop

@section('maincontent')


 <!-- START CONTAINER -->
<div class="container-default" ng-app="coursesFilter" ng-controller="coursesController">

<div aria-label="..." role="group" class="btn-group">
@if(Privilege::getprivilegestatus(4,Auth::user()->id,'addStatus')=='yes')
  <a href="javascript:void(0)" class="btn btn-light btn-sm addJob"><i class="fa fa-plus"></i>Add</a>
@endif
@if(Privilege::getprivilegestatus(4,Auth::user()->id,'deleteStatus')=='yes')
  <a class="btn btn-light btn-sm deleteButton" type="button"><i class="fa fa-trash"></i>Delete</a>
@endif
</div>

<div class="row add_row"  style="display: none">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Add Courses
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>

            <div class="panel-body">
              {!! Form::open(['url'=>'admin/masters/courses/add/post']) !!}
                @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif

                <div class="form-group">
                    {{Form::label('class',$lable1.' *',['class'=>'form-label'])}}
                    {{Form::select('class',$classes,'',['class'=>'form-control changeClasses','placeholder'=>'Select '.$lable1])}}
                    @if ($errors->add->has('class')) 
                      <div class="validation-error errorActive asterisk">
                        The {{$lable1}} field is required.
                      </div> 
                    @endif
                  </div>

                  <div class="form-group">
                    {{Form::label('subject',$lable2.' *',['class'=>'form-label'])}}
                    {{Form::select('subject',[''=>'Select '.$lable2],'',['class'=>'form-control changeSubjects'])}}
                    @if ($errors->add->has('subject')) 
                      <div class="validation-error errorActive asterisk">
                          The {{$lable2}} field is required.
                      </div> 
                    @endif
                  </div>

                  <a href="javascript:void(0)" style="float:right;" class="viewCategory">Show Category</a>

                  <div class="form-group subdiv addCategory" style="display:none;">
                    {{Form::label('parentCategory','Parent Category',['class'=>'form-label'])}}
                    {{Form::select('parentCategory',[''=>'Select Parent Category'],'',['class'=>'form-control changeParent'])}}
                    @if ($errors->add->has('parentCategory')) 
                      <div class="validation-error errorActive asterisk">
                          {{ $errors->add->first('parentCategory') }}
                      </div> 
                    @endif
                  </div>

                  <div class="form-group subcategoryDiv">
                    {!! Form::label('courseSubCate','Sub Category',['class'=>'form-label']) !!}
                    {!! Form::select('courseSubCate',[''=>'Select Sub Category'],'',['class'=>'form-control changeSubCat']) !!}
                    @if ($errors->add->has('courseSubCate')) 
                      <div class="validation-error errorActive asterisk">
                         {!!  $errors->add->first('courseSubCate')  !!}
                     </div> 
                   @endif
                  </div>

                <div class="form-group">
                  {!! Form::label('courseCode','Course Code *',['class'=>'form-label']) !!}
                  {!! Form::text('courseCode',Courses::autogeneratecode(),['class'=>'form-control','placeholder'=>'Code']) !!}
                  @if ($errors->add->has('courseCode')) 
                    <div class="validation-error errorActive asterisk">
                       {!!  $errors->add->first('courseCode')  !!}
                   </div> 
                 @endif
                </div>

                <div class="form-group">
                  {!! Form::label('courseName','Course Name *',['class'=>'form-label']) !!}
                  {!! Form::text('courseName','',['class'=>'form-control','placeholder'=>'Name']) !!}
                  @if ($errors->add->has('courseName')) 
                    <div class="validation-error errorActive asterisk">
                       {!!  $errors->add->first('courseName')  !!}
                   </div> 
                 @endif
                </div>

                <div class="form-group">
                  {!! Form::label('startDate','Start Date *',['class'=>'form-label']) !!}
                  {!! Form::text('startDate','',['class'=>'form-control','placeholder'=>'Start Date']) !!}
                  @if ($errors->add->has('startDate')) 
                    <div class="validation-error errorActive asterisk">
                       {!!  $errors->add->first('startDate')  !!}
                   </div> 
                 @endif
                </div>

                <div class="form-group">
                  {!! Form::label('endDate','End Date *',['class'=>'form-label']) !!}
                  {!! Form::text('endDate','',['class'=>'form-control','placeholder'=>'End Date']) !!}
                  @if ($errors->add->has('endDate')) 
                    <div class="validation-error errorActive asterisk">
                       {!!  $errors->add->first('endDate')  !!}
                   </div> 
                 @endif
                </div>

                <div class="form-group">
                  {!! Form::label('youtubeLink','Youtube Link',['class'=>'form-label']) !!}
                  {!! Form::text('youtubeLink','',['class'=>'form-control','placeholder'=>'Youtube Link']) !!}
                  @if ($errors->add->has('youtubeLink')) 
                    <div class="validation-error errorActive asterisk">
                       {!!  $errors->add->first('youtubeLink')  !!}
                   </div> 
                 @endif
                </div>

                <div class="form-group">
                  {!! Form::label('courseDescription','Course Description',['class'=>'form-label']) !!}
                  {!! Form::textarea('courseDescription','',['class'=>'form-control','placeholder'=>'Description','rows'=>5]) !!}
                </div>
                {!! Form::submit('Save',['class'=>'btn btn-default']) !!}
              {!! Form::close() !!}
            </div>

      </div>
    </div>
    </div>

      <div class="row edit_row" style="display: none">
        <div class="col-md-12 col-lg-12">
            <div class="panel panel-default">

              <div class="panel-title">
                Edit Course
                <ul class="panel-tools">
                  <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                  <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
                  <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                </ul>
              </div>

              <div class="panel-body">
                {!! Form::open(['url'=>'admin/masters/courses/edit/post']) !!}
                  @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif

                  <div class="form-group">
                    {{Form::label('class',$lable1.' *',['class'=>'form-label'])}}
                    {{Form::select('class',$classes,'',['class'=>'form-control editClass','placeholder'=>'Select '.$lable1])}}
                    @if ($errors->edit->has('class')) 
                      <div class="validation-error errorActive asterisk">
                        The {{$lable1}} field is required.
                      </div> 
                    @endif
                  </div>

                  <div class="form-group">
                    {{Form::label('subject',$lable2.' *',['class'=>'form-label'])}}
                    {{Form::select('subject',[''=>'Select '.$lable2],'',['class'=>'form-control editSubject'])}}
                    @if ($errors->edit->has('subject')) 
                      <div class="validation-error errorActive asterisk">
                          The {{$lable2}} field is required.
                      </div> 
                    @endif
                  </div>

                  <div class="form-group subdiv">
                    {{Form::label('parentCategory','Parent Category',['class'=>'form-label'])}}
                    {{Form::select('parentCategory',[''=>'Select Parent Category'],'',['class'=>'form-control editParentCategory'])}}
                    @if ($errors->edit->has('parentCategory')) 
                      <div class="validation-error errorActive asterisk">
                          {{ $errors->edit->first('parentCategory') }}
                      </div> 
                    @endif
                  </div>


                  <div class="form-group editSubcategoryDiv">
                    {!! Form::label('courseEditSubCate','Sub Category *',['class'=>'form-label']) !!}
                    {!! Form::select('courseEditSubCate',[''=>'Select Sub Category'],'',['class'=>'form-control']) !!}
                    @if ($errors->edit->has('courseEditSubCate')) 
                      <div class="validation-error errorActive asterisk">
                        {!!  $errors->edit->first('courseEditSubCate')  !!}
                      </div> 
                    @endif
                  </div>

                  <div class="form-group">
                    {!! Form::label('courseEditCode','Course Code *',['class'=>'form-label']) !!}
                    {!! Form::text('courseEditCode','',['class'=>'form-control','placeholder'=>'Code']) !!}
                    @if ($errors->edit->has('courseEditCode')) 
                      <div class="validation-error errorActive asterisk">
                        {!!  $errors->edit->first('courseEditCode')  !!}
                     </div> 
                    @endif
                  </div>

                  <div class="form-group">
                    {!! Form::label('courseEditName','Course Name *',['class'=>'form-label']) !!}
                    {!! Form::text('courseEditName','',['class'=>'form-control','placeholder'=>'Name']) !!}
                    @if ($errors->edit->has('courseEditName')) 
                      <div class="validation-error errorActive asterisk">
                        {!!  $errors->edit->first('courseEditName')  !!}
                     </div> 
                    @endif
                  </div>


                  <div class="form-group">
                  {!! Form::label('startDate','Start Date *',['class'=>'form-label']) !!}
                  {!! Form::text('startDate','',['class'=>'form-control editStartDate','placeholder'=>'Start Date']) !!}
                  @if ($errors->edit->has('startDate')) 
                    <div class="validation-error errorActive asterisk">
                       {!!  $errors->edit->first('startDate')  !!}
                   </div> 
                 @endif
                </div>

                <div class="form-group">
                  {!! Form::label('endDate','End Date *',['class'=>'form-label']) !!}
                  {!! Form::text('endDate','',['class'=>'form-control editEndDate','placeholder'=>'End Date']) !!}
                  @if ($errors->edit->has('endDate')) 
                    <div class="validation-error errorActive asterisk">
                       {!!  $errors->edit->first('endDate')  !!}
                   </div> 
                 @endif
                </div>

                <div class="form-group">
                  {!! Form::label('youtubeLink','Youtube Link',['class'=>'form-label']) !!}
                  {!! Form::text('youtubeLink','',['class'=>'form-control editYoutubeLink','placeholder'=>'Youtube Link']) !!}
                  @if ($errors->edit->has('youtubeLink')) 
                    <div class="validation-error errorActive asterisk">
                       {!!  $errors->edit->first('youtubeLink')  !!}
                   </div> 
                 @endif
                </div>

                  <div class="form-group">
                    {!! Form::label('courseEditDescription','Course Description',['class'=>'form-label']) !!}
                    {!! Form::textarea('courseEditDescription','',['class'=>'form-control','placeholder'=>'Description','rows'=>5]) !!}
                  </div>
                  {!! Form::hidden('editId','',['class'=>'editRowId']) !!}
                  {!! Form::submit('Update',['class'=>'btn btn-default']) !!}
                {!! Form::close() !!}
              </div>

            </div>
          </div>
          </div>

<div class="row manage_row" id="">

        

    <!-- Start Panel -->
    <div class="col-md-12">

      <div class="panel panel-default">
        <div class="panel-title">
          List of courses
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
                        <th>Course</th>
                        <th>{{$lable1}}</th>
                        <th>{{$lable2}}</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        @if(Privilege::getprivilegestatus(4,Auth::user()->id,'editStatus')=='yes')
                        <th>Edit</th>
                        @endif
                        @if(Privilege::getprivilegestatus(4,Auth::user()->id,'deleteStatus')=='yes')
                        <th><i class="fa fa-trash"></i></th>
                        @endif
                    </tr>
                </thead>
             
                <tbody>
                  <tr dir-paginate="rec in records |orderBy:sortKey:reverse | filter: filterSearch|itemsPerPage:10">
                      <td>@{{rec.sno}}</td>
                      <td>@{{rec.code}}</td>
                      <td>@{{rec.name}}</td>
                      <td>@{{rec.class}}</td>
                      <td>@{{rec.subject}}</td>
                      <td>@{{rec.category}}</td>
                      <td>@{{rec.subcategory}}</td>
                      @if(Privilege::getprivilegestatus(4,Auth::user()->id,'editStatus')=='yes')
                      <td><a href="javascript:void(0)" class="edit" editId="@{{rec.id}}"><i class="fa fa-pencil-square-o"></i></a></td>
                      @endif
                      @if(Privilege::getprivilegestatus(4,Auth::user()->id,'deleteStatus')=='yes')
                      <td><div class="checkbox"><input type="checkbox" id="checkbox@{{rec.sno}}" class="selectRecords" data-record="@{{rec.id}}"><label for="checkbox@{{rec.sno}}"></label></div></td>
                      @endif
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
  @stop

  @section('custom-footer-scripts')
  {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
  {{HTML::script('js/datatables/datatables.min.js')}}
  {{HTML::script('js/bootbox/bootbox.min.js')}}
  {{HTML::script('js/angular.min.js')}}
  {{HTML::script('js/dirPagination.js')}}
  {{HTML::script('js/coursefilter.js')}}

  <script>
  $(document).ready(function() {
      // $('#example0').DataTable();
  });

  $('#startDate,#endDate,.editStartDate,.editEndDate').daterangepicker({
      singleDatePicker: true, 
      format: "DD-MM-YYYY"
    });

  var editClass=$('.editClass').val();
  if(editClass!=''){
    getsubjects('edit');
  }

  $(document).on('click','.changeParent',function(){
    var cat=$('.changeParent').val();
    if(cat!=''){
      $('.subcategoryDiv').show();
    }else{
      $('.subcategoryDiv').hide();
    }
    return false;
  });

  $(document).on('click','.viewCategory',function(){
    $('.addCategory').show();
    $(this).html('Hide Category');
    $(this).removeClass('viewCategory').addClass('hideCategory');
  });

  $(document).on('click','.hideCategory',function(){
    $('.addCategory').hide();
    $(this).html('Show Category');
    $(this).removeClass('hideCategory').addClass('viewCategory');
    $('.subcategoryDiv').hide();
  });

  $(document).on('click','.editParentCategory',function(){
    var cat=$('.editParentCategory').val();
    if(cat!=''){
      $('.editSubcategoryDiv').show();
    }else{
      $('.editSubcategoryDiv').hide();
    }
    
  });

  $(document).on('click','.deleteButton',function(){
    $('.edit_row,.add_row').hide('slow');
    $('.successMessage').hide('slow');
    $('.errorMessage').hide('slow');
    var len = $('.selectRecords:checked').length;
    if(len == 0){
      $('.errorMessage span').html('Please select atlease one record.');
      $('.errorMessage').show('slow');
      return false;
    }
    var ids = [];
    $('.selectRecords:checked').each(function(){
      var id = $(this).attr('data-record');
      ids.push(id);
    });
    ids = JSON.stringify(ids);
      $.ajax({
        type: 'POST',
        url: '{!! URL::action('TestController@deletecoursespost') !!}',
        data: { ids:ids },
        dataType: 'json',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success: function(data){
          console.log(data);
          $('.selectRecords:checked').closest('tr').remove();
          $('.errorMessage span').html('Selected record deleted successfully!!.');
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
    var editId = $(this).attr('editId');
    $.ajax({
      type:'POST',
      data: { editId:editId },
      dataType:'JSON',
      url: '{!! URL::action('TestController@getcoursespost') !!}',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success:function(data){
        console.log(data); 
        if(data.status == 'success'){

          var options='<option value="">Select Subject</option>';
          $.each(data.classSubjects,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
          });
          $('.editSubject').empty().append(options);


          var options='<option value="">Select Parent Category</option>';
          $.each(data.classCategory,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['category_name']+'</option>';
          });
          $('.editParentCategory').empty().append(options);

          var subcategory=data.classSubCategory;
          var options='<option value="">Select Sub Category</option>';
          $.each(subcategory,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
          });
          $('#courseEditSubCate').empty().append(options);
          $('.editStartDate').val(data.startDate);
          $('.editEndDate').val(data.endDate);
          $('.editYoutubeLink').val(data.link);
          $('.editClass').val(data.record.class_id);
          $('.editSubject').val(data.record.subject);
          $('.editParentCategory').val(data.record.category)
          $('#courseEditSubCate').val(data.record.subcategory);
          $('#courseEditName').val(data.record.name);
          $('#courseEditCode').val(data.record.code);
          $('#courseEditDescription').val(data.record.name);
          $('.editRowId').val(editId);
          var parentcat=data.record.category;
          if(parentcat!=''){
            $('.editSubcategoryDiv').show();
          }else{
            $('.editSubcategoryDiv').hide();
          }
          $('.edit_row').show('slow');
        }else{
          alert("something went wrong, please try later");
          return false;
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

  function getsubjects(panel='add'){
    if(panel=='add'){
      var val=$('.changeClasses').val();
    }else{
      var val=$('.editClass').val();
    }
    $.ajax({
      type:'POST',
      data: {val},
      dataType:'JSON',
      url: '{{URL::action('TestController@getclasssubjects')}}',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success:function(data){
        console.log(data);
        var subjects=data.subjects;
        var options='<option value="">Select Subject</option>';
        $.each(subjects,function(index,ele){
          options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
        });
        if(panel=='add'){
          $('.changeSubjects').empty().append(options);
          $('.changeParent').empty().append('<option value="">Select Parent Category</option>');
          $('#changeSubCat').empty().append('<option value="">Select Sub Category</option');
        }else{
          $('.editSubject').empty().append(options);
          $('.editParentCategory').empty().append('<option value="">Select Parent Category</option>');
          $('#courseEditSubCate').empty().append('<option value="">Select Sub Category</option');
        }
      },
      error:function(e){
        console.log(e.responseText);
      }
    });
  }

  function getcategory(panel='add'){
    if(panel=='add'){
      var classId=$('.changeClasses').val();
      var subject=$('.changeSubjects').val();
      $('.changeParent').empty().append('<option value="">Select Parent Category</option>');
    }else{
      var classId=$('.editClass').val();
      var subject=$('.editSubject').val();
      $('.editParentCategory').empty().append('<option value="">Select Parent Category</option>');
    }
     if(classId!='' && subject!=''){
      $.ajax({
        type:'POST',
        data: {classId,subject},
        dataType:'JSON',
        url: '{{URL::action('TestController@getclasscategory')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          var category=data.category;

          var options='<option value="">Select Parent Category</option>';
          $.each(category,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['category_name']+'</option>';
          });
          if(panel=='add'){
            $('.changeParent').empty().append(options);
            $('#changeSubCat').empty().append('<option value="">Select Sub Category</option');
          }else{
            $('.editParentCategory').empty().append(options);
            $('#courseEditSubCate').empty().append('<option value="">Select Sub Category</option');
          }
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
    }
  }

  function getsubcategory(panel='add'){
    if(panel=='add'){
      var val=$('.changeParent').val();
    }else{
      var val=$('.editParentCategory').val();
    }
      $.ajax({
        type:'POST',
        data: {val},
        dataType:'JSON',
        url: '{{URL::action('TestController@getcategorysub')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          var subcategory=data.subcategory;
          var options='<option value="">Select Sub Category</option>';
          $.each(subcategory,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
          });

          if(panel=='add'){
            $('.changeSubCat').empty().append(options);
          }else{
            $('#courseEditSubCate').empty().append(options);
          }
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
  }

  $(document).on('change','.changeParent',function(){
      getsubcategory(panel='add');
    });

  $(document).on('change','.editParentCategory',function(){
      getsubcategory(panel='edit');
    });

  $(document).on('change','.changeClasses',function(){
      getsubjects(panel='add');
    });

  $(document).on('change','.changeSubjects',function(){
      getcategory(panel='add');
    });

  $(document).on('change','.editClass',function(){
      getsubjects(panel='edit');
    });

  $(document).on('change','.editSubject',function(){
      getcategory(panel='edit');
    });
  </script>
  @stop

