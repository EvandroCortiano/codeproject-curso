angular.module('app.controllers')
	.controller('NoteEditController', 
				['$scope','$location','$routeParams','ProjectNote', 
					function($scope,$location,$routeParams,ProjectNote){
		$scope.note = ProjectNote.get({id: $routeParams.id, idnote: $routeParams.idnote});
		
		$scope.save = function(){
			if($scope.form.$valid){
				ProjectNote.update({id: $scope.note.project_id, idnote: $scope.note.id},$scope.note,function(){
					$location.path('/project/' + $scope.note.project_id + '/notes/' + $scope.note.id);
				});
			}
		}
		
	}]);