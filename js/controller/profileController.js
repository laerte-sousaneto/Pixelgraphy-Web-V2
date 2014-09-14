/**
 * Created by Lae on 7/28/2014.
 */

'use strict';

pixelApp.controller('profileController', profileController);

function profileController($scope, userService, dataModifier)
{
    $scope.data = userService.userProfile;

    $scope.verticalTab = true;
    $scope.albums = userService.albums;

    $scope.showImages = false;
    $scope.albumImages = null;

    $scope.removalIndex = null;
    $scope.removalImageImage = null;

    $scope.albumRemovalIndex = null;
    $scope.removalAlbum = null;

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
    });

    $scope.$on('albums', function()
    {
        $scope.albums = userService.albums;
    });

    $scope.showAlbumImages = function(index)
    {
        $scope.showImages = true;
        $scope.albumImages = $scope.albums[index].images;
    };

    $scope.removeAlbum = function(index)
    {
        dataModifier.removeAlbum($scope.albums[index].ID, function(data)
        {
            if(data == true)
            {
                userService.updateAlbums();
            }
        });

        $('#albumRemovalModal').modal('hide');
    };

    $scope.removeImage = function(index)
    {
        dataModifier.removeImage($scope.albumImages[index].ID, function(data)
        {

            if(!data['error'])
            {
                $scope.albumImages.splice(index,1);
            }

            $('#imageRemovalModal').modal('hide');
        });
    };


    $scope.toggleImages = function()
    {
        $scope.showImages = !$scope.showImages;
    };

    $scope.openImageRemovalModal = function(index)
    {
        $('#imageRemovalModal').modal('show');

        $scope.removalIndex = index;
        $scope.removalImage = $scope.albumImages[index];
    };

    $scope.dismissImageRemovalModal = function()
    {
        $('#imageRemovalModal').modal('hide');
    };

    $scope.openAlbumRemovalModal = function(index)
    {
        $scope.albumRemovalIndex = index;
        $scope.removalAlbum = $scope.albums[index];

        console.log($scope.removalAlbum);

        $("#albumRemovalModal").modal('show');
    };

    $scope.dismissAlbumRemovalModal = function()
    {
        $("#albumRemovalModal").modal('hide');
    };

    $scope.openInfoEditModal = function()
    {
        $("#infoEditModal").modal('show');
    };

    $scope.openAboutEditModal = function()
    {
        $("#aboutEditModal").modal('show');
    };

    $scope.convertToDate = function (stringDate)
    {
        var dateOut = new Date(stringDate);
        dateOut.setDate(dateOut.getDate() + 1);
        return dateOut;
    };

    userService.updateAlbums();
    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

}
