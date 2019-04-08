@extends('master')

@section('pageTitle')
Daily Tasks Tracker Status
@stop

@section('breadcrumb')
<li><a href="javascript:void(o)">Daily Tasks Tracker Status</a></li>
@stop

@section('maincontent')
<div ng-app="ezTrackStd" ng-controller="ezTrackStdCntrl" class="container-fluid">
	<form>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-title">Filter</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-4 col-md-3 col-lg-2">
								<div class="form-group">
									<label>Task Type<span style="color:red;">*</span></label>
									<select ng-model="form.selecttask"  ng-click="taskName()">
										<option value="" selected="selected">select</option>
										<option  value="daily">Daily Task</option>
										<option value="monthly">Monthly Task</option>
										<option value="weekly">Weekly Task</option>
									</select>
								</div>
							</div>

							<div class="col-sm-4 col-md-3 col-lg-2">
								<div class="form-group">
									<label>Task Name <span style="color:red;">*</span></label>
									<select  ng-model="form.taskname"  placeholder="Select Group">
										<option value="" selected="selected">select</option>
										<option ng-repeat = "(k,v) in taskNameChange" value='@{{ k }}'>@{{ v }}</option>
									</select>
								</div>
							</div>

							<div class="col-sm-4 col-md-3 col-lg-2 hide">
								<div class="form-group">
									<label>Date <span style="color:red;">*</span></label>
									<input type="text"  class="form-control startDate" ng-model="form.startDate" >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<p style="color: red;">@{{ errordate }}</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<button class="btn btn-success"  ng-click="searchData()">Search</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="bs-example">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default"  ng-repeat = "(tasktempkey, tasktemp) in form.taskdetails track by $index">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse@{{ $index }}"><b>@{{ tasktemp.dateFormat }}</b></a>
							</h4>
						</div>
						<div id="collapse@{{ $index }}" ng-class="{'in':$index == 0}"  class="panel-collapse collapse">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Students</th>
												<th ng-repeat="opt in form.option">@{{ opt }}</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="(key, ta) in tasktemp.results">
												<td ng-show="ta.alternativename == ''">@{{ ta.name }}</td>
												<td ng-show="ta.alternativename != ''">@{{ ta.alternativename }}</td>
												<td ng-repeat="(optkey, optval) in ta.options">
													<input type="text" style="background-color: @{{ optval.bgcolor }};color: @{{ optval.textcolor }};" name="" ng-model="optval.opt" value="@{{ optval.opt }}" ng-disabled="form.loginstudentId != ta.studentId" ng-change="updatecolour(tasktempkey, key, optkey)">
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-6">
					<p style="color: red;">@{{ messagedate }}</p>
				</div>
			</div><br>
			<div class="row">
				<div class="col-md-6">
					<p style="color: red;">@{{ statuserror }}</p>
				</div>
			</div>
			<div class="well">
				<button class="btn btn-success" ng-click="saveData()">Save</button>
				{{-- <button class="btn btn-primary"   ng-click="reportdata()">click here so see report</button> --}}
			</div>
			<div class="col-md-10">
				<div class="position" data-placement="bottom-right">
					<div class=" alert alert-success" ng-show="successMessagebool " role="alert" >
						<button class="close" data-dismiss="alert"></button>
						<strong>@{{successMessage }}</strong>
					</div>
				</div> 
			</div>
		</div>
		<div class="row">
			<div class="bs-example">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default"  ng-repeat = "task in form.taskDetailscolour track by $index">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse@{{ $index }}"><b>@{{ task.date }}
								</b></a>
							</h4>
						</div>
						<div id="collapse@{{ $index }}" ng-class="{'in':$index == 0}"  class="panel-collapse collapse">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered" >
										<thead>
											<tr>
												<th>Students</th>
												<th ng-repeat="opt in form.optionscolour">@{{ opt }}  </th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="(key, ta) in task.result track by $index">
												{{-- <td ng-show="!task.result[key].alternative == '' ">@{{ task.result[key].alternative }}</td> --}}
											{{-- 	<td ng-show="!task.result[key].alternative == '' ">@{{ task.result[key].name }}</td> --}}
												<td ng-repeat="(optkey, optval) in form.optionscolour" style="background-color:@{{ task.result[key].colours[optkey] }};color:black">
													@{{ task.result[key][optkey] }} 
												</td>	
											</tr>
										</tbody>
									<table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br>
		</div>
	</form>	
</div>
@stop

