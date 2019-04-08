<?php
use App\Group;
use App\Classname;
use App\Subjects;
use App\Category;
use App\Subcategory;
use App\Courses;
use App\Options;
$lable1=Options::getvalue('lable1');
$lable2=Options::getvalue('lable2');
?>
@extends('master')

@section('pageTitle')
Library
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Library</a></li>
@stop

@section('maincontent')




 <!-- START CONTAINER -->
<div class="container-default">

 <div aria-label="..." role="group" class="btn-group">
        <a href="javascript:void(0)" class="btn btn-light btn-sm addJob"  style="display: none"><i class="fa fa-plus"></i>Add</a>
        <a class="btn btn-light btn-sm deleteButton" type="button"><i class="fa fa-trash"></i>Delete</a>
      </div>

<div class="row">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Add Files
        </div>

            <div class="panel-body">
              {{Form::open(['url'=>'admin/library/add/post','files'=>true, 'class'=>'form-horizontal'])}}
              @if(Session::has('success')) {!! HTML::display_success('success') !!} @endif
              @if(Session::has('failed')) 
              <div class="kode-alert kode-alert-icon alert6-light">
                <i class="fa fa-lock"></i>
                <a href="javascript:void(0)" class="closed">×</a>
                {{Session::get('failed')}}
              </div>
              @endif

              <div class="form-group">
                  {{Form::label('class',$lable1.' *',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('class',$classes,'',['class'=>'form-control className','placeholder'=>'Select '.$lable1])}}
                  @if ($errors->add->has('class')) 
                    <div class="validation-error errorActive asterisk">
                       The {{$lable1}} field is required.
                   </div> 
                 @endif
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('subject',$lable2,['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('subject',$subjects,'',['class'=>'form-control subjectName','placeholder'=>'Select '.$lable2])}}
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('category','Category',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('category',[''=>'Select Category'],'',['class'=>'form-control categoryName'])}}
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('subCategory','Sub Category',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('subCategory',[''=>'Select Sub Category'],'',['class'=>'form-control subcategoryName'])}}
                 </div>
                </div>

                <div class="form-group">
                  {{Form::label('course','Course',['class'=>'col-sm-2 control-label'])}}
                  <div class="col-sm-8">
                  {{Form::select('course',[''=>'Select Course'],'',['class'=>'form-control courseName'])}}
                 </div>
                </div>


              <div class="form-group">
                {{Form::label('libraryFile','Select Files *',['class'=>'col-sm-2 control-label'])}}
                <div class="col-sm-8">
                {{Form::file('libraryFile[]',['class'=>'form-control','multiple'=>'multiple'])}}
                @if ($errors->add->has('libraryFile')) 
                  <div class="validation-error errorActive asterisk">
                     {{ $errors->add->first('libraryFile') }}
                 </div> 
                @endif
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


<div class="row manage_row" id="">
    <!-- Start Panel -->
    <div class="col-md-12">

      <div class="panel panel-default">
        <div class="panel-title">
          List of Library Files
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
                        <th>File Name</th>
                        <th>File Structure</th>
                        <th>View File</th>
                        <th><i class="fa fa-trash"></i></th>
                    </tr>
                </thead>
             
                <tbody>
                  <?php $i=0; ?>
                  @foreach($records as $record)
                    <tr datarow={{$record->id}}>
                      <td>{{++$i}}</td>
                      <td>{{$record->name}}</td>
                      <td>
                      <ol class="breadcrumb">
                          <li>{{Classname::getclssname($record->classes)}}</li>
                          @if($record->subject!=NULL)
                            <li>{{Subjects::getsubjectname($record->subject)}}</li>
                          @endif
                          @if($record->category!=NULL)
                            <li>{{Category::getcategoryname($record->category)}}</li>
                          @endif
                          @if($record->subCategory!=NULL)
                            <li>{{Subcategory::getsubcategoryname($record->subCategory)}}</li>
                          @endif
                          @if($record->course!=NULL)
                            <li>{{Courses::getcoursename($record->course)}}</li>
                          @endif
                      </ol>
                      </td>
                      <td><a href="{{$record->fileLink}}" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
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
       url: '{{URL::action('TestController@deletelibrarypost')}}',
       data: {ids:ids},
       dataType: 'json',
       headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
       success: function(data){
          console.log(data);
          $('.selectRecords:checked').closest('tr').remove();
          $('.errorMessage span').html('Selected files deleted successfull.');
          $('.errorMessage').show('slow');
      return false;
        },
        error: function(e){
          console.log(e.responseText);
        }
      });
    return false;
  });
  $(document).on('click','.addJob',function(){
      $('.edit_row').hide('slow');
      $('.successMessage').hide('slow');
      $('.errorMessage').hide('slow');
      // $('.add_row input[type="text"]').val('');
      $('.add_row').show('slow');
  });

  $(document).on('change','.className,.subjectName',function(){
      var classId=$('.className').val();
      var subject=$('.subjectName').val();
      $('.subcategoryName').empty().append('<option value="">Select Sub Category</option>');
      $('.courseName').empty().append('<option value="">Select Course</option>');
      $('.categoryName').empty().append('<option value="">Select Category</option>');
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
            var options='<option value="">Select Category</option>';
            $.each(category,function(index,ele){
              options+='<option value='+ele['id']+'>'+ele['category_name']+'</option>';
            });
            $('.categoryName').empty().append(options);
            $('.subcategoryName').empty().append('<option value="">Select Sub Category</option>');
            $('.courseName').empty().append('<option value="">Select Course</option>');
          },
          error:function(e){
            console.log(e.responseText);
          }
        });
      }
    });

  $(document).on('change','.categoryName',function(){
      var val=$(this).val();
      $.ajax({
        type:'POST',
        data: {val},
        dataType:'JSON',
        url: '{{URL::action('TestController@getcategorysub')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          var subcategory=data.subcategory;
          var options='<option>Select Sub Category</option>';
          $.each(subcategory,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
          });
          $('.subcategoryName').empty().append(options);
          $('.courseName').empty().append('<option>Select Course</option>');
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
    });

  $(document).on('change','.subcategoryName',function(){
      var sub=$(this).val();
      var classs=$('.className').val();
      var category=$('.categoryName').val();
      $.ajax({
        type:'POST',
        data: { sub:sub,class:classs,category:category},
        dataType:'JSON',
        url: '{{URL::action('TestController@getsubcategoryallcourses')}}',
        headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
        success:function(data){
          console.log(data);
          var courses=data.courses;
          var options='<option>Select Courses</option>';
          $.each(courses,function(index,ele){
            options+='<option value='+ele['id']+'>'+ele['name']+'</option>';
          });
          $('.courseName').empty().append(options);
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
    });
  </script>
  @stop

