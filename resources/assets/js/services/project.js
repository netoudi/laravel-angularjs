angular.module('app.services')
    .service('Project', ['$resource', '$filter', 'appConfig', function ($resource, $filter, appConfig) {

        function transformData(data) {
            if (angular.isObject(data)) {
                if (data.hasOwnProperty('start_date') && data.hasOwnProperty('due_date')) {
                    var o = angular.copy(data);
                    o.start_date = $filter('date')(data.start_date, 'yyyy-MM-dd');
                    o.due_date = $filter('date')(data.due_date, 'yyyy-MM-dd');
                    return appConfig.utils.transformRequest(o);
                }
            }
            return data;
        }

        return $resource(appConfig.baseUrl + '/project/:id', {id: '@id'}, {
            save: {
                method: 'POST',
                transformRequest: transformData
            },
            update: {
                method: 'PUT',
                transformRequest: transformData
            },
            get: {
                method: 'GET',
                transformResponse: function (data, headers) {
                    var o = appConfig.utils.transformResponse(data, headers);
                    if (angular.isObject(o) && o.hasOwnProperty('start_date')) {
                        var arrayDate = o.start_date.split('-'),
                            month = parseInt(arrayDate[1]) - 1;
                        o.start_date = new Date(arrayDate[0], month, arrayDate[2]);
                    }
                    if (angular.isObject(o) && o.hasOwnProperty('due_date')) {
                        var arrayDate = o.due_date.split('-'),
                            month = parseInt(arrayDate[1]) - 1;
                        o.due_date = new Date(arrayDate[0], month, arrayDate[2]);
                    }
                    if (angular.isObject(o) && o.hasOwnProperty('client')) {
                        o.client_id = o.client.data.id;
                    }
                    return o;
                }
            },
            query: {
                isArray: false
            }
        });
    }]);