@section('custom-footer-scripts')
{{HTML::script('js/datatables/datatables.min.js')}}
{{HTML::script('js/bootbox/bootbox.min.js')}}
{{HTML::script('js/moment/moment.min.js')}}
{{HTML::script('js/date-range-picker/daterangepicker.js')}}
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script type="text/javascript">
$('.endDate,.startDate').daterangepicker({
	singleDatePicker: true, 
	format: "DD-MM-YYYY"
});
function toggleIcon(e) {
	$(e.target)
	.prev('.panel-heading')
	.find(".more-less")
	.toggleClass('glyphicon-plus glyphicon-minus');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);
var app = angular.module('ezTrackStd', []);
app.controller('ezTrackStdCntrl', function($scope,$http,$timeout) {
	$scope.taskname = {!! json_encode($taskname) !!};
	console.log($scope.totalStatus);
	$scope.form = {} ;
// $scope.form.date = new Date();
// console.log($scope.form.date);

$scope.form.taskdetails = [];
$scope.form.selecteddates = [];
$scope.form.option = [];
$scope.form.disabled = true;
$scope.form.loginstudentId = '';
// $scope.form.date = '';
$scope.taskNameChange = '';

$scope.taskName = function(){
	var data = $scope.form.selecttask;
	console.log(data);
	$http.post('/admin/tracker/tasknames',{data:$scope.form.selecttask}).then(function success(e){
		console.log(e);
		$scope.taskNameChange = e.data.data;
	});
}

$scope.searchData = function(){
	$scope.form.taskdetails = [];
	console.log($scope.form.taskname);
	if($scope.form.taskname != null && $scope.form.selecttask != null){
		var data = $scope.form;
		console.log(data);

		$http.post('/admin/tracker/report/postdata',{data}).then(function success(e){
			if(e.data.status == 'failed'){
				console.log(e.data.msg);
				$scope.messagedate = e.data.msg;
				return false;
			}
			console.log(e.data);
			$scope.messagedate = '';
			// $scope.selectedDates = e.data.selectedDate;
			$scope.form.taskdetails = e.data.taskDetails;
			$scope.form.selecteddates = e.data.selecteddates;
			$scope.form.option = e.data.options;
			$scope.form.loginstudentId = e.data.loginstudentId;
			$scope.statuserror = e.data.statuserror;
			console.log($scope.form.taskdetails);
			console.log($scope.form.selecteddates);
			console.log($scope.form.option);

			$scope.errordate = '';
// $scope.status = e.data.totalStatus;
// console.log('totalstatus');
// console.log(e.data.totalStatus);
// $scope.tracker = e.data.trackerData;
// console.log('trackerData');
// console.log(e.data.trackerData);
},
function error(error){
	console.log(error);
});

	}
	else{
		$scope.errordate="please select mandatory flields ";
		return false;
	}


}
$scope.updatecolour = function(index,key,optkey){
	// console.log(index);
	// console.log(key);
	// console.log(optkey);
	//console.log($scope.form.taskdetails[index].results[key].options[optkey].changed);
	$scope.form.taskdetails[index].results[key].options[optkey].changed ='yes';

	console.log($scope.form.taskdetails);
}

$scope.reportdata = function(){

	console.log($scope.form.taskname);
	if($scope.form.taskname != null && $scope.form.selecttask != null){
		var data = $scope.form;
		console.log(data);

		$http.post('/admin/tracker/reportcolour/post',{data}).then(function success(e){
//console.log(e.data);
$scope.form.taskDetailscolour = e.data.taskDetailscolour;
$scope.form.selecteddates = e.data.selecteddates;
$scope.form.optionscolour = e.data.optionscolour;
$scope.form.loginstudentIdcolour = e.data.loginstudentIdcolour;
console.log($scope.form.taskDetailscolour);
// console.log($scope.form.selecteddates);
// console.log($scope.form.optionscolour);
$scope.errordate = '';
// $scope.status = e.data.totalStatus;
// console.log('totalstatus');
// console.log(e.data.totalStatus);
// $scope.tracker = e.data.trackerData;
// console.log('trackerData');
// console.log(e.data.trackerData);
},
function error(error){
	console.log(error);
});

	}
	else{
		$scope.errordate="please select mandatory flields ";
		return false;
	}


}
$scope.saveData = function(){
	var data = $scope.form ;
	console.log(data.taskdetails);
	$http.post('/admin/tracker/report/save/postdata',{data}).then(function success(e){
		console.log(e.data);
		if(e.data.status == 'success'){
			$scope.form.taskdetails = e.data.taskDetails;
			$scope.successMessage = "Tracker Updated Successfully";
			$scope.successMessagebool = true;

			$timeout(function () {
				$scope.successMessagebool = false;
			}, 3000);  
		}
	},
	function error(error){
		console.log(error);
	})
}       
});
</script>
@stop