/**
 * Created by Laerte on 7/26/2014.
 */

'use strict'

pixelApp.controller('portalController', portalController);

function portalController($scope, sessionStateService)
{

    $scope.tabs = [
        {
            title:'Gallery',
            content:'Global Feed',
            disabled: false,
            icon: 'glyphicon-camera' ,
            url: 'directory/portal/globalfeed.html'
        },
        {
            title:'Profile',
            content:'Profile',
            active: true,
            disabled: false,
            icon: 'glyphicon-user' ,
            url: 'directory/portal/profile.html'
        },
        {
            title:'Upload',
            content:'',
            active: false,
            url: 'directory/portal/upload.html',
            icon: 'glyphicon-picture' ,
            disabled: false
        }
    ];

    //$scope.template = $scope.tabs[1].url;

    $scope.setTab = function(index)
    {
        $scope.template = $scope.tabs[index].url;
    }

    $scope.logout = function()
    {
        sessionStateService.closeSession(function()
        {
            window.location.href='/';
            console.log('session closed');
        });
    };



}
