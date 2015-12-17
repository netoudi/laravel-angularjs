angular.module('app.controllers')
    .controller('ProjectNoteNewController',
        ['$scope', '$location', '$routeParams', 'Project', 'ProjectNote',
            function ($scope, $location, $routeParams, Project, ProjectNote) {
                $scope.project = Project.get({id: $routeParams.id});
                $scope.note = new ProjectNote({id: $routeParams.id});

                $scope.save = function () {
                    if ($scope.form.$valid) {
                        $scope.note.$save().then(function () {
                            $location.path('/project/' + $routeParams.id + '/notes');
                        });
                    }
                }
            }]);
