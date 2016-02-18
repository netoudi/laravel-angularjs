angular.module('app.controllers')
    .controller('ProjectDashboardController', ['$scope', 'Project',
        function ($scope, Project) {

            $scope.project = {};

            Project.query({
                limit: 8,
                orderBy: 'created_at',
                sortedBy: 'desc'
            }, function (data) {
                $scope.projects = data.data;
            });

            $scope.showProject = function (o) {
                $scope.project = o;
            };
        }]);
