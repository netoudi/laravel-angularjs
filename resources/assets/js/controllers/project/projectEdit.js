angular.module('app.controllers')
    .controller('ProjectEditController', ['$scope', '$location', '$cookies', '$routeParams', 'Project', 'Client', 'appConfig',
        function ($scope, $location, $cookies, $routeParams, Project, Client, appConfig) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.clients = Client.query();
            $scope.status = appConfig.project.status;

            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project.owner_id = $cookies.getObject('user').id;
                    Project.update({id: $routeParams.id}, $scope.project, function () {
                        $location.path('/project');
                    });
                }
            }
        }]);
