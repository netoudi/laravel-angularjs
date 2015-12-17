angular.module('app.controllers')
    .controller('ProjectNoteListController', ['$scope', '$routeParams', 'Project', 'ProjectNote',
        function ($scope, $routeParams, Project, ProjectNote) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.notes = ProjectNote.query({id: $routeParams.id});
        }]);
