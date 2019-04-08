<?php
use App\Subcategory;
use App\Subjects;
use App\Category;
use App\Options;
use App\Privilege;
$lable1=Options::getvalue('lable1');
$lable2=Options::getvalue('lable2');
?>
@extends('master')

@section('pageTitle')
Category
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Masters</a></li>
  <li><a href="javascript:void(o)">Category</a></li>
@stop

<style type="text/css">
  #example0 th{
    cursor: pointer;
  }
</style>
@section('maincontent')

 <!-- START CONTAINER -->
<div class="container-default" ng-app="categoryFilter" ng-controller="categoryController">

 <div aria-label="..." role="group" class="btn-group">
   @if(Privilege::getprivilegestatus(3,Auth::user()->id,'addStatus')=='yes')
      <a href="javascript:void(0)" class="btn btn-light btn-sm addJob"><i class="fa fa-plus"></i>Add</a>
    @endif
    @if(Privilege::getprivilegestatus(3,Auth::user()->id,'deleteStatus')=='yes')
      <a class="btn btn-light btn-sm deleteButton" type="button"><i class="fa fa-trash"></i>Delete</a>
    @endif
      </div>

<div class="row add_row"  style="display: none">
  <div class="col-md-12 col-lg-12">
      <div class="panel panel-default">

        <div class="panel-title">
          Add Category
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
          </ul>
        </div>

            <div class="panel-body">
              {{Form::open(['url'=>'admin/masters/category/add/post'])}}
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

                  <div class="form-group">
                    {{Form::label('categoryType','Category Type *',['class'=>'form-label'])}}
                    {{Form::select('categoryType',[1=>'Parent Category',2=>'Sub Category'],1,['class'=>'form-control categoryType'])}}
                    @if ($errors->add->has('categoryType')) 
                      <div class="validation-error errorActive asterisk">
                          {{ $errors->add->first('categoryType') }}
                      </div> 
                    @endif
                  </div>

                <div class="form-group subdiv">
                    {{Form::label('parentCategory','Parent Category *',['class'=>'form-label'])}}
                    {{Form::select('parentCategory',[''=>'Select Parent Category'],'',['class'=>'form-control changeParent'])}}
                    @if ($errors->add->has('parentCategory')) 
                      <div class="validation-error errorActive asterisk">
                          {{ $errors->add->first('parentCategory') }}
                      </div> 
                  @endif
                </div>
                <?php
                $parentCode=Category::autogeneratecode();
                $subCode=Subcategory::autogeneratecode();
                ?>

                <div class="form-group">
                    {{Form::label('categoryCode','Category Code *',['class'=>'form-label'])}}
                    {{Form::text('categoryCode',$parentCode,['class'=>'form-control categoryCode'])}}
                    @if ($errors->add->has('categoryCode')) 
                      <div class="validation-error errorActive asterisk">
                          {{ $errors->add->first('categoryCode') }}
                      </div> 
                  @endif
                </div>

                <div class="form-group">
                  	{{Form::label('categoryName','Category Name *',['class'=>'form-label'])}}
                  	{{Form::text('categoryName','',['class'=>'form-control'])}}
                  	@if ($errors->add->has('categoryName')) 
                    	<div class="validation-error errorActive asterisk">
                       		{{ $errors->add->first('categoryName') }}
                   		</div> 
                 	@endif
                </div>

                <div class="form-group">
                  	{{Form::label('description','Description',['class'=>'form-label'])}}
                  	{{Form::textarea('description','',['class'=>'form-control','rows'=>5])}}
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
                Edit Category
                <ul class="panel-tools">
                  <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                  <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
                  <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                </ul>
              </div>

              <div class="panel-body">
                {{Form::open(['url'=>'admin/masters/category/edit/post'])}}
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
                    {{Form::select('subject',[],'',['class'=>'form-control editSubject','placeholder'=>'Select '.$lable2])}}
                    @if ($errors->edit->has('subject')) 
                      <div class="validation-error errorActive asterisk">
                          The {{$lable2}} field is required.
                      </div> 
                    @endif
                  </div>

                <div class="form-group">
                    {{Form::label('catType','Category Type *',['class'=>'form-label'])}}
                    {{Form::select('catType',[1=>'Parent Category',2=>'Sub Category'],1,['class'=>'form-control editCategoryType'])}}
                    @if ($errors->edit->has('catType')) 
                      <div class="validation-error errorActive asterisk">
                          {{ $errors->edit->first('catType') }}
                      </div> 
                  @endif
                </div>
                {{Form::hidden('categoryType','',['class'=>'hiddentType'])}}

                  

                

                <div class="form-group subdiv">
                    {{Form::label('parentCategory','Select Parent Category *',['class'=>'form-label'])}}
                    {{Form::select('parentCategory',[''=>'Select Parent Category'],'',['class'=>'form-control editParentCategory'])}}
                    @if ($errors->edit->has('parentCategory')) 
                      <div class="validation-error errorActive asterisk">
                          {{ $errors->edit->first('parentCategory') }}
                      </div> 
                  @endif
                </div>

                <div class="form-group">
                  	{{Form::label('categoryCode','Category Code *',['class'=>'form-label'])}}
                  	{{Form::text('categoryCode','',['class'=>'form-control editCategoryCode'])}}
                  	@if ($errors->edit->has('categoryCode')) 
                    	<div class="validation-error errorActive asterisk">
                       		{{ $errors->edit->first('categoryCode') }}
                   		</div> 
                 	@endif
                </div>

                <div class="form-group">
                    {{Form::label('categoryName','Category Name *',['class'=>'form-label'])}}
                    {{Form::text('categoryName','',['class'=>'form-control editCategoryName'])}}
                    @if ($errors->edit->has('categoryName')) 
                      <div class="validation-error errorActive asterisk">
                          {{ $errors->edit->first('categoryName') }}
                      </div> 
                  @endif
                </div>


                <div class="form-group">
                  	{{Form::label('description','Description',['class'=>'form-label'])}}
                  	{{Form::textarea('description','',['class'=>'form-control editDescription','rows'=>5])}}
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
          List of Category
        </div>
        <div class="panel-body table-responsive">

          <div class="kode-alert kode-alert-icon alert6-light errorMessage" style="display:none;">
            <i class="fa fa-lock"></i>
            <a href="#" class="closed">×</a>
            <span></span>
          </div>

        <div id="accordion" role="tablist" aria-multiselectable="true" style="display:none;">
          	@foreach($records as $record)
			  	<div class="panel panel-default">
			    	<div class="panel-heading" role="tab" id="headingOne">
			      		<h4 class="panel-title">
			        		<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			          			{{$record->category_name}}
			        		</a>
			      		</h4>
			    	</div>
			    	<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			    	<?php 
                    $subcategories=Subcategory::where('status','!=','deleted')->where('parent',$record->id)->get();
                    ?>
                    <ul>
                    @foreach($subcategories as $sub)
			      			<li>{{$sub->name}}</li>
			      	@endforeach
			      	</ul>
			    	</div>
			  	</div>
			@endforeach
		</div>
    <div style="float: left;"><b>Shows</b> &nbsp;&nbsp;<select ng-model="recordLimit" ng-init="recordLimit=10" ng-options="item for item in recordArray">
    </select></div>
    <div style="float: right;"><b>Search</b> &nbsp;&nbsp;<input type="text" ng-model="filterSearch"></div>
            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th ng-click="sort('s_no')">S.No &nbsp;<span class="glyphicon sort-icon" ng-show="sortKey=='s_no'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                        <th ng-click="sort('code')">Code &nbsp;<span class="glyphicon sort-icon" ng-show="sortKey=='code'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                        <th ng-click="sort('name')">Name &nbsp;<span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                        <th ng-click="sort('subject')">{{$lable2}} &nbsp;<span class="glyphicon sort-icon" ng-show="sortKey=='subject'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                        <th ng-click="sort('class')">{{$lable1}} &nbsp;<span class="glyphicon sort-icon" ng-show="sortKey=='class'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                        @if(Privilege::getprivilegestatus(3,Auth::user()->id,'editStatus')=='yes')
                        <th>Edit</th>
                        @endif
                        @if(Privilege::getprivilegestatus(3,Auth::user()->id,'deleteStatus')=='yes')
                        <th><i class="fa fa-trash"></i></th>
                        @endif
                    </tr>
                </thead>
             
                <tbody>
                  <tr dir-paginate="rec in records |orderBy:sortKey:reverse | filter: filterSearch|itemsPerPage:recordLimit">
                     <td>@{{rec.sno}}</td>
                     <td>@{{rec.code}}</td>
                     <td>@{{rec.name}}</td>
                     <td>@{{rec.subject}}</td>
                     <td>@{{rec.class}}</td>
                     @if(Privilege::getprivilegestatus(3,Auth::user()->id,'editStatus')=='yes')
                     <td><a href="javascript:void(0)" class="edit" editId="@{{rec.id}}" data-type='main'><i class="fa fa-pencil-square-o"></i></a></td>
                     @endif
                        @if(Privilege::getprivilegestatus(3,Auth::user()->id,'deleteStatus')=='yes')
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
  {{HTML::script('js/datatables/datatables.min.js')}}
  {{HTML::script('js/bootbox/bootbox.min.js')}}
  {{HTML::script('js/angular.min.js')}}
  {{HTML::script('js/dirPagination.js')}}
  {{HTML::script('js/categoryfilter.js')}}
  <script>
  $(document).ready(function() {
      // $('#example0').DataTable();
      var classes=$('.changeClasses').val();
      if(classes!=''){
        var oldSubject='{{old("subject")}}';
        getsubjects(panel='add');
      }
  });

  $(document).on('change','#categoryType,.editCategoryType',function(){
  		var type=$(this).val();
  		if(type==1){
  			$('.subdiv').hide();
        $('.classdiv').show();
  		}else{
  			$('.subdiv').show();
        $('.classdiv').hide();
  		}
  		return false;
  });

  $(document).on('change','.add_row .categoryType',function(){
    var type=$('.categoryType').val();
    if(type==1){
      var code='{{$parentCode}}';
    }else{
      var code='{{$subCode}}';
    }
    $('.categoryCode').val(code);
    return false;
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
    var records=[];
    $('.selectRecords:checked').each(function(){
      var id=$(this).attr('data-record');
      var type=$(this).attr('data-type');
      var details={id:id,type:type};
      records.push(details);
    });
    records=JSON.stringify(records);
     $.ajax({
        type: 'POST',
       url: '{{URL::action('TestController@deletecategorypost')}}',
       data: {records:records},
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
    var type=$(this).attr('data-type');
    $.ajax({
      type:'POST',
      data: {editId:editId,type:type},
      dataType:'JSON',
      url: '{{URL::action('TestController@getcategorypost')}}',
      headers: { 'X-XSRF-Token': $('meta[name="_token"]').attr('content'), },
      success:function(data){
        console.log(data);
        if(data.status=='success'){

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

          $('.editCategoryName').val(data.name);
          $('.editCategoryCode').val(data.code);
          $('.editCategoryType').val(data.type);
          $('.hiddentType').val(data.type);
          $('.editParentCategory').val(data.parent);
          $('.editClass').val(data.class);
          $('.editSubject').val(data.subject);
          $('.editDescription').val(data.description);
          $('.editRowId').val(editId);
          $('.edit_row').show('slow');
          if(type=='main'){
        		$('.subdiv').hide();
            $('.classdiv').show();
        	}else{
        		$('.subdiv').show();
            $('.classdiv').hide();
        	}
        $('.editCategoryType').attr('disabled',true);
        }
      },
      error:function(e){
        console.log(e.responseText);
      }
    });
    
  });

  $(document).on('click','.addJob',function(){
  		$('.subdiv').hide();
      $('.classdiv').show();
      $('.add_row:input').val('');
      $('.edit_row').hide('slow');
      $('.successMessage').hide('slow');
      $('.errorMessage').hide('slow');
      // $('.add_row input[type="text"]').val('');
       $('.add_row').show('slow');
  });

   @if(Session::has('categoryerror'))
    var value= "{{Session::get('categoryerror')}}";
    $('.'+value).show('slow');
    $('.subdiv').hide();
    $('.classdiv').show();
    if(value=='edit_row'){
      var type=$('.editCategoryType').val();
      if(type==2){
        $('.edit_row').find('.classdiv').hide();
        $('.edit_row').find('.subdiv').show();
      }else{
        $('.edit_row').find('.classdiv').show();
        $('.edit_row').find('.subdiv').hide();
      }
      $('.editCategoryType').attr('disabled',true);
    }else{
      var type=$('.categoryType').val();
      if(type==2){
        $('.add_row').find('.classdiv').hide();
        $('.add_row').find('.subdiv').show();
      }else{
        $('.add_row').find('.classdiv').show();
        $('.add_row').find('.subdiv').hide();
      }
    }
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
        }else{
          $('.editSubject').empty().append(options);
          $('.editParentCategory').empty().append('<option value="">Select Parent Category</option>');
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
          }else{
            $('.editParentCategory').empty().append(options);
          }
        },
        error:function(e){
          console.log(e.responseText);
        }
      });
    }
  }

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

