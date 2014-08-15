/**
 * Created by Lae on 8/7/2014.
 */
'use strict';

pixelApp.factory('dataModifier', function($http)
{

    return{
        createAlbum: function(name, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/createAlbum.php',
                    data    :   $.param({'name':name}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        },
        removeAlbum: function(id, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/removeAlbum.php',
                    data    :   $.param({'id':id}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        },
        removeImage: function(id, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/Modifiers/removeImage.php',
                    data    :   $.param({'id':id}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        }
    }
});