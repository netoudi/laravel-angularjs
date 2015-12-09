angular.module('app.controllers')
    .controller('ProjectNoteRemoveController', ['$scope', '$location', '$routeParams', 'ProjectNote',
        function ($scope, $location, $routeParams, ProjectNote) {
            $scope.note = ProjectNote.get({id: $routeParams.id, idNote: $routeParams.idNote});

            $scope.remove = function () {
                $scope.note.$delete({id: $routeParams.id, idNote: $routeParams.idNote}).then(function () {
                    $location.path('/project/' + $routeParams.id + '/notes');
                });
            }
        }]);
