angular.module('app.controllers')
    .controller('ProjectTaskRemoveController', ['$scope', '$location', '$routeParams', 'Project', 'ProjectTask',
        function ($scope, $location, $routeParams, Project, ProjectTask) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.task = ProjectTask.get({id: $routeParams.id, idTask: $routeParams.idTask});

            $scope.remove = function () {
                $scope.task.$delete({id: $routeParams.id, idTask: $routeParams.idTask}).then(function () {
                    $location.path('/project/' + $routeParams.id + '/task');
                });
            }
        }]);
