angular.module('app.directives')
    .directive('navActivated', function () {
        return {
            restrict: 'A',
            link: function (scope, element, attr) {
                $(element).on('click', 'a', function () {
                    var a = $(this);
                    a.parent().parent().find('.actived').removeClass('actived');
                    a.addClass('actived');
                });
            }
        }
    });
