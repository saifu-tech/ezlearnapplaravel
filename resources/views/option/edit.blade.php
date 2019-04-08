@extends('master')

@section('pageTitle')
Daily Tasks Option Edit
@stop

@section('breadcrumb')
<li><a href="javascript:void(o)">Daily Tasks Option Edit</a></li>
@stop

@section('maincontent')
<div ng-app="ezTrackStd" ng-controller="ezTrackStdCntrl" class="container-fluid">
    <div class="well">
        <form ng-submit="editData()">
            <div class="row">
                <div class="col-md-4">
                    <label>Edit Name</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="groupname" ng-model="form.value">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Edit Type</label>
                </div>
                <div class="form-group col-md-6">
                     <select ng-model="form.type" >
                        <option value="revenue">revenue</option>
                        <option value="cost">cost</option>
                        <option value="alpha">alpha</option>
                    </select>
                </div>
                <div class="row">
                <div class="col-md-4"></div>
                <div class="form-group col-md-6">
                    <button class="btn btn-primary"  ng-click="updateOption()">Save</button>
                </div>
            </div>
            <div cl
            </div>
        </form>
    </div>
</div>
@stop

@section('custom-footer-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.js"></script>
<script type="text/javascript">
var app = angular.module('ezTrackStd', []);
app.controller('ezTrackStdCntrl', function($scope,$http,$timeout) {
$scope.form = {};
$scope.form = {!!json_encode($query) !!};
    console.log($scope.form);

    $scope.updateOption= function(){
    	var data = $scope.form;
	    $http.post('/admin/optiontypeupdate',{data}).then(function success(e){
            console.log(e);
            if(e.message = true){
                $scope.successMessage = "Task Created Successfully";
                $scope.successMessagebool = true;
                $timeout(function () {
                    $scope.successMessagebool = false;
                }, 2000);
              //  $scope.form = '';
            }
        },
          function error(error){
            console.log(error);
        });
    }
});
</script>
@stop