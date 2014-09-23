/**
 * Created by Lae on 7/18/2014.
 */

'use strict'

pixelApp.factory('dataAccessor', function($http)
{
    var source = "http://pixel.laertesousa.com/";
    return{
        getAllUsers: function(onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/Accessors/getAllUsers.php'
                }
            ).success(onSuccess);
        },
        getImages: function(onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/Accessors/getMostRecentImages.php'
                }
            )
            .success(onSuccess);
        },
        getAlbums: function(onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/Accessors/getUserAlbums.php'
                    //url     :   'http://pixel.laertesousa.com/php/globalImagesInJSON.php'
                }
            )
            .success(onSuccess);
        },
        getAlbumsByUsername: function(username,onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/Accessors/getUserAlbumsByUsername.php',
                    data    :   $.param({'username':username}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            )
                .success(onSuccess);
        },
        getAlbumImages: function(albumID, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/Accessors/getAlbumImages.php',
                    //url     :   'http://pixel.laertesousa.com/php/login_check.php',
                    data    :   $.param({'albumID':albumID}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        },

        getComments: function(imageID, onSuccess)
        {
            $http(
                {
                    method : 'POST',
                    url : '../../php/Accessors/getImageComments.php',
                    data    :   $.param({'imageID':imageID}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        },

        tryLogin: function(username, password, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/Accessors/login_check.php',
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
                    url     :   '../../php/Accessors/getUserProfile.php',
                    data    :   $.param({'userID':id}),
                    headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
                }
            ).success(onSuccess);
        },
        getUserByUsername: function(username, onSuccess)
        {
            $http(
                {
                    method  :   'POST',
                    url     :   '../../php/Accessors/getUserProfileByUsername.php',
                    data    :   $.param({'username':username}),
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