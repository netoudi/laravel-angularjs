angular.module('app.controllers')
    .controller('ProjectMemberRemoveController', ['$scope', '$location', '$routeParams', 'Project', 'ProjectMember',
        function ($scope, $location, $routeParams, Project, ProjectMember) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.member = ProjectMember.get({id: $routeParams.id, idMember: $routeParams.idMember});

            $scope.remove = function () {
                $scope.member.$delete({id: $routeParams.id, idMember: $routeParams.idMember}).then(function () {
                    $location.path('/project/' + $routeParams.id + '/member');
                });
            }
        }]);
