/**
 * Created by Lae on 7/28/2014.
 */

'use strict';

pixelApp.controller('profileController', profileController);

function profileController($scope, userService, dataAccessor)
{
    $scope.homeSource = "http://userhome.laertesousa.com/";

    $scope.data = userService.userProfile;
    $scope.verticalTab = true;
    $scope.albums = userService.albums;

    $scope.showImages = false;
    $scope.albumImages = null;

    if($scope.albums == null)
    {
        userService.updateAlbums();
    }

    if(userService.userProfile == null)
    {
        userService.updateUserProfile();
    }

    $scope.$on('profileUpdate',function()
    {
        $scope.data = userService.userProfile;
        console.log($scope.data);
    });

    $scope.$on('albums', function()
    {
        $scope.albums = userService.albums;
    });


    $scope.showAlbumImages = function(albumID)
    {
        dataAccessor.getAlbumImages(albumID, function(data)
        {
            if(!data['error'])
            {
                $scope.showImages = true;
                setSource(data['result'], $scope.homeSource);
                $scope.albumImages = data['result'];

            }
        });
    };

    $scope.toggleImages = function()
    {
        $scope.showImages = !$scope.showImages;
    };

}