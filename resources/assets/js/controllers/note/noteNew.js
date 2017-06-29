angular.module('app.controllers')
	.controller('NoteNewController', 
				['$scope','$location' ,'ProjectNote', '$routeParams', function($scope,$location,ProjectNote,$routeParams){
		$scope.notes = new ProjectNote();
		$scope.notes.project_id = $routeParams.id;
		
		$scope.save = function(){
			if($scope.form.$valid){
				$scope.notes.$save({id: $routeParams.id}).then(function(){
					$location.path('/project/' + $routeParams.id + '/notes');
				});
			}
		}
		
	}]);