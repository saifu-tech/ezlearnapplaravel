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
<div ng-app="ezTrack" ng-controller="ezTrackCntrl" class="container-default">
	<div class="well">
		<div style="float: left;"><b>Shows</b> &nbsp;&nbsp;<select ng-model="recordLimit"  ng-init="recordLimit=10" ng-options="item for item in recordArray">
	    </select></div>
	    <div style="float: right;"><b>Search</b> &nbsp;&nbsp;<input type="text" ng-model="filterSearch"></div>
	    <table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th ng-click="sort()" scope="col">S.no</th>
					<th ng-click="sort('groupName')" scope="col">Group Name</th>
					<th ng-click="sort('taskName')" scope="col">Task</th>
					<th ng-click="sort('groupName')" scope="col">Student</th>
					<th ng-click="sort('startDate')" scope="col">Start Date</th>
					<th ng-click="sort('endDate')" scope="col">End date</th>
					<th scope="col">Status</th>
					<th scope="col">Edit</th>
					<th scope="col">Delete</th>
				</tr>
			</thead>
			<tbody>
				<tr  dir-paginate="datas in data |orderBy:sortKey:reverse | filter: filterSearch|itemsPerPage:recordLimit  track by $index">
					<td>@{{ $index+1 }}</td>
					<td>@{{ datas.groupName }}</td>
					<td>@{{ datas.taskName }}</td>
					<td><span ng-repeat="name in studentdata[$index]">@{{ name }}</span></td>
					<td>@{{ datas.startDate }}</td>
					<td>@{{ datas.endDate }}</td>
					<td>@{{ datas.status }}</td>
					<td> <a href="/admin/tracker/edit/@{{ datas.id }}" class="btn btn-success"><i class="fa fa-cog" aria-hidden="true"></i> edit</a></td>
					<td><button class="btn btn-danger">Delete</button></td>
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
@stop

@section('custom-footer-scripts')
  	{{ HTML::script('js/datatables/datatables.min.js')}}
  	{{ HTML::script('js/bootbox/bootbox.min.js')}}
  	{{ HTML::script('js/moment/moment.min.js')}}
  	{{ HTML::script('js/date-range-picker/daterangepicker.js')}}
	{{ HTML::script('js/angular.min.js') }}
	{{ HTML::script('js/dirPagination.js') }}

	<script>
	  
		var data = {!! $records !!}
		
		console.log(data);
		var studentdata = {!! json_encode($data) !!};
		 studentdata.toString();
		console.log(studentdata);
		

	    var app = angular.module('ezTrack', ['angularUtils.directives.dirPagination']);
	    app.controller('ezTrackCntrl', function($scope,$http,$timeout) {
	       
	    	$scope.data = data;
	    	$scope.studentdata = studentdata;
	    	$scope.recordArray = [10, 25, 50, 100];
	    	console.log($scope.data);

	    	$scope.sort = function(keyname){
		        $scope.sortKey = keyname;   //set the sortKey to the param passed
		        $scope.reverse = !$scope.reverse; //if true make it false and vice versa
		    }
	    });
	</script>
@stop