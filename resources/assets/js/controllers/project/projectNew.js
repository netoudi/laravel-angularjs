angular.module('app.controllers')
    .controller('ProjectNewController',
        ['$scope', '$location', '$cookies', 'Project', 'Client', 'appConfig',
            function ($scope, $location, $cookies, Project, Client, appConfig) {
                $scope.project = new Project();
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
                        $scope.project.owner_id = $cookies.getObject('user').id;
                        $scope.project.$save().then(function () {
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
