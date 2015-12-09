angular.module('app.controllers')
    .controller('ProjectNoteEditController', ['$scope', '$location', '$routeParams', 'ProjectNote',
        function ($scope, $location, $routeParams, ProjectNote) {
            $scope.note = ProjectNote.get({id: $routeParams.id, idNote: $routeParams.idNote});

            $scope.save = function () {
                if ($scope.form.$valid) {
                    ProjectNote.update({id: $routeParams.id, idNote: $routeParams.idNote}, $scope.note, function () {
                        $location.path('/project/' + $routeParams.id + '/notes');
                    });
                }
            }
        }]);
