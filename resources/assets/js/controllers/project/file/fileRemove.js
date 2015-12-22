angular.module('app.controllers')
    .controller('ProjectFileRemoveController', ['$scope', '$location', '$routeParams', 'Project', 'ProjectFile',
        function ($scope, $location, $routeParams, Project, ProjectFile) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.file = ProjectFile.get({id: $routeParams.id, idFile: $routeParams.idFile});

            $scope.remove = function () {
                $scope.file.$delete({id: $routeParams.id, idFile: $routeParams.idFile}).then(function () {
                    $location.path('/project/' + $routeParams.id + '/file');
                });
            }
        }]);
