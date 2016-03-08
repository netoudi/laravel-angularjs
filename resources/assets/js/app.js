var app = angular.module('app', [
    'ngRoute',
    'angular-oauth2',
    'app.controllers',
    'app.filters',
    'app.services',
    'app.directives',
    'ui.bootstrap.typeahead',
    'ui.bootstrap.datepicker',
    'ui.bootstrap.tpls',
    'ui.bootstrap.modal',
    'ngFileUpload',
    'http-auth-interceptor',
    'angularUtils.directives.dirPagination',
    'mgcrea.ngStrap.navbar',
    'datatables',
    'pusher-angular',
    'ui-notification'
]);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2']);
angular.module('app.filters', []);
angular.module('app.directives', []);
angular.module('app.services', ['ngResource']);

app.provider('appConfig', ['$httpParamSerializerProvider', function ($httpParamSerializerProvider) {
    var config = {
        baseUrl: 'http://localhost:8000',
        pusherKey: 'aad75fd3b4ef38d5d2c4',
        project: {
            status: [
                {value: 0, label: 'Não iniciou'},
                {value: 1, label: 'Iniciado'},
                {value: 2, label: 'Atrasado'},
                {value: 3, label: 'Concluído'}
            ]
        },
        urls: {
            projectFile: '/project/{{id}}/file/{{idFile}}'
        },
        utils: {
            transformRequest: function (data) {
                if (angular.isObject(data)) {
                    return $httpParamSerializerProvider.$get()(data);
                }
                return data;
            },
            transformResponse: function (data, headers) {
                var headersGetter = headers();
                if (headersGetter['content-type'] == 'application/json' || headersGetter['content-type'] == 'text/json') {
                    var dataJson = JSON.parse(data);
                    if (dataJson.hasOwnProperty('data') && Object.keys(dataJson).length == 1) {
                        dataJson = dataJson.data;
                    }
                    return dataJson;
                }
                return data;
            }
        }
    };

    return {
        config: config,
        $get: function () {
            return config;
        }
    }
}]);

app.config([
    '$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider',
    function ($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider) {
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;
        $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;
        $httpProvider.interceptors.slice(0, 1);
        $httpProvider.interceptors.slice(0, 1);
        $httpProvider.interceptors.push('oauthFixInterceptor');

        $routeProvider
            .when('/login', {
                templateUrl: 'build/views/login.html',
                controller: 'LoginController'
            })
            .when('/logout', {
                resolve: {
                    logout: ['$location', 'OAuthToken', function ($location, OAuthToken) {
                        OAuthToken.removeToken();
                        return $location.path('/login');
                    }]
                }
            })
            .when('/home', {
                templateUrl: 'build/views/home.html',
                controller: 'HomeController'
            })

            // CLIENTS
            .when('/clients', {
                templateUrl: 'build/views/client/dashboard.html',
                controller: 'ClientDashboardController',
                title: 'Clientes'
            })
            .when('/clients/list', {
                templateUrl: 'build/views/client/list.html',
                controller: 'ClientListController',
                title: 'Clientes'
            })
            .when('/clients/new', {
                templateUrl: 'build/views/client/new.html',
                controller: 'ClientNewController',
                title: 'Clientes'
            })
            .when('/clients/:id/edit', {
                templateUrl: 'build/views/client/edit.html',
                controller: 'ClientEditController',
                title: 'Clientes'
            })
            .when('/clients/:id/remove', {
                templateUrl: 'build/views/client/remove.html',
                controller: 'ClientRemoveController',
                title: 'Clientes'
            })

            // Projects
            .when('/project', {
                templateUrl: 'build/views/project/dashboard.html',
                controller: 'ProjectDashboardController',
                title: 'Projetos'
            })
            .when('/project/list', {
                templateUrl: 'build/views/project/list.html',
                controller: 'ProjectListController',
                title: 'Projetos'
            })
            .when('/project/new', {
                templateUrl: 'build/views/project/new.html',
                controller: 'ProjectNewController',
                title: 'Projetos'
            })
            .when('/project/:id/edit', {
                templateUrl: 'build/views/project/edit.html',
                controller: 'ProjectEditController',
                title: 'Projetos'
            })
            .when('/project/:id/remove', {
                templateUrl: 'build/views/project/remove.html',
                controller: 'ProjectRemoveController',
                title: 'Projetos'
            })

            // Project Note
            .when('/project/:id/notes', {
                templateUrl: 'build/views/project/note/list.html',
                controller: 'ProjectNoteListController'
            })
            .when('/project/:id/notes/new', {
                templateUrl: 'build/views/project/note/new.html',
                controller: 'ProjectNoteNewController'
            })
            .when('/project/:id/notes/:idNote/edit', {
                templateUrl: 'build/views/project/note/edit.html',
                controller: 'ProjectNoteEditController'
            })
            .when('/project/:id/notes/:idNote/remove', {
                templateUrl: 'build/views/project/note/remove.html',
                controller: 'ProjectNoteRemoveController'
            })

            // Project File
            .when('/project/:id/file', {
                templateUrl: 'build/views/project/file/list.html',
                controller: 'ProjectFileListController'
            })
            .when('/project/:id/file/new', {
                templateUrl: 'build/views/project/file/new.html',
                controller: 'ProjectFileNewController'
            })
            .when('/project/:id/file/:idFile/edit', {
                templateUrl: 'build/views/project/file/edit.html',
                controller: 'ProjectFileEditController'
            })
            .when('/project/:id/file/:idFile/remove', {
                templateUrl: 'build/views/project/file/remove.html',
                controller: 'ProjectFileRemoveController'
            })

            // Project Task
            .when('/project/:id/task', {
                templateUrl: 'build/views/project/task/list.html',
                controller: 'ProjectTaskListController'
            })
            .when('/project/:id/task/new', {
                templateUrl: 'build/views/project/task/new.html',
                controller: 'ProjectTaskNewController'
            })
            .when('/project/:id/task/:idTask/edit', {
                templateUrl: 'build/views/project/task/edit.html',
                controller: 'ProjectTaskEditController'
            })
            .when('/project/:id/task/:idTask/remove', {
                templateUrl: 'build/views/project/task/remove.html',
                controller: 'ProjectTaskRemoveController'
            })

            // Project Member
            .when('/project/:id/member', {
                templateUrl: 'build/views/project/member/list.html',
                controller: 'ProjectMemberListController'
            })
            .when('/project/:id/member/new', {
                templateUrl: 'build/views/project/member/new.html',
                controller: 'ProjectMemberNewController'
            })
            .when('/project/:id/member/:idMember/remove', {
                templateUrl: 'build/views/project/member/remove.html',
                controller: 'ProjectMemberRemoveController'
            });

        OAuthProvider.configure({
            baseUrl: appConfigProvider.config.baseUrl,
            clientId: 'appid1',
            clientSecret: 'secret',
            grantPath: 'oauth/access_token'
        });

        OAuthTokenProvider.configure({
            name: 'token',
            options: {
                secure: false
            }
        });

    }]);

