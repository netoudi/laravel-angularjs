angular.module('app.services')
    .service('ProjectMember', ['$resource', 'appConfig', function ($resource, appConfig) {
        return $resource(appConfig.baseUrl + '/project/:id/member/:idMember', {id: '@id', idMember: '@idMember'}, {
            update: {
                method: 'PUT'
            }
        });
    }]);