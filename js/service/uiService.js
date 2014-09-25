/**
 * Created by Laerte on 7/26/2014.
 */

'use strict';

pixelApp.factory('uiService', function($rootScope)
{
    var service = {};

    service.showHome = true;
    service.portalTab = false;

    service.setShowHome = function(show)
    {
        if(this.showHome != show)
        {
            this.showHome = show;
            this.broadcastUpdate();
        }
    };

    service.enableHomeTab = function()
    {
        service.notifyPropertyChanged('enableHomeTab');
    };

    service.enablePortalTab = function()
    {
        service.notifyPropertyChanged('enablePortalTab');
    };

    service.enableFeedbackTab = function()
    {
        service.notifyPropertyChanged('enableFeedbackTab');
    };

    service.enableAboutTab = function()
    {
        service.notifyPropertyChanged('enableAboutTab');
    };

    service.notifyPropertyChanged = function(propertyName)
    {
        $rootScope.$broadcast(propertyName);
    };

    service.broadcastUpdate = function()
    {
        $rootScope.$broadcast('uiUpdate');
    };

    return service;
});
