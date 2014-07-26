/**
 * Created by Lae on 7/14/2014.
 */

'use strict';

pixelApp.controller('homeController',homeController);

function homeController($scope, $interval, $timeout, dataAccessor, userService, uiService)
{
    $scope.homeSource = "http://userhome.laertesousa.com/";
    $scope.images = null;
    $scope.imageSelected = null;
    $scope.index = 0;
    $scope.lastBoxIndex = 0;

    $scope.imagePreview = true;

    $scope.userProfile = null;
    $scope.userImages = null;



    var imageChangeInterval = 4000; //(milli seconds)
    var fadeInterval = 500;

    dataAccessor.getImages(function(data)
    {
        $scope.images = data;
        setSource(data,$scope.homeSource);

        setImageBoxes($scope, 3);
    });

    $scope.$watch('images', function()
    {
       if($scope.imageSelected != null)
       {
           $interval(function()
           {
              nextImage($scope, $timeout, fadeInterval);
           }, imageChangeInterval);
       }
    });

    $scope.$watch('imagePreview',function()
    {
       if($scope.imagePreview == false)
       {

            $('#imageGallery').hide('fast', function()
            {
                //$scope.loginPanel = !$scope.imagePreview;
            });

       }
       else
       {
           $('#imageGallery').show('fast', function()
           {

           });

       }

    });

    //Broadcast Handlers
    $scope.$on('profileUpdate',function()
    {
        $scope.userProfile = userService.userProfile;
    });

    $scope.$on('imagesUpdate',function()
    {
        console.log('here');
        $scope.userImages = userService.userImages;
    });

    $scope.$on('uiUpdate',function()
    {
        $scope.imagePreview = uiService.showHome;
    });

}

function trySignIn(event)
{
    var username = $("#signInForm").get(0).username.value.trim();
    var password = $("#signInForm").get(0).password.value.trim();
    alert(username +" "+ password);
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

