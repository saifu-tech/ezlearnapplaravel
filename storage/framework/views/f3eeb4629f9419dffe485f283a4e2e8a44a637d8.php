<?php $__env->startSection('pageTitle'); ?>
Daily Tasks Option Master ADD
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li><a href="javascript:void(o)">Daily Tasks Option Master ADD</a></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('maincontent'); ?>
<div ng-app="ezTrackStd" ng-controller="ezTrackStdCntrl" class="container-fluid">
    <div class="well">
        <form ng-submit="editData()">
            <div class="row">
                <div class="col-md-4">
                    <label>Add Name</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="groupname" ng-model="form.value">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Add Type</label>
                </div>
                <div class="form-group col-md-6">
                     <select ng-model="form.type" >
                        <option selected ="revenue" value="revenue">revenue</option>
                        <option value="cost">cost</option>
                        <option value="alpha">alpha</option>
                    </select>
                </div>
                <div class="row">
                <div class="col-md-4"></div>
                <div class="form-group col-md-6">
                    <button class="btn btn-primary"  ng-click="addOption()">Save</button>
                </div>
            </div>
            <div cl
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom-footer-scripts'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script type="text/javascript">
var app = angular.module('ezTrackStd', []);
app.controller('ezTrackStdCntrl', function($scope,$http,$timeout) {

    console.log('1');

        $scope.addOption= function(){
    	var data = $scope.form;
	    $http.post('/admin/optiontypeadddata',{data}).then(function success(e){
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>