@extends('master')

@section('pageTitle')
Colors
@stop

@section('breadcrumb')
  <li><a href="javascript:void(o)">Colors</a></li>
@stop

@section('maincontent')
	<div ng-app="ezTrack" ng-controller="ezColorCntrl" class="container-default">
		<div class="well">
			<form ng-submit="addColor()">
				<div class="row" ng-repeat="col in form.colorList track by $index">
					<div class="col-md-10">
						<div class="input-group input-group-lg">
						  	<span class="input-group-addon" id="sizing-addon1">Color</span>
						  	<input type="text" ng-model="col.color_key" class="form-control" placeholder="Color Key" aria-describedby="sizing-addon1">
						  	<input type="text" ng-model="col.color_value" class="form-control" placeholder="Color value" aria-describedby="sizing-addon1">
						</div>
						<div class="col-md-2">
	                        <a href="javascript:void(0)"  ng-click="colorOption($index)" ng-show="$last" class="addOption"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
	                        <a href="javascript:void(0)" class="removeOption" ng-click="removeColor($index)" ng-show="$index != 0"  ><i class="fa fa-times-circle" aria-hidden="true"></i></a>
	                    </div>
					</div>
				</div>
				<div class="row">
	                <div class="col-md-4"></div>
	                <div class="form-group col-md-6">
	                    <input type="submit" name="" value="Save">
	                </div>
            	</div>
			</form>
		</div>
	</div>
@stop

@section('custom-footer-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>	
<script type="text/javascript">
	var app = angular.module('ezTrack', []);
    app.controller('ezColorCntrl', function($scope,$http,$timeout) {
    	$scope.form = {} ;
    	$scope.options = '';



    	$scope.form.colorList = [{
            color_key: '',
            color_value: ''
        }];

        $scope.colorOption = function() {
            var options = {};
                $scope.form.colorList.push({
                color_key: '',
                color_value: ''
            });
        }

        $scope.removeColor = function(index){
        	$scope.form.colorList.splice(index,1);
        }

        $scope.addColor = function(){
        	console.log($scope.form);
        	var data = $scope.form;
        	$http.post('/admin/tracker/addColorValue',{data}).then(function success(e){
                    console.log(e);
                    // if(e.message = true){
                    //     $scope.successMessage = "Task Created Successfully";
                    //     $scope.successMessagebool = true;
                    //     $timeout(function () {
                    //     $scope.successMessagebool = false;
                    //         }, 2000);
                    //   //  $scope.form = '';
                    // }
                        },
                        function error(error){
                            console.log(error);
                        })
        }

    });
</script>
@stop