angular.module('app.services')
    .service('Project', ['$resource', 'appConfig', function ($resource, appConfig) {
        return $resource(appConfig.baseUrl + '/project/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            },
            get: {
                method: 'GET',
                transformResponse: function (data, headers) {
                    var o = appConfig.utils.transformResponse(data, headers);
                    if (angular.isObject(o) && o.hasOwnProperty('due_date')) {
                        o.due_date = new Date(o.due_date);
                    }
                    if (angular.isObject(o) && o.hasOwnProperty('client')) {
                        o.client_id = o.client.data.id;
                    }
                    return o;
                }
            }
        });
    }]);