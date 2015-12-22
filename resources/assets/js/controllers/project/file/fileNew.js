angular.module('app.controllers')
    .controller('ProjectFileNewController',
        ['$scope', '$location', '$routeParams', 'Project', 'appConfig', 'Url', 'Upload',
            function ($scope, $location, $routeParams, Project, appConfig, Url, Upload) {
                $scope.project = Project.get({id: $routeParams.id});

                $scope.save = function () {
                    if ($scope.form.$valid) {
                        var url = appConfig.baseUrl + Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {id: $routeParams.id, idFile: ''});
                        Upload.upload({
                            url: url,
                            fields: {
                                name: $scope.file.name,
                                description: $scope.file.description
                            },
                            file: $scope.file.file
                        }).success(function (data, status, headers, config) {
                            $location.path('/project/' + $routeParams.id + '/file');
                        });
                    }
                };

            }]);
