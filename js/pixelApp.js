/**
 * Created by Lae on 7/14/2014.
 */

'use strict';

var pixelApp = angular.module('pixelApp',['ngRoute', 'ui.utils', "ui.scroll", "ui.scroll.jqlite", 'ui.bootstrap']);


pixelApp.config(function routing($routeProvider)
{
    $routeProvider.when('/',
        {
            templateUrl: '../directory/home.html',
            controller: 'homeController'
        }
    );

    $routeProvider.when('/portal',
        {
            templateUrl: '../directory/portal.html',
            controller: 'portalController'
        }
    );

    $routeProvider.when('/about',
        {
            templateUrl: '../directory/about.html',
            controller: 'aboutController'
        }
    );

    $routeProvider.when('/feedback',
        {
            templateUrl: '../directory/feedback.html',
            controller: 'feedbackController'
        }
    );

    $routeProvider.otherwise(
        {
            redirectTo: '/'
        }
    );
});


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

function setSource(data, source)
{
    for(var x in data)
    {
        data[x].directory = source + data[x].directory;
    }

}


function setDirectorySource(data, source, field)
{
    data[field] = source + data[field];

    return data;
}

