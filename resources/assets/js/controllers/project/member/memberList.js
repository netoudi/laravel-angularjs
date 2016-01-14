angular.module('app.controllers')
    .controller('ProjectMemberListController', ['$scope', '$routeParams', 'Project', 'ProjectMember',
        function ($scope, $routeParams, Project, ProjectMember) {
            $scope.project = Project.get({id: $routeParams.id});
            $scope.members = ProjectMember.query({id: $routeParams.id});
        }]);
