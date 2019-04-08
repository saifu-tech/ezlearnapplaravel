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
		<form ng-submit="updatedata()">
            <div class="row">
                <div class="col-md-4">
                    <label>Select Template</label>
                </div>
                <div class="form-group col-md-6">
                    <select >
                        <option value="Select template" selected="selected">Select template</option>
                       <option ng-repeat = "(k,v) in templates" value='@{{ k }}'>@{{ v }}</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Task Type</label>
                </div>
                <div class="form-group col-md-6">
                    <select ng-model="formdata.tasktype"  ng-selected="string(formdata.tasktype)" >
                        <option value="daily">Daily Task</option>
                        <option value="monthly">Monthly Task</option>
                        <option value="weekly">Weekly Task</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Group Name</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="groupname" ng-model="formdata.groupName">
                </div>
                @if($errors->has('groupname')) 
                    <div class="validation-error errorActive asterisk">
                        {!! $errors->first('groupname') !!}
                    </div> 
                @endif
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Task Name</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="" ng-model="formdata.taskName">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Start Date</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control startDate" ng-model="formdata.startDate">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>End Date</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control endDate" ng-model="formdata.endDate">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Students</label>
                </div>
                <div class="form-group col-md-6">
                    <select ng-model="formdata.studentListdata" ng-selected="string(formdata.studentListdata)" ng-change="updateStudentSelection()" placeholder="Select" multiple="multiple" ng-options="k as v for (k,v) in students">
                        
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>saifu</label>
                </div>
                <div class="form-group col-md-6">
                    <label><input type="checkbox" value="">Option 1</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Options</label>
                </div>
                <div class="col-md-6" >
                    <div class="row" ng-repeat="op in formdata.getoption track by $index">
                        <div class="form-group col-md-10">
                            <input type="text" ng-model="op.optionName"  class="form-control">
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)"  ng-click="addOption($index)" ng-show="$last" class="addOption"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a href="javascript:void(0)" class="removeOption" ng-click="removeData($index)" ng-show="$index != 0"  ><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>    
            </div>
           
            <div class="row">
                <div class="col-md-4">
                    <label>&nbsp;</label>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Students</th>
                                <th ng-repeat="option in formdata.getoption track by $index">@{{ option.optionName }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="stud in formdata.studendatalist track by $index">
                                <td>@{{ stud.name }}</td>
                                <td ng-repeat="opti in formdata.getstatus track by $index" ng-if="stud.id==opti.studentId"><input type="text" name="" value="" ng-model="opti.value"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Select Days</label>
                </div>
                <div class="form-group col-md-1" ng-repeat="day in formdata.days">
                    <label><input type="checkbox" ng-model="day.selected" >@{{ day.day }}</label>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-md-4"></div>
                <div class="form-group col-md-6">
                    <label><input type="checkbox" name="">Mark this template</label>
                </div>
            </div> -->

            <div class="row">
                <div class="col-md-4"></div>
                <div class="form-group col-md-6">
                    <button class="btn btn-primary" ng-click="saveTask()">Save</button><button class="btn btn-success">Cancel</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" data-placement="bottom-right">
                <div class=" alert alert-success" ng-show="successMessagebool " role="alert" >
                    <button class="close" data-dismiss="alert"></button>
                    <strong>@{{successMessage }}</strong>
                </div>
                </div>
            </div>
        </form>
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

	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script>
    $('.endDate,.startDate').daterangepicker({
        singleDatePicker: true, 
        format: "DD-MM-YYYY"
    });


    var app = angular.module('ezTrack', []);
    app.controller('ezTrackCntrl', function($scope,$http,$timeout) {
        $scope.students = {!! json_encode($student) !!};
        console.log($scope.students)
        $scope.templates = {!! json_encode($templates) !!};
        $scope.formdata = {!! json_encode($data) !!};
        var formdata = {!! json_encode($data) !!};
        $scope.formdata.tasktype = formdata.tasktype;
        $scope.formdata.tasktype = String($scope.formdata.tasktype);
        console.log($scope.formdata.tasktype);
        console.log($scope.formdata);
        $scope.option = [];
        $scope.form = {};
        $scope.options = '';
        $scope.formdata.days = [
            {
                "day": "Monday",
                "dayNum": "1"
            },{
                "day": "Tuesday",
                "dayNum": "2"
            },{
                "day": "Wednesday",
                "dayNum": "3"
            },{
                "day": "Thursday",
                "dayNum": "4"
            },{
                "day": "Friday",
                "dayNum": "5"
            },{
                "day": "Saturday",
                "dayNum": "6"
            },{
                "day": "Sunday",
                "dayNum": "7"
            }
        ];
        $scope.formdata.studentListdata = [];
        $scope.formdata.studendatalist = [];
        for(var i = 0; i<$scope.formdata.getstudentdata.length;i++){
        		var dv = $scope.formdata.getstudentdata[i].studentId;
        	  $scope.formdata.studentListdata[i] = dv.toString();
        }
        console.log( $scope.formdata.studentListdata);

        $scope.formdata.optionsList = [{
            optionName: '',
            list: ''
        }];



        $scope.addOption = function() {
            var optionName = {};
                $scope.formdata.getoption.push({
                optionName: '',
            });

        }

        $scope.updateStudentSelection = function() {
            $scope.formdata.studendatalist = [];
            $scope.formdata.studentListdata.forEach(function(v, i) {
                $scope.formdata.studendatalist.push({id: v, name: $scope.students[v]});
            })

            console.log($scope.formdata.studendatalist)
        }

        $scope.updateStudentSelection();

        $scope.formdata.statusList = [{
            status: '',
            statusinput: ''
        }];

        $scope.removeData = function(index){
            var optionName = $scope.formdata.getoption[index].optionName;
            $scope.formdata.studendatalist.forEach(function(v, i) {
                delete v[optionName];
            })

            $scope.studendatalist = x;
            $scope.formdata.optionsList.splice(index,1);
        }
        $scope.dayChanged = function(e, day) {
            console.log(e);
            console.log(day);

        }

        $scope.addStatus = function() {
            $scope.formdata.statusList.push({
                status: '',
                statusinput: ''
            });
        }

        $scope.updatedata = function(){
            console.log($scope.formdata);
        }

        $http.get('/admin/daily/tasks/studentdata').then(function(f){
            $scope.modules = f.data.data;
            $scope.group = f.data.template;

            console.log($scope.modules);
            console.log($scope.group)


            },
            function(f){

            }
        );

        
        $scope.matricksdata =function(){
            console.log($scope.formdata.optionsList);
            console.log($scope.formdata.studentListdata);
        }

    });
</script>
@stop