angular.module('app.controllers')
    .controller('ClientDashboardController', ['$scope', 'Client',
        function ($scope, Client) {

            $scope.client = {};

            Client.query({
                limit: 8,
                orderBy: 'created_at',
                sortedBy: 'desc'
            }, function (data) {
                $scope.clients = data.data;
            });

            $scope.showClient = function (o) {
                $scope.client = o;
            };
        }]);
