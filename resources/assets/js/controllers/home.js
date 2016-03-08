angular.module('app.controllers')
    .controller('HomeController', ['$scope', '$cookies', '$timeout', '$pusher', 'appConfig', 'Project', 'ProjectTask',
        function ($scope, $cookies, $timeout, $pusher, appConfig, Project, ProjectTask) {
            $scope.data = {
                availableOptions: [
                    {id: '', name: 'Todos'},
                    {id: 0, name: 'Não iniciou'},
                    {id: 1, name: 'Iniciado'},
                    {id: 2, name: 'Atrasado'},
                    {id: 3, name: 'Concluído'}
                ],
                selectedOption: {id: '', name: 'Todos'}
            };

            $scope.tasks = [];
            var pusher = $pusher(window.client);
            var channel = pusher.subscribe('user.' + $cookies.getObject('user').id);
            channel.bind('CodeProject\\Events\\TaskWasIncluded',
                function (data) {
                    if ($scope.tasks.length == 6) {
                        $scope.tasks.splice($scope.tasks.length - 1, 1);
                    }
                    $timeout(function () {
                        $scope.tasks.unshift(data.projectTask.data);
                    }, 1000);
                }
            );

            ProjectTask.query({}, function (data) {
                $scope.tasks = data;
            });

            Project.query({
                limit: 12,
                orderBy: 'created_at',
                sortedBy: 'desc'
            }, function (data) {
                $scope.projects = data.data;
            });

            $scope.showProject = function (o) {
                $scope.project = o;
            };

            $scope.filterProject = function () {
                Project.query({
                    limit: 10,
                    orderBy: 'created_at',
                    sortedBy: 'desc',
                    search: $scope.data.selectedOption.id,
                    searchFields: 'status:='
                }, function (data) {
                    $scope.projects = data.data;
                });
            };
        }]);

