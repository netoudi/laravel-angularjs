angular.module('app.filters')
    .filter('projectTaskStatus', ['$sce', '$filter', function ($sce, $filter) {
        return function (input, args) {
            var status = [
                '<span class="text-warning">' + $filter('date')(args, 'dd/MM/yy H:mm') + ' - Tarefa incluída</span>',
                '<span class="text-info">' + $filter('date')(args, 'dd/MM/yy H:mm') + ' - Tarefa iniciada</span>',
                '<span class="text-danger">' + $filter('date')(args, 'dd/MM/yy H:mm') + ' - Tarefa atrasada</span>',
                '<span class="text-success">' + $filter('date')(args, 'dd/MM/yy H:mm') + ' - Tarefa concluída</span>',
            ];

            return $sce.trustAsHtml(status[input]);
        };
    }]);
