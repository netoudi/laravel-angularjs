angular.module('app.controllers')
    .controller('ProjectMemberNewController',
        ['$scope', '$location', '$routeParams', 'Project', 'User', 'ProjectMember',
            function ($scope, $location, $routeParams, Project, User, ProjectMember) {
                $scope.project = Project.get({id: $routeParams.id});
                $scope.member = new ProjectMember({id: $routeParams.id});

                $scope.save = function () {
                    if ($scope.form.$valid) {
                        $scope.member.$save().then(function () {
                            $location.path('/project/' + $routeParams.id + '/member');
                        });
                    }
                };

                $scope.formatName = function (model) {
                    if (model) {
                        return model.name;
                    }
                    return '';
                };

                $scope.getUsers = function (name) {
                    return User.query({
                            search: name,
                            searchFields: 'name:like'
                        }
                    ).$promise;
                };

                $scope.selectUser = function (item) {
                    $scope.member.member_id = item.id;
                };

            }]);
