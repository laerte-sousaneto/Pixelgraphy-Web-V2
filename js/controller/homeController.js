/**
 * Created by Lae on 7/14/2014.
 */

'use strict';

pixelApp.controller('homeController',homeController);

function homeController($scope, $interval, $timeout, userService, uiService)
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
       if($scope.imageSelected != null && $scope.images != null)
       {
           $interval(function()
           {
               if($scope.index < $scope.images.length)
               {
                   nextImage($scope, $timeout, fadeInterval);
               }

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
    scope.imageSelected = [];

    for(var i = 0; i < quantity; i++)
    {
        scope.imageSelected[i] = [];
        scope.imageSelected[i].image = [];
        scope.imageSelected[i].image['ID'] = scope.images[i]['ID'];
        scope.imageSelected[i].image['username'] = scope.images[i]['username'];
        scope.imageSelected[i].image['name'] = scope.images[i]['name'];
        scope.imageSelected[i].image['description'] = scope.images[i]['description'];
        scope.imageSelected[i].image['directory'] = scope.images[i]['directory'];
        scope.imageSelected[i].image['date'] = scope.images[i]['date'];
        scope.imageSelected[i].show = true;

        scope.index++;
    }
}

function nextImage(scope, timeout, fadeInterval)
{
    scope.lastBoxIndex = nextBoxIndex(scope.lastBoxIndex, scope.imageSelected.length);

    nextImageIndex(scope);

    swapImage(scope,scope.lastBoxIndex, scope.images[scope.index], timeout, fadeInterval);
}

function nextImageIndex(scope)
{
    if(scope.index < scope.images.length-1)
    {
        scope.index++;
    }
    else
    {
        scope.index = 0;
    }

    return scope.index;
}

function nextBoxIndex(lastIndex, length)
{
    var boxIndex = Math.floor(Math.random() * length);

    while(boxIndex == lastIndex)
    {
        boxIndex = Math.floor(Math.random() * length);
    }

    return boxIndex;
}

function swapImage(scope, index, newImage, timeout, fadeInterval)
{
    scope.imageSelected[index].show = false;

    timeout(function()
    {
        if(!isImageSelectedDuplicate(newImage['ID'], scope))
        {
            scope.imageSelected[index].image['ID'] = newImage['ID'];
            scope.imageSelected[index].image['username'] = newImage['username'];
            scope.imageSelected[index].image['name'] = newImage['name'];
            scope.imageSelected[index].image['description'] = newImage['description'];
            scope.imageSelected[index].image['directory'] = newImage['directory'];
            scope.imageSelected[index].image['date'] = newImage['date'];
            scope.imageSelected[index].show = true;
        }
        else
        {
            nextImageIndex(scope);
            swapImage(scope,scope.lastBoxIndex, scope.images[scope.index], timeout, fadeInterval);
        }


    }, fadeInterval);

}

function isImageSelectedDuplicate(id, scope)
{
    var isDuplicate = false;

    for(var index in scope.imageSelected)
    {
        if(scope.imageSelected[index].image.ID == id)
        {
            isDuplicate = true;
        }
    }

    return isDuplicate;
}

function setSource(data, source)
{
    for(var x in data)
    {
        data[x].directory = source + data[x].directory;
    }

}

