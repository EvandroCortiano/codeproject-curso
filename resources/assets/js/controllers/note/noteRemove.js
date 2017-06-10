angular.module('app.controllers')
    .controller('NoteRemoveController',
    ['$scope', '$location','$routeParams', 'ProjectNote', function($scope, $location, $routeParams, ProjectNote){
        $scope.note = ProjectNote.get({id: $routeParams.id, idnote: $routeParams.idnote});

        $scope.remove = function() {
            $scope.note.$delete({id: $scope.note.project_id, idnote: $scope.note.id}).then(function(){
                $location.path('/project/' + $routeParams.id + '/notes');
            });
        }
    }]);