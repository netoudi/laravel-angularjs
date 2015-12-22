angular.module('app.directives')
    .directive('projectFileDownload', ['$timeout', 'appConfig', 'ProjectFile',
        function ($timeout, appConfig, ProjectFile) {
            return {
                restrict: 'E',
                templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
                link: function (scope, element, attr) {
                    var anchor = element.children()[0];
                    scope.$on('save-file', function (event, data) {
                        $(anchor).removeClass('disabled');
                        $(anchor).text('Download');
                        $(anchor).attr({
                            href: 'data:application-octet-stream;base64,' + data.file,
                            download: data.name
                        });

                        $timeout(function () {
                            scope.downloadFile = function () {
                            };
                            $(anchor)[0].click();
                        });
                    });
                },
                controller: ['$scope', '$element', '$attrs', function ($scope, $elemnet, $attrs) {
                    $scope.downloadFile = function () {
                        var anchor = $elemnet.children()[0];
                        $(anchor).addClass('disabled');
                        $(anchor).text('Loading...');
                        ProjectFile.download({id: $attrs.idProject, idFile: $attrs.idFile}, function (data) {
                            $scope.$emit('save-file', data);
                        });
                    }
                }]
            }
        }]);
