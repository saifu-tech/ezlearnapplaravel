<?php $__env->startSection('pageTitle'); ?>
Daily Tasks Tracker Status
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li><a href="javascript:void(o)">Daily Tasks Tracker Status</a></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('maincontent'); ?>
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
										<option ng-repeat = "(k,v) in taskNameChange" value='{{ k }}'>{{ v }}</option>
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
								<p style="color: red;">{{ errordate }}</p>
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
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $index }}"><b>{{ tasktemp.dateFormat }}</b></a>
							</h4>
						</div>
						<div id="collapse{{ $index }}" ng-class="{'in':$index == 0}"  class="panel-collapse collapse">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Students</th>
												<th ng-repeat="opt in form.option">{{ opt }}</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="(key, ta) in tasktemp.result">
												<td ng-show="tasktemp.result[key].alternative == ''">{{ tasktemp.result[key].name }}</td>
												<td ng-show="tasktemp.result[key].alternative != ''">{{ tasktemp.result[key].alternative }}</td>
												<td ng-repeat="(optkey, optval) in form.option" style="background-color: {{ tasktemp.result[key].bgcolor[optkey] }};color: {{ tasktemp.result[key].textcolor[optkey] }};">
													<input type="text" style="background-color: {{ tasktemp.result[key].bgcolor[optkey] }};color: {{ tasktemp.result[key].textcolor[optkey] }};" name="" ng-model="tasktemp.result[key][optkey]" value="{{ tasktemp.result[key][optkey] }}" ng-disabled="form.loginstudentId != key" ng-change="updatecolour(tasktempkey,key,optkey)">
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
					<p style="color: red;">{{ messagedate }}</p>
				</div>
			</div><br>
			<div class="row">
				<div class="col-md-6">
					<p style="color: red;">{{ statuserror }}</p>
				</div>
			</div>
			<div class="well">
				<button class="btn btn-success" ng-click="saveData()">Save</button>
				<?php /* <button class="btn btn-primary"   ng-click="reportdata()">click here so see report</button> */ ?>
			</div>
			<div class="col-md-10">
				<div class="position" data-placement="bottom-right">
					<div class=" alert alert-success" ng-show="successMessagebool " role="alert" >
						<button class="close" data-dismiss="alert"></button>
						<strong>{{successMessage }}</strong>
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
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $index }}"><b>{{ task.date }}
								</b></a>
							</h4>
						</div>
						<div id="collapse{{ $index }}" ng-class="{'in':$index == 0}"  class="panel-collapse collapse">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered" >
										<thead>
											<tr>
												<th>Students</th>
												<th ng-repeat="opt in form.optionscolour">{{ opt }}  </th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="(key, ta) in task.result track by $index">
												<?php /* <td ng-show="!task.result[key].alternative == '' ">{{ task.result[key].alternative }}</td> */ ?>
											<?php /* 	<td ng-show="!task.result[key].alternative == '' ">{{ task.result[key].name }}</td> */ ?>
												<td ng-repeat="(optkey, optval) in form.optionscolour" style="background-color:{{ task.result[key].colours[optkey] }};color:black">
													{{ task.result[key][optkey] }} 
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom-footer-scripts'); ?>
<?php echo e(HTML::script('js/datatables/datatables.min.js')); ?>

<?php echo e(HTML::script('js/bootbox/bootbox.min.js')); ?>

<?php echo e(HTML::script('js/moment/moment.min.js')); ?>

<?php echo e(HTML::script('js/date-range-picker/daterangepicker.js')); ?>

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
	$scope.taskname = <?php echo json_encode($taskname); ?>;
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
	$http.post('/admin/tracker/taskname',{data:$scope.form.selecttask}).then(function success(e){
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

		$http.post('/admin/tracker/report/post',{data}).then(function success(e){
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
	console.log(index);
	console.log(key);
	console.log(optkey);
	//console.log($scope.form.taskdetails[index].result[key].changed[optkey]);
	$scope.form.taskdetails[index].result[key].changed[optkey] ='yes';
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
	$http.post('/admin/tracker/report/save/post',{data}).then(function success(e){
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>