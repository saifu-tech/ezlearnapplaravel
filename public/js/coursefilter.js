
var app = angular.module('coursesFilter',['angularUtils.directives.dirPagination']);

app.controller('coursesController',function($scope,$http){
	$scope.records = [];
	$http.get('/getcourses').success(function(data){
		$scope.originaldata = data;
		for(var i=0; i<$scope.originaldata.length; i++){
			$scope.originaldata[i].sno = i + 1;
			$scope.records.push($scope.originaldata[i]);
		}
	});

	$scope.loadMore = function(){
		$scope.offset += $scope.count;
	}

	 $scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        $scope.reverse = !$scope.reverse; //if true make it false and vice versa
    }
});