@extends('master')

@section('pageTitle')
Daily Tasks Tracker Report
@stop

@section('custom-header-scripts')
<style type="text/css">
	.label-yellow {
	    background-color: #ffea00;
	}
	.label-red {
	    background-color: #ff0000;
	}
	.label-green {
	    background-color: #00b100;
	}
	.label {
	    font-weight: 400;
	    letter-spacing: 0em;
	    padding: 0 1px;
	    width: 35px;
	    height: 15px;
	    border-radius: 0;
	}
	.label:empty {
		display: block;
	}
</style>
@stop
@section('breadcrumb')
  <li><a href="javascript:void(o)">Daily Tasks Tracker Report</a></li>
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
											<label>Task Type <span style="color:red;">*</span></label>
											<select ng-model="form.selecttask" ng-click="taskName()"> 
												 <option value="" selected="selected">select</option>
						                        <option value="daily">Daily Task</option>
						                        <option value="monthly">Monthly Task</option>
						                        <option value="weekly">Weekly Task</option>
						                    </select>
										</div>
									</div>

									<div class="col-sm-4 col-md-3 col-lg-2">
										<div class="form-group">
											<label>Task Name <span style="color:red;">*</span></label>
											<select ng-model="form.taskname" ng-change="optionName()">
						                        <option value="" selected="selected">select</option>
						                       	<option ng-repeat = "(k,v) in taskNameChange" value='@{{ k }}'>@{{ v }}</option>
						                    </select>
										</div>
									</div>

									<div class="col-sm-4 col-md-3 col-lg-2">
										<div class="form-group">
											<label>Options <span style="color:red;">*</span></label>
											<select ng-model="form.option" placeholder="Select Group" multiple="multiple">
						                       	<option ng-repeat = "(k,v) in options" value='@{{ v }}'>@{{ k }}</option>
						                    </select>
										</div>
									</div>

									<div class="col-sm-4 col-md-3 col-lg-2">
										<div class="form-group">
											<label>Start Date <span style="color:red;">*</span></label>
											<input type="text" class="form-control startDate" ng-model="form.startDate">
										</div>
									</div>

									<div class="col-sm-4 col-md-3 col-lg-2">
										<div class="form-group">
											<label>End Date <span style="color:red;">*</span></label>
											<input type="text" class="form-control endDate" ng-model="form.endDate">
										</div>
									</div>
								</div>
								<div class="row">
										<div class="col-md-6">
											<p style="color:red;">@{{ errormessage }}</p>
											
										</div>
									</div>
								<div class="row">
									<div class="col-md-2">
										<button class="btn btn-success" ng-click="searchData()">Search</button>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" ng-if="displayTable">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
					<div class="panel panel-default">
						<div class="panel-heading">
			                <h4 class="panel-title">
			                    <a href="javascript:void(0)" class="ng-binding"><b>@{{tableTitle}}</b></a>
			                </h4>
			            </div>
						<table class="table table-bordered" >
						<thead>
							<tr>
								<th>Date</th>
								<th>Options</th>
								<th>Standard Value</th>
								<th>Actual Value</th>
								<th>Variance</th>
								<th>Percentage</th>
								<th>Color</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="result in results">
								<td>@{{result.date}}</td>
								<td>@{{result.option}}</td>
								<td>@{{result.standard}}</td>
								<td>@{{result.actual}}</td>
								<td>@{{result.variance}}</td>
								<td>@{{result.percentage}}</td>
								<td><span class="label @{{result.color}}"></span></td>
							</tr>
						</tbody>
						</table>
					</div>
				</div>
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

    	$scope.form.option = [];
    	$scope.taskNameChange = '';
    	$scope.options = '';

    	$scope.displayTable = false;
    	$scope.tableTitle = '';
    	$scope.results = [];

    	$scope.taskName = function(){
    		var data = $scope.form.selecttask;
    		console.log(data);
    		$http.post('/admin/tracker/taskname',{data:$scope.form.selecttask}).then(function success(e){
    			console.log(e);
    			$scope.taskNameChange = e.data.data;

    		});
    	}

    	$scope.searchData = function(){
    		console.log($scope.form.selecttask);
    		$scope.displayTable = false;
            var data = $scope.form ;
            console.log(data);
            if($scope.form.selecttask != null && $scope.form.taskname != null && $scope.form.option != null && $scope.form.startDate != null && $scope.form.endDate != null){
	          	$http.post('/admin/tracker/student/report/post',{data}).then(function success(e){
	            	console.log(e.data);
	            	if(e.data.status == 'success'){
	            		var data = e.data;
	            		$scope.tableTitle = data.title;
	            		$scope.results = data.results;
	            		if(data.results.length > 0){
	            			$scope.displayTable = true;
	            		}
	            	}
	            	else{
	            		alert(e.data.message);
	            	}
	            	$scope.errormessage = '';
	            },
	                function error(error){
	                    console.log(error);
	                })
          	}else{

          		$scope.errormessage = 'please select mandatory fields';

          	}
        }

            
        $scope.optionName = function(){
    		var data = $scope.form.options;
    		var task =  $scope.form.selecttask;
    		console.log(data);
    		console.log(task);
    		$http.post('/admin/tracker/optionName',{data:$scope.form.taskname}).then(function success(e){
    			console.log(e);
    			$scope.options = e.data;
    			console.log($scope.options);
    		});
    	}

        $scope.saveData = function(){
            var data = $scope.form ;

          	$http.post('/admin/tracker/report/save/post',{data}).then(function success(e){
            	console.log(e);
                	},
                function error(error){
                    console.log(error);
                })
            }       
    });
</script>
@stop