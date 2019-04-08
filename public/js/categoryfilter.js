
var app = angular.module('categoryFilter',['angularUtils.directives.dirPagination']);

app.controller('categoryController',function($scope,$http){
	$scope.records = [];
	$scope.recordArray=[10,25,50,100];
	$http.get('/getcategories').success(function(data){
		$scope.originaldata = data;
		$scope.datalength=$scope.originaldata.length;
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