app.run([

    '$rootScope', '$location', '$http', 'httpBuffer', '$modal', '$cookies', '$pusher', 'appConfig', 'Notification', 'OAuth',

    function ($rootScope, $location, $http, httpBuffer, $modal, $cookies, $pusher, appConfig, Notification, OAuth) {

        $rootScope.$on('pusher-build', function (event, data) {
            if (data.next.$$route.orignalPath != '/login') {
                if (OAuth.isAuthenticated()) {
                    if (!window.client) {
                        window.client = new Pusher(appConfig.pusherKey);
                        var pusher = $pusher(window.client);
                        var channel = pusher.subscribe('user.' + $cookies.getObject('user').id);
                        channel.bind('CodeProject\\Events\\TaskWasIncluded',
                            function (data) {
                                var name = data.projectTask.data.name, status = data.projectTask.data.status;
                                switch (parseInt(status)) {
                                    case 0:
                                        Notification.warning('Tarefa "' + name + '" foi incluída!');
                                        break;
                                    case 1:
                                        Notification.info('Tarefa "' + name + '" foi iniciada!');
                                        break;
                                    case 2:
                                        Notification.error('Tarefa "' + name + '" está atrasada!');
                                        break;
                                    case 3:
                                        Notification.success('Tarefa "' + name + '" foi concluída!');
                                        break;
                                }
                            }
                        );
                    }
                }
            }
        });

        $rootScope.$on('pusher-destroy', function (event, data) {
            if (data.next.$$route.orignalPath == '/login') {
                if (window.client) {
                    window.client.disconnect();
                    window.client = null;
                }
            }
        });

        $rootScope.$on('$routeChangeStart', function (event, next, current) {
            if (next.$$route.orignalPath != '/login') {
                if (!OAuth.isAuthenticated()) {
                    $location.path('login');
                }
            }
            $rootScope.$emit('pusher-build', {next: next});
            $rootScope.$emit('pusher-destroy', {next: next});
        });

        $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
            $rootScope.pageTitle = current.$$route.title;
        });

        $rootScope.$on('oauth:error', function (event, data) {
            // Ignore `invalid_grant` error - should be catched on `LoginController`.
            if ('invalid_grant' === data.rejection.data.error) {
                return;
            }

            // Refresh token when a `invalid_token` error occurs.
            if ('access_denied' === data.rejection.data.error) {
                httpBuffer.append(data.rejection.config, data.deferred);
                if (!$rootScope.loginModalOpened) {
                    var modalInstance = $modal.open({
                        templateUrl: 'build/views/templates/loginModal.html',
                        controller: 'LoginModalController'
                    });
                    $rootScope.loginModalOpened = true;
                }
                return;
            }

            // Redirect to `/login` with the `error_reason`.
            return $location.path('login');
        });
    }
])
;