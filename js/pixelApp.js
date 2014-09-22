/**
 * Created by Lae on 7/14/2014.
 */

'use strict';

var pixelApp = angular.module('pixelApp',['ngRoute', 'ui.utils', "ui.scroll", "ui.scroll.jqlite", 'ui.bootstrap']);


pixelApp.config(['$routeProvider','$locationProvider',
    function($routeProvider, $locationProvider)
    {
        $routeProvider.when('/',
            {
                templateUrl: '../directory/home.html',
                controller: 'homeController'
            }
        ).
        when('/portal',
            {
                templateUrl: '../directory/portal.html',
                controller: 'portalController'
            }
        ).
        when('/about',
            {
                templateUrl: '../directory/about.html',
                controller: 'aboutController'
            }
        ).
        when('/feedback',
            {
                templateUrl: '../directory/feedback.html',
                controller: 'feedbackController'
            }
        )
        .when('/verify/:username/:code',
            {
                templateUrl: '../directory/verify.html',
                controller: 'verifyController'
            }
        ).
        when('/resetpassword/:code',
            {
                templateUrl: '../directory/resetPassword.html',
                controller: 'resetPasswordController'
            }
        ).
        when('/profile/:username',
            {
                templateUrl: '../directory/publicProfile.html',
                controller: 'publicProfileController'
            }
        ).
        otherwise(
            {
                redirectTo: '/'
            }
        );

        //$locationProvider.html5Mode(true)
    }
]);



pixelApp.directive('whenScrolled', function() {
    return function(scope, elm, attr) {
        var raw = elm[0];

        elm.bind('scroll', function() {
            if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight)
            {
                scope.$apply(attr.whenScrolled);
            }
        });
    };
});
