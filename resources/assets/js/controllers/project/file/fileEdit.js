angular.module('app.controllers')
    .controller('ProjectFileEditController', ['$scope', '$location', '$routeParams', 'Project', 'ProjectFile',
        function ($scope, $location, $routeParams, Project, ProjectFile) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.file = ProjectFile.get({id: $routeParams.id, idFile: $routeParams.idFile});

            $scope.save = function () {
                if ($scope.form.$valid) {
                    ProjectFile.update({id: $routeParams.id, idFile: $routeParams.idFile}, $scope.file, function () {
                        $location.path('/project/' + $routeParams.id + '/file');
                    });
                }
            }
        }]);
