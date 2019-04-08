<?php
use App\Group;
use App\Students;
use App\Dailytasks;
use App\Options;
use App\User;
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
                    <label>Select Template {{ Auth::User()->full_name }}</label>
                </div>
                <div class="form-group col-md-6">
                    <select ng-model="form.selecttemplate" >
                        <option value=""  selected="selected">Select template</option>
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
                        <option selected="daily" value="daily"   >Daily Task</option>
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
                    <label> Evaluation</label>
                </div>
                <div class="form-group col-md-6">
                    <label><input type="checkbox" value="revenue" ng-model="form.revenuedetails">Revenue</label>
                    <label><input type="checkbox" value="cost" ng-model="form.costdetails">cost</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label> Select Type</label>
                </div>
                <div class="form-group col-md-6">
                    <label><input type="checkbox" value="revenue" ng-model="form.xaxis">X-axis</label>
                    <label><input type="checkbox" value="cost" ng-model="form.yaxis"> Y-axis</label>
                </div>
            </div>

            <div class="row" ng-show="form.revenuedetails">
                <div class="col-md-4">
                    <label>
                        Revenue Value
                    </label>
                </div>
                <div class="form-group  col-md-4">
                    <div class="row">
                        <div class="col-md-4"><label>start</label></div>
                        <div class="col-md-4"><label>end</label></div>
                        <div class="col-md-4"><label>colour</label></div>
                    </div>
                    <div class="row" ng-repeat="rev in form.revenue">
                        <div class="col-md-4"><input type="text" class="form-control"    ng-model="rev.start"></div>
                        <div class="col-md-4"><input type="text" class="form-control"   ng-model="rev.end"></div>
                        <div class="col-md-4"><input type="text" class="form-control"   ng-model="rev.colour"></div>
                    </div>
                    {{-- <input type="text" class="form-control"    ng-model="form.revenue.start">
                    <input type="text" class="form-control"   ng-model="form.revenue.end">
                    <input type="text" class="form-control"   ng-model="form.revenue.colour"> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p style="color: red;">@{{ errorgreater }}</p>
                </div>
                <div class="col-md-6">
                    <p style="color: red;">@{{ errorthirdvalue }}</p>
                </div>
            </div>
            <div class="row" ng-show="form.costdetails">
                <div class="col-md-4">
                    <label>
                        cost Value
                    </label>
                </div>
                <div class="form-group  col-md-4">
                    <div class="row">
                        <div class="col-md-4"><label>start</label></div>
                        <div class="col-md-4"><label>end</label></div>
                        <div class="col-md-4"><label>colour</label></div>
                    </div>
                    <div class="row" ng-repeat="cost in form.cost">
                        <div class="col-md-4"><input type="text" class="form-control"    ng-model="cost.start"></div>
                        <div class="col-md-4"><input type="text" class="form-control"   ng-model="cost.end"></div>
                        <div class="col-md-4"><input type="text" class="form-control"   ng-model="cost.colour"></div>
                    </div>
                </div>
            </div>

            <div class="row"  ng-show="form.xaxis">
                <div class="col-md-4">
                    <label>Students</label>
                </div>
                <div class="form-group col-md-6" >
                    <select ng-model="form.selectstudent" ng-change="updateStudentSelection()" placeholder="Select" multiple="multiple">
                        <option selected="selected">select</option>
                        <option ng-repeat = "(k,v) in students" value='@{{ k }}'>@{{ v }}</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-8 col-md-offset-4">
                            <div class="form-group " ng-repeat="stud in form.studentList track by $index">
                                <div class="col-md-10">
                                    <input type="text" class="form-control endDate" ng-model="stud.alternative" placeholder="Enter alternative name for @{{ stud.name }}">
                                </div>

                                {{-- <div class="col-md-6" ng-show="form.studentsoptions == false">
                                    <select ng-model="op.list" >
                                       <option value="" selected="selected">Select option value</option>
                                       <option ng-repeat = "listdata in optionlistdata" value='@{{ listdata.id }}'>@{{ listdata.value }}
                                       </option>
                                   </select>
                                </div><br/> --}}
                           </div>

                       </div>
                       {{--  <div class="col-md-6 col-md-offset-3">
                            <div class="form-group col-md-6" ng-repeat="stud in form.studentList track by $index">
                                <select ng-model="op.list" >
                                 <option value="" selected="selected">Select option value</option>
                                 <option ng-repeat = "listdata in optionlistdata" value='@{{ listdata.id }}'>@{{ listdata.value }}</option>
                             </select>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="row"  ng-show="form.yaxis">
                <div class="col-md-4">
                    <label>Students</label>
                </div>
                <div class="form-group col-md-6" >
                    <label><span>{{ Auth::User()->full_name }}</span></label>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-8 col-md-offset-4">
                            <div class="form-group col-md-12" >
                                <select ng-model="form.selectstudent" ng-change="updateStudentmultiple()" placeholder="Select" multiple="multiple">
                                <option selected="selected">select</option>
                                <option ng-repeat = "(k,v) in students" value='@{{ k }}'>@{{ v }}</option>
                                </select>
                            </div>
                            <div class="form-group " ng-repeat="stud in form.adminstudent track by $index">
                                <div class="col-md-5">
                                    <input type="text" class="form-control endDate" ng-model="stud.sname" placeholder="Enter alternative name for ">
                                </div>
                                <div class="form-group col-md-5" >
                                    <select ng-model="stud.list" >
                                       <option value="" selected="selected">Select option value</option>
                                       <option ng-repeat = "listdata in optionlistdata" value='@{{ listdata.id }}'>@{{ listdata.value }}</option>
                                   </select>
                               </div>
                                <div class="col-md-1">
                                    <a href="javascript:void(0)"  ng-click="addalternative($index)" ng-show="$last" class="addOption"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                    <a href="javascript:void(0)" class="removeOption" ng-click="removealternative($index)" ng-show="$index != 0"  ><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Options</label>
                </div>
                <div class="col-md-6" >
                    <div class="row" ng-repeat="op in form.optionsList track by $index">
                        <div class="form-group col-md-6">
                            <input type="text" ng-model="op.options"  class="form-control">
                        </div>
                        <div class="form-group col-md-5" ng-show="form.xaxis">
                            <select ng-model="op.list" >
                               <option value="" selected="selected">Select option value</option>
                               <option ng-repeat = "listdata in optionlistdata" value='@{{ listdata.id }}'>@{{ listdata.value }}</option>
                           </select>
                       </div>
                       <div class="col-md-1">
                        <a href="javascript:void(0)"  ng-click="addOption($index)" ng-show="$last" class="addOption"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" class="removeOption" ng-click="removeData($index)" ng-show="$index != 0"  ><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row" ng-show="form.xaxis">
            <div class="col-md-4">
                <label>&nbsp;</label>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered" ng-if="form.selectstudent && form.optionsList[0].options ">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th ng-repeat="option in form.optionsList track by $index">@{{ option.options }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="stud in form.studentList track by $index">
                            <td ng-show="stud.alternative == ''"> 
                            @{{ stud.name }}</td>
                            <td ng-show="stud.alternative != ''"> 
                            @{{ stud.alternative }}</td>
                            <td ng-repeat="option in form.optionsList track by $index"><input type="text" name="" value="" ng-model="stud[option.options]"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" ng-show="form.yaxis">
            <div class="col-md-4">
                <label>&nbsp;</label>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered" ng-if="form.adminstudent && form.optionsList[0].options ">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th ng-repeat="option in form.optionsList track by $index">@{{ option.options }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="stud in form.adminstudent track by $index">
                            <td ng-show="stud.sname != ''"> 
                            @{{ stud.sname }}</td>
                             <td ng-show="stud.sname == ''"> 
                            @{{ stud.sname }}</td>
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
            <div class="form-group col-md-1" ng-repeat="day in form.days" ng-show="form.selecttask=='daily'">
                <label><input type="checkbox" ng-model="day.selected" >@{{ day.day }}</label>
            </div>
            <div class="form-group col-md-6"  ng-show="form.selecttask=='weekly'">
                <select ng-model="form.weekly.days">
                    <option value="" selected="selected">Select</option>
                    <option ng-repeat="day in form.days" value='@{{ day.dayNum }}'>@{{ day.day }}</option>
                </select>

            </div>
            <div class="form-group col-md-6"  ng-show="form.selecttask=='monthly'">
                <select ng-model="form.monthly.days">
                    <option value="" selected="selected">Select</option>
                    <option ng-repeat="day in form.day" value='@{{ day.date }}'>@{{ day.date }}</option>
                </select>

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
                    <button class="btn btn-primary" ng-show="form.xaxis" ng-click="saveTask()">Savex</button>
                     <button class="btn btn-primary" ng-show="form.yaxis" ng-click="datastudent()">Savey</button>
                    <button class="btn btn-success">Cancel</button>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.js"></script>
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
        $scope.optionlistdata =  {!! json_encode($options) !!};
        $scope.option = [];
        $scope.form = {} ;
        $scope.options = '';
        $scope.form.selecttask="daily";
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
        $scope.form.day=[
        { 
            "date": "1"
        }, { 
            "date": "2"
        },  { 
            "date": "3"
        } ,  { 
            "date": "4"
        },  { 
            "date": "5"
        },  { 
            "date": "6"
        },  { 
            "date": "7"
        },  { 
            "date": "8"
        },  { 
            "date": "9"
        },  { 
            "date": "10"
        },  { 
            "date": "11"
        },  { 
            "date": "12"
        },  { 
            "date": "13"
        },  { 
            "date": "14"
        },  { 
            "date": "15"
        },  { 
            "date": "16"
        },  { 
            "date": "17"
        },  { 
            "date": "18"
        },  { 
            "date": "19"
        },  { 
            "date": "20"
        },  { 
            "date": "21"
        },  { 
            "date": "22"
        },  { 
            "date": "23"
        },  { 
            "date": "24"
        },  { 
            "date": "25"
        },  { 
            "date": "26"
        },  { 
            "date": "27"
        },  { 
            "date": "28"
        },  { 
            "date": "29"
        },  { 
            "date": "30"
        }
        ]
        $scope.form.studentList = [];
        $scope.form.adminstudent = [];
        // $scope.form.optiontypes = [{
        //     revenue:{start:'',end:''},
        //     cost:''
        // }];
        $scope.form.revenue=[{
            start:'0',
            end:'70',
            colour:'#dd2f2e7a',type:'revemue'},
            {
                start:'71',
                end:'95',
                colour:'#ffce00c4',type:'revemue'},
                {
                    start:'96',
                    end:'100',
                    colour:'#56c35691',type:'revemue'}];
                    $scope.form.cost=[{
                        start:'0',
                        end:'70',
                        colour:'#56c35691',type:'cost'},
                        {
                            start:'71',
                            end:'95',
                            colour:'#ffce00c4',type:'cost'},
                            {
                                start:'96',
                                end:'100',
                                colour:'#dd2f2e7a',type:'cost'}];
        // },
        // 1:{
        //     start:'70',
        //     end:'85',
        //     colour:'yellow'
        // },
        //  2:{
        //     start:'90',
        //     end:'100',
        //     colour:'green'
        // }]
        $scope.form.optionsList = [{
            options: '',
            list: ''
        }];

        $scope.form.adminstudent = [{
            sname:'',
            list:''
        }]

        $scope.addOption = function() {
            var options = {};
            $scope.form.optionsList.push({
                options: '',
                list: ''
            });

        }
        $scope.addalternative= function(){
            var sname ={};
            $scope.form.adminstudent.push({
                 sname:'',
                    list:''
            })
        }

        $scope.updateStudentSelection = function() {
            $scope.form.studentList = [];
            $scope.alternativename = '';
            $scope.form.selectstudent.forEach(function(v, i) {
                $scope.form.studentList.push({id: v, name: $scope.students[v], alternative:$scope.alternativename});
            })

            console.log($scope.form.studentList)
        }

        $scope.updateStudentmultiple = function() {
            $scope.form.adminstudent = [];
            $scope.alternativenamemultiple = [{

            }];
            $scope.form.selectstudent.forEach(function(v, i) {
                $scope.form.adminstudent.push({ });
            })

            console.log($scope.form.adminstudent)
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
            $scope.form.optionsList.splice(index,1);
        }

         $scope.removealternative = function(index){
            var alternativeName = $scope.form.adminstudent[index].options;
            $scope.form.adminstudent.forEach(function(v, i) {
                delete v[alternativeName];
            })
            $scope.form.adminstudent.splice(index,1);
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

        $scope.saveTask = function(){

            var ps, pe = 0;
            var flag = true;
            console.log($scope.form.revenue)
            $scope.form.revenue.forEach(function(v, i) {
                var start = parseInt(v.start);
                var end = parseInt(v.end);
                if(i == 0) {
                    ps = start;
                    pe = end;
                    if(start > end) {
                        flag = false;
                        $scope.errorgreater="Start value is greater than end value";
                        console.log( $scope.errorgreater)
                        return false;
                    }
                } else {
                    if(start <= pe || start > end) {
                        flag = false;
                        $scope.errorthirdvalue="please fill the correct value";
                        console.log($scope.errorthirdvalue);
                        return false;
                    }
                }
            });
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
        });





        }

        $scope.datastudent = function(){
            console.log('1');
            var ps, pe = 0;
            var flag = true;
            console.log($scope.form.revenue)
            $scope.form.revenue.forEach(function(v, i) {
                var start = parseInt(v.start);
                var end = parseInt(v.end);
                if(i == 0) {
                    ps = start;
                    pe = end;
                    if(start > end) {
                        flag = false;
                        $scope.errorgreater="Start value is greater than end value";
                        console.log( $scope.errorgreater)
                        return false;
                    }
                } else {
                    if(start <= pe || start > end) {
                        flag = false;
                        $scope.errorthirdvalue="please fill the correct value";
                        console.log($scope.errorthirdvalue);
                        return false;
                    }
                }
            });
            console.log($scope.form);
            console.log($scope.form.studentList);
            var data = $scope.form;
            $http.post('/admin/tracker/addmultiple',{data}).then(function success(e){
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


        $scope.matricksdata =function(){
            console.log($scope.form.optionsList);
            console.log($scope.form.selectstudent);
        }

    });
</script>
@stop