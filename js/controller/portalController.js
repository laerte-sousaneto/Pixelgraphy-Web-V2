/**
 * Created by Laerte on 7/26/2014.
 */

'use strict'

pixelApp.controller('portalController', portalController);

function portalController($scope, userService)
{
    $scope.loggedIn = userService.loggedIn;

    userService.updateUserProfile(true);
    userService.updateGlobalImages();

    $scope.tabs = [
        {
            title:'Gallery',
            content:'Global Feed',
            active: false,
            icon: 'glyphicon-camera' ,
            url: 'directory/portal/globalfeed.html'
        },
        {
            title:'Profile',
            content:'Profile',
            active: true,
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

    $scope.$on('profileUpdate', function()
    {
        $scope.loggedIn = userService.loggedIn;
    });


    $scope.setTab = function(index)
    {
        $scope.template = $scope.tabs[index].url;
    }
}
