angular.module('app.controllers')
    .controller('ProjectNoteNewController',
        ['$scope', '$location', '$routeParams', 'ProjectNote',
            function ($scope, $location, $routeParams, ProjectNote) {
                $scope.note = new ProjectNote({id: $routeParams.id});

                $scope.save = function () {
                    if ($scope.form.$valid) {
                        $scope.note.$save().then(function () {
                            $location.path('/project/' + $routeParams.id + '/notes');
                        });
                    }
                }
            }]);
