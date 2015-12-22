angular.module('app.directives')
    .directive('projectFileDownload', ['appConfig', 'ProjectFile',
        function (appConfig, ProjectFile) {
            return {
                restrict: 'E',
                templateUrl: appConfig.baseUrl + '/build/views/templates/projectFileDownload.html',
                link: function (scope, element, attr) {

                },
                controller: ['$scope', '$element', '$attrs', function ($scope, $elemnet, $attrs) {
                    $scope.downloadFile = function () {
                        var anchor = $elemnet.children()[0];
                        $(anchor).addClass('disabled');
                        $(anchor).text('Loading...');
                        ProjectFile.download({id: $attrs.idProject, idFile: $attrs.idFile}, function (data) {
                            $(anchor).removeClass('disabled');
                            $(anchor).text('Salvar arquivo');
                            $(anchor).attr({
                                href: 'data:application-octet-stream;base64,' + data.file,
                                download: data.name
                            });
                        });
                    }
                }]
            }
        }]);
