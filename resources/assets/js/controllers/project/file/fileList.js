angular.module('app.controllers')
    .controller('ProjectFileListController', ['$scope', '$routeParams', 'Project', 'ProjectFile',
        function ($scope, $routeParams, Project, ProjectFile) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.files = ProjectFile.query({id: $routeParams.id});
        }]);
