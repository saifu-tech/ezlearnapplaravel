@extends('master')

@section('pageTitle')
Daily Tasks Option Master
@stop

@section('breadcrumb')
<li><a href="javascript:void(o)">Daily Tasks Option Master</a></li>
@stop

@section('maincontent')
<div ng-app="ezTrackStd" ng-controller="ezTrackStdCntrl" class="container-fluid">
	<div class="well">
		<div class="row">
			<div class="col-md-12">
				<a href="/admin/optiontypeadd"><span class="btn btn-sm btn-info pull-right" style="display: inline;">Add Option</span></a>
			</div>
		</div>
		<table class="table table-striped">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Status</th>
		      <th scope="col">Edit</th>
		      <th scope="col">Delete</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr ng-repeat="data in datas track by $index">
		      <th>@{{ $index+1 }}</th>
		      <td>@{{ data.value }}</td>
		      <td><span  ng-class="data.status=='active'? 'btn-primary btn btn-xs' : 'btn-danger btn btn-xs'" style="display: inline;" ng-click="optionstatus(data,$index)">@{{ data.status | uppercase }}</span></td>

		      <td><a href="/admin/optiontypeedit/@{{ data.id }}"><span class="btn btn-xs btn-info" style="display: inline;">Edit</span></a></td>
		      <td><a href="/admin/optiontypedelete/@{{ data.id }}"><span class="btn btn-xs btn-danger" style="display: inline;">Delete</span></a></td>
		    </tr>
		  </tbody>
		</table>
	</div>
</div>
@stop

@section('custom-footer-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.js"></script>
<script type="text/javascript">
var app = angular.module('ezTrackStd', []);
app.controller('ezTrackStdCntrl', function($scope,$http,$timeout) {
$scope.datas = {!!json_encode($query) !!};
    console.log($scope.datas);

    $scope.optionstatus = function(data,index){
    	bootbox.confirm({
            message: "Are You Sure Did You Want To Change The Status?",
            buttons: {
	            confirm: {
	                label: 'Yes',
	                className: 'btn-success'
	            },
	            cancel: {
	                label: 'No',
	                className: 'btn-danger'
	            }
        	},
	        callback: function (result) {
	          if(result){
		            $http.post('/admin/optiontypestatus',{id:data}).then(function success(e){
		              console.log(e.data.status);
		              	if(e.data.success){
			               if(data.status == 'active'){
			                   $scope.datas[index].status = 'inactive';
			               }else{
			                   $scope.datas[index].status = 'active';
			               }
			           	}
		       		});  
	        	}
	   		 }
		});

    }

});
</script>
@stop