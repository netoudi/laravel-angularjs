angular.module('app.controllers')
    .controller('ProjectTaskEditController', ['$scope', '$location', '$routeParams', 'Project', 'ProjectTask', 'appConfig',
        function ($scope, $location, $routeParams, Project, ProjectTask, appConfig) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.task = ProjectTask.get({id: $routeParams.id, idTask: $routeParams.idTask});
            $scope.status = appConfig.project.status;

            $scope.start_date = {
                status: {
                    opened: false
                }
            };

            $scope.due_date = {
                status: {
                    opened: false
                }
            };

            $scope.openStartDate = function () {
                $scope.start_date.status.opened = true;
            };

            $scope.openDueDate = function () {
                $scope.due_date.status.opened = true;
            };


            $scope.save = function () {
                if ($scope.form.$valid) {
                    ProjectTask.update({id: $routeParams.id, idTask: $routeParams.idTask}, $scope.task, function () {
                        $location.path('/project/' + $routeParams.id + '/task');
                    });
                }
            }
        }]);
