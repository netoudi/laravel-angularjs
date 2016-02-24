angular.module('app.controllers')
    .controller('HomeController', ['$scope', 'Project',
        function ($scope, Project) {
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

