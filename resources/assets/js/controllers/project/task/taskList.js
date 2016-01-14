angular.module('app.controllers')
    .controller('ProjectTaskListController', ['$scope', '$routeParams', 'Project', 'ProjectTask',
        function ($scope, $routeParams, Project, ProjectTask) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.tasks = ProjectTask.query({id: $routeParams.id});
        }]);
