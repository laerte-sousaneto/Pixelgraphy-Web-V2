/**
 * Created by Laerte on 7/26/2014.
 */

'use strict';

pixelApp.factory('uiService', function($rootScope)
{
    var service = {};

    service.showHome = true;

    service.setShowHome = function(show)
    {
        if(this.showHome != show)
        {
            this.showHome = show;
            this.broadcastUpdate();
        }
    };

    service.broadcastUpdate = function()
    {
        $rootScope.$broadcast('uiUpdate');
    }

    return service;
});
