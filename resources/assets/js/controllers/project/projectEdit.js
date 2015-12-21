angular.module('app.controllers')
    .controller('ProjectEditController', ['$scope', '$location', '$cookies', '$routeParams', 'Project', 'Client', 'appConfig',
        function ($scope, $location, $cookies, $routeParams, Project, Client, appConfig) {
            Project.get({id: $routeParams.id}, function (data) {
                $scope.project = data;
                Client.get({id: data.client_id}, function (data) {
                    $scope.clientSelected = data;
                });
            });
            $scope.status = appConfig.project.status;

            $scope.save = function () {
                if ($scope.form.$valid) {
                    $scope.project.owner_id = $cookies.getObject('user').id;
                    Project.update({id: $routeParams.id}, $scope.project, function () {
                        $location.path('/project');
                    });
                }
            };

            $scope.formatName = function (model) {
                if (model) {
                    return model.name;
                }
                return '';
            };

            $scope.getClients = function (name) {
                return Client.query({
                        search: name,
                        searchFields: 'name:like'
                    }
                ).$promise;
            };

            $scope.selectClient = function (item) {
                $scope.project.client_id = item.id;
            };

        }]);
