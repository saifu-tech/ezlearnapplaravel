
var app = angular.module('mastersReportFilter',['angularUtils.directives.dirPagination']);

app.controller('mastersReportController',function($scope,$http){
	$scope.getresult = function() {
		$scope.classes=$('#class').val();
		$scope.subject=$('#subject').val();
		$scope.categories=$('#categories').val();
		$scope.records = [];
		$scope.recordArray=[10,25,50,100];
		$scope.recordData={classes:$scope.classes,subject:$scope.subject,categories:$scope.categories};
		$http({
          method  : 'POST',
          url     : '/admin/reports/masters/post',
          data    : $scope.recordData, //forms user object
         }).success(function(data){
         	$('.errorMessage').hide();
         	$('#statusResult').hide();
         	console.log(data);
			$scope.originaldata = data;
			$scope.datalength=$scope.originaldata.length;
			if($scope.datalength>0){
				for(var i=0; i<$scope.originaldata.length; i++){
					$scope.originaldata[i].sno = i + 1;
					$scope.records.push($scope.originaldata[i]);
				}
				$('#statusResult').show();
			}else{
				$('.errorMessage').show().html('No data available.');
			}
			
			
		});
	  }

	 $scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        $scope.reverse = !$scope.reverse; //if true make it false and vice versa
    }


});

app.filter('capitalize', function() {
	    return function(input) {
	      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
	    }
	});