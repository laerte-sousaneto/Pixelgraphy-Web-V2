/**
 * Created by Lae on 7/18/2014.
 */

'use strict'

pixelApp.factory('dataAccessor', function($http)
{
    var source = "http://pixel.laertesousa.com/";
    return{


        getImages: function(onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/globalImagesInJSON.php'
                    //url     :   'http://pixel.laertesousa.com/php/globalImagesInJSON.php'
                }
            )
            .success(onSuccess);
        },

        tryLogin: function(username, password, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/login_check.php',
                    //url     :   'http://pixel.laertesousa.com/php/login_check.php',
                    data    :   $.param({'username':username, 'password':password}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        },

        checkSession: function(userID, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    //url     :   '../../php/login_check.php',
                    url     :   'http://pixel.laertesousa.com/php/checkSession.php',
                    data    :   $.param({'userID':userID}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        },

        getUser: function(id, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/getUser.php',
                    data    :   $.param({'userID':id}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        },
        getUserImages: function(id, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/userImagesInJSON.php',
                    data    :   $.param({'userID':id}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        }

    }
});