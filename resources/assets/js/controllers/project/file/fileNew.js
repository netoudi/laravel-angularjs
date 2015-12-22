angular.module('app.controllers')
    .controller('ProjectFileNewController',
        ['$scope', '$location', '$routeParams', 'Project', 'ProjectFile',
            function ($scope, $location, $routeParams, Project, ProjectFile) {
                $scope.project = Project.get({id: $routeParams.id});
                $scope.file = new ProjectFile({id: $routeParams.id});

                $scope.save = function () {
                    if ($scope.form.$valid) {
                        $scope.file.$save().then(function () {
                            $location.path('/project/' + $routeParams.id + '/file');
                        });
                    }
                }
            }]);
