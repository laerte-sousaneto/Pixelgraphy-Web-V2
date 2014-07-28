/**
 * Created by Laerte on 7/26/2014.
 */

'use strict'

pixelApp.controller('portalController', portalController);

function portalController($scope)
{
    $scope.tabs = [
        {
            title:'Global Feed',
            content:'Global Feed',
            disabled: false,
            url: 'directory/portal/globalfeed.html'
        },
        {
            title:'Profile',
            content:'Profile',
            disabled: false,
            url: 'directory/portal/profile.html'
        },
        {
            title:'Upload Images',
            content:'',
            disabled: false
        },
        {
            title:'Settings',
            content:'',
            disabled: false
        },
        {
            title:'Logout',
            content:'',
            disabled: false
        }
    ];


    $scope.template = $scope.tabs[0].url;

    $scope.setTab = function(index)
    {

        $scope.template = $scope.tabs[index].url;
    }
}
