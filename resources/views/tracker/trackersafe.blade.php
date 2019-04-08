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
        <form ng-submit="addData()">
            <div class="row">
                <div class="col-md-4">
                    <label>Select Template</label>
                </div>
                <div class="form-group col-md-6">
                    <select ng-model="form.selecttemplate" >
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
                    <select ng-model="form.selecttask" >
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
                    <input type="text" class="form-control" name="groupname" ng-model="form.groupname">
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
                    <input type="text" class="form-control" name="" ng-model="form.taskname">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Start Date</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control startDate" ng-model="form.startdate">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>End Date</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control endDate" ng-model="form.enddate">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Students</label>
                </div>
                <div class="form-group col-md-6">
                    <select ng-model="form.selectstudent" ng-change="updateStudentSelection()" placeholder="Select" multiple="multiple">
                        <option selected="selected">select</option>
                       <option ng-repeat = "(k,v) in students" value='@{{ k }}'>@{{ v }}</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Options</label>
                </div>
                <div class="col-md-6" >
                    <div class="row" ng-repeat="op in form.optionsList track by $index">
                        <div class="form-group col-md-10">
                            <input type="text" ng-model="op.options"  class="form-control">
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
                    <label>status</label>
                </div>
                <div class="col-md-4">
                  <button class="btn btn-sm btn-primary">Click here</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>&nbsp;</label>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered" ng-if="form.selectstudent && form.optionsList[0].options">
                        <thead>
                            <tr>
                                <th>Students</th>
                                <th ng-repeat="option in form.optionsList track by $index">@{{ option.options }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="stud in form.studentList track by $index">
                                <td>@{{ stud.name }}</td>
                                <td ng-repeat="option in form.optionsList track by $index"><input type="text" name="" value="" ng-model="stud[option.options]"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Select Days</label>
                </div>
                <div class="form-group col-md-1" ng-repeat="day in form.days">
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
  {{HTML::script('js/datatables/datatables.min.js')}}
  {{HTML::script('js/bootbox/bootbox.min.js')}}
  {{HTML::script('js/moment/moment.min.js')}}
  {{HTML::script('js/date-range-picker/daterangepicker.js')}}
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script>
    $('.endDate,.startDate').daterangepicker({
        singleDatePicker: true, 
        format: "DD-MM-YYYY"
    });


    var app = angular.module('ezTrack', []);
    app.controller('ezTrackCntrl', function($scope,$http,$timeout) {
        $scope.students = {!! json_encode($students) !!};
        console.log($scope.students)
        $scope.templates = {!! json_encode($templates) !!};
        $scope.option = [];
        $scope.form = {} ;
        $scope.options = '';
        $scope.form.days = [
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
        $scope.form.studentList = [];

        $scope.form.optionsList = [{
            options: '',
            list: ''
        }];

        $scope.addOption = function() {
            var options = {};
                $scope.form.optionsList.push({
                options: '',
                list: ''
            });

        }

        $scope.updateStudentSelection = function() {
            $scope.form.studentList = [];
            $scope.form.selectstudent.forEach(function(v, i) {
                $scope.form.studentList.push({id: v, name: $scope.students[v]});
            })

            console.log($scope.form.studentList)
        }

        $scope.form.statusList = [{
            status: '',
            statusinput: ''
        }];

        $scope.removeData = function(index){
            var optionName = $scope.form.optionsList[index].options;
            $scope.form.studentList.forEach(function(v, i) {
                delete v[optionName];
            })

            $scope.studentList = x;
            $scope.form.optionsList.splice(index,1);
        }
        $scope.dayChanged = function(e, day) {
            console.log(e);
            console.log(day);

        }

        $scope.addStatus = function() {
            $scope.form.statusList.push({
                status: '',
                statusinput: ''
            });
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

        $scope.addData = function(){
                console.log($scope.form);
                console.log($scope.form.studentList);
                var data = $scope.form;
                  $http.post('/admin/tracker/add',{data}).then(function success(e){
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
                        })
                    }
        // $scope.saveTask = function(){
        //     var s ={groupName:$scope.form}

        // }

        $scope.matricksdata =function(){
            console.log($scope.form.optionsList);
            console.log($scope.form.selectstudent);
        }

    });
</script>
@stop