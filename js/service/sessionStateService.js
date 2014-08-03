/**
 * Created by Lae on 7/28/2014.
 */

'use strict';

pixelApp.factory('sessionStateService', sessionStateService);

function sessionStateService($rootScope, $http )
{
    var service = [];

    service.getSessionField = function(field, onSuccess)
    {

        $http(
            {
                method  :   'POST',
                url     :   '../../php/getSessionState.php',
                data    :   $.param({'field':field}),
                headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
            }
        )
        .success(onSuccess);

    };

    service.closeSession = function(onSuccess)
    {
        $http(
            {
                method  :   'POST',
                url     :   '../../php/logout.php'
            }
        )
        .success(onSuccess);
    };

    return service;
}