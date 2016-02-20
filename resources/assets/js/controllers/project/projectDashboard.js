angular.module('app.controllers')
    .controller('ProjectDashboardController', ['$scope', 'Project',
        function ($scope, Project) {
            $scope.data = {
                availableOptions: [
                    {id: '', name: '-'},
                    {id: 'A', name: 'A'},
                    {id: 'B', name: 'B'},
                    {id: 'C', name: 'C'},
                    {id: 'D', name: 'D'},
                    {id: 'E', name: 'E'},
                    {id: 'F', name: 'F'},
                    {id: 'G', name: 'G'},
                    {id: 'H', name: 'H'},
                    {id: 'I', name: 'I'},
                    {id: 'J', name: 'J'},
                    {id: 'K', name: 'K'},
                    {id: 'L', name: 'L'},
                    {id: 'M', name: 'M'},
                    {id: 'N', name: 'N'},
                    {id: 'O', name: 'O'},
                    {id: 'P', name: 'P'},
                    {id: 'Q', name: 'Q'},
                    {id: 'R', name: 'R'},
                    {id: 'S', name: 'S'},
                    {id: 'T', name: 'T'},
                    {id: 'U', name: 'U'},
                    {id: 'V', name: 'V'},
                    {id: 'W', name: 'W'},
                    {id: 'X', name: 'X'},
                    {id: 'Y', name: 'Y'},
                    {id: 'Z', name: 'Z'}
                ],
                selectedOption: {id: '', name: '-'}
            };

            $scope.project = {};

            Project.query({
                limit: 10,
                orderBy: 'created_at',
                sortedBy: 'desc'
            }, function (data) {
                $scope.project = data.data[0] || {};
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
                    searchFields: 'name:like'
                }, function (data) {
                    $scope.project = data.data[0] || {};
                    $scope.projects = data.data;
                });
            };
        }]);
