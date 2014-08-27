/**
 * Created by Lae on 7/14/2014.
 */

'use strict';

pixelApp.controller('homeController',homeController);

function homeController($scope, $interval, $timeout, dataAccessor, userService, uiService)
{
    $scope.homeSource = "http://userhome.laertesousa.com/";
    $scope.images = userService.globalImages;
    $scope.imageSelected = null;
    $scope.index = 0;
    $scope.lastBoxIndex = 0;

    $scope.imagePreview = true;


    var imageChangeInterval = 4000; //(milli seconds)
    var fadeInterval = 500;



    $scope.$watch('images', function()
    {
       if($scope.imageSelected != null)
       {
           $interval(function()
           {
              nextImage($scope, $timeout, fadeInterval);
           }, imageChangeInterval);
       }
       else
       {
           userService.updateGlobalImages();
       }

    });

    $scope.$on('globalImagesUpdate', function()
    {
        $scope.images = userService.globalImages;
        setImageBoxes($scope, 3);
    });

    $scope.$on('uiUpdate',function()
    {
        $scope.imagePreview = uiService.showHome;
    });



}

function setImageBoxes(scope, quantity)
{
    scope.imageSelected = new Array();

    for(var i = 0; i < quantity; i++)
    {
        scope.imageSelected.push({image:scope.images[i], show:true});

        scope.index++;
    }
}


function nextImage(scope, timeout, fadeInterval)
{
    scope.lastBoxIndex = nextBoxIndex(scope.lastBoxIndex, scope.imageSelected.length);

    var imageChangeInterval = 1000;

    if(scope.index < scope.images.length-1)
    {
        scope.index++;
    }
    else
    {
        scope.index = 0;
    }

    swapImage(scope,scope.lastBoxIndex, scope.images[scope.index], timeout, fadeInterval);
}

function nextBoxIndex(lastIndex, length)
{
    var boxIndex = Math.floor(Math.random() * length);

    while(boxIndex == lastIndex)
    {
        boxIndex = Math.floor(Math.random() * length);
    }

    return boxIndex
}

function swapImage(scope, index, newImage, timeout, fadeInterval)
{
    scope.imageSelected[index].show = false;

    timeout(function()
    {
        scope.imageSelected[index].image['ID'] = newImage['ID'];
        scope.imageSelected[index].image['username'] = newImage['username'];
        scope.imageSelected[index].image['name'] = newImage['name'];
        scope.imageSelected[index].image['description'] = newImage['description'];
        scope.imageSelected[index].image['directory'] = newImage['directory'];
        scope.imageSelected[index].image['date'] = newImage['date'];
        scope.imageSelected[index].show = true;

    }, fadeInterval);

}

function setSource(data, source)
{
    for(var x in data)
    {
        data[x].directory = source + data[x].directory;
    }

}

