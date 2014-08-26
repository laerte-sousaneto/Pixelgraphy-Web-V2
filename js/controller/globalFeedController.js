/**
 * Created by Lae on 7/28/2014.
 */
'use strict';

pixelApp.controller('globalFeedController', globalFeedController);

function globalFeedController($scope, userService)
{
    $scope.images = userService.globalImages;

    $scope.loadMore = function()
    {
        if($scope.images != null)
        {
            if($scope.counter < $scope.images.length)
            {
                if($scope.counter == 0)
                {
                    while($scope.counter < 3 && $scope.images.length > 0  && $scope.images.length > $scope.counter)
                    {
                        $scope.items.push({id: $scope.counter, image: $scope.images[$scope.counter]});
                        $scope.counter++;
                    }
                }
                else
                {
                    $scope.items.push({id: $scope.counter, image: $scope.images[$scope.counter]});
                    $scope.counter++;
                }

            }
            else
            {
                console.log('no more');
            }

        }

    };

    if($scope.items == null | $scope.items == 'undefined')
    {
        $scope.counter = 0;
        $scope.items = [];
    }

    if(userService.globalImages == null)
    {
        userService.updateGlobalImages();
    }
    else
    {
        $scope.images = userService.globalImages;
        $scope.loadMore();
    }



    $scope.$on('globalImagesUpdate', function()
    {
        $scope.images = userService.globalImages;
        $scope.loadMore();

    });

    userService.updateGlobalImages();
}
