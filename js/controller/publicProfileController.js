/**
 * Created by laerte on 9/21/2014.
 */

pixelApp.controller('publicProfileController', publicProfileController);

function publicProfileController($scope, $routeParams, dataAccessor)
{
    $scope.username = $routeParams.username;
    $scope.albums = [];
    $scope.albumImages = [];

    $scope.showImages = false;

    $scope.loading = true;
    $scope.showProfile = false;

    dataAccessor.getUserByUsername($scope.username, function(data)
    {
        //console.log(data);
        if(!data['error'])
        {
            $scope.data = data['result'];
            dataAccessor.getAlbumsByUsername($scope.username, function(albumData)
            {
                if(!albumData['error'])
                {
                    $scope.albums = albumData['result'];
                    dataAccessor.getAlbumsByUsername($scope.username, function(albumData)
                    {
                        if(!albumData['error'])
                        {
                            $scope.albums = albumData['result'];
                            $scope.showProfile = true;
                        }
                    });
                }
            });
        }
        else
        {
            $scope.loading = false;
        }

    });

    $scope.showAlbumImages = function(index)
    {
        $scope.showImages = true;
        $scope.albumImages = $scope.albums[index].images;
    };
    $scope.toggleImages = function()
    {
        $scope.showImages = !$scope.showImages;
    };
    $scope.convertToDate = function (stringDate)
    {
        var dateOut = new Date(stringDate);
        dateOut.setDate(dateOut.getDate() + 1);
        return dateOut;
    };
}

