angular.module('app.filters')
    .filter('projectStatus1', ['$sce', function ($sce) {
        return function (input) {
            var status = [
                '<span class="text-warning">Não iniciou</span>',
                '<span class="text-info">Iniciado</span>',
                '<span class="text-danger">Atrasado</span>',
                '<span class="text-success">Concluído</span>',
            ];

            return $sce.trustAsHtml(status[input]);
        };
    }])
    .filter('projectStatus2', ['$sce', function ($sce) {
        return function (input) {
            var status = [
                '<p class="text-warning status"><i class="fa fa-circle"></i> Não iniciou</p>',
                '<p class="text-info status"><i class="fa fa-circle"></i> Iniciado</p>',
                '<p class="text-danger status"><i class="fa fa-circle"></i> Atrasado</p>',
                '<p class="text-success status"><i class="fa fa-circle"></i> Concluído</p>',
            ];

            return $sce.trustAsHtml(status[input]);
        };
    }]);
