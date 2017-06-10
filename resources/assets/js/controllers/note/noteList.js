angular.module('app.controllers')
	.controller('NoteListController', ['$scope', '$routeParams', 'ProjectNote', function($scope, $routeParams, ProjectNote){
		$scope.note = ProjectNote.query({id: $routeParams.id, noteId: $routeParams.noteId});
	}]);