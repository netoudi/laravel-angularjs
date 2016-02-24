angular.module('app.filters')
    .filter('dateBr', ['$filter', function ($filter) {
        return function (input) {
            return $filter('date')(input, 'dd/MM/yyyy');
        };
    }])
    .filter('dateBrFull', function () {
        return function (input) {
            var str, arrayDate = input.split('-'),
                month = parseInt(arrayDate[1]) - 1;

            switch (month) {
                case 1:
                    str = 'Jan ' + arrayDate[2];
                    break;
                case 2:
                    str = 'Fev ' + arrayDate[2];
                    break;
                case 3:
                    str = 'Mar ' + arrayDate[2];
                    break;
                case 4:
                    str = 'Abr ' + arrayDate[2];
                    break;
                case 5:
                    str = 'Mai ' + arrayDate[2];
                    break;
                case 6:
                    str = 'Jul ' + arrayDate[2];
                    break;
                case 7:
                    str = 'Jun ' + arrayDate[2];
                    break;
                case 8:
                    str = 'Ago ' + arrayDate[2];
                    break;
                case 9:
                    str = 'Set ' + arrayDate[2];
                    break;
                case 10:
                    str = 'Out ' + arrayDate[2];
                    break;
                case 11:
                    str = 'Nov ' + arrayDate[2];
                    break;
                case 12:
                    str = 'Dez ' + arrayDate[2];
                    break;
            }

            return str;
        };
    });