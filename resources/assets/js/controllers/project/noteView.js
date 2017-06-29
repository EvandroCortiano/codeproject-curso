angular.module('app.controllers')
	.controller('NoteViewController', ['$scope', '$routeParams', 'ProjectNote', function($scope, $routeParams, ProjectNote){
		$scope.notes = ProjectNote.query({id: $routeParams.id}, {idnote: $routeParams.idnote});
	}]);
