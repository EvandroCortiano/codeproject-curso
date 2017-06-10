angular.module('app.controllers')
	.controller('NoteNewController', 
				['$scope','$location' ,'ProjectNote', '$routeParams', function($scope,$location,ProjectNote,$routeParams){
		$scope.notes = new ProjectNote();
		$scope.note.project_id = $routeParams.id;
		
		$scope.save = function(){
			if($scope.form.$valid){
				$scope.notes.$save().then(function(){
					$location.path('/project/' + $scope.note.project_id + '/notes/new');
				});
			}
		}
		
	}]);