/**
 * Created by Lae on 7/14/2014.
 */

'use strict';

pixelApp.controller('homeCTRL',homeController);

function homeController($scope, $interval, $timeout, dataAccessor, userService)
{
    $scope.message = "<h1>Welcome to home.</h1>";
    $scope.homeSource = "http://userhome.laertesousa.com/";
    $scope.images = null;
    $scope.imageSelected = null;
    $scope.index = 0;
    $scope.lastBoxIndex = 0;

    $scope.imagePreview = true;


    $scope.userProfile = null;
    $scope.userImages = null;

    $scope.$on('profileUpdate',function()
    {
        $scope.userProfile = userService.userProfile;
    });

    $scope.$on('imagesUpdate',function()
    {
        console.log('here');
        $scope.userImages = userService.userImages;
    });

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

    $scope.signIn = function()
    {
        console.log("hello there home");
    }

    miscSetup();
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

function miscSetup()
{
    /*$('#signin').popover({
        //trigger: 'focus'
        template:   '<div class="popover" role="tooltip">' +
            '<form onsubmit="return false;" id="signInForm" >'+
            '<div class="arrow"></div>' +
            '<h3 class="popover-title"></h3>' +
            '<div>' +

            "" +
                "<div class='form-group container-fluid'>" +
                    "<div class='row'>" +
                        "<div class='col-lg-12'>" +
                            "<label class='src-only' for='username'>Username</label>" +
                            "<input type='text' class='form-control' id='username' name='username' placeholder='Enter Username' />" +
                            "<label class='src-only' for='password'>Password</label>" +
                            "<input type='password' class='form-control' id='password' name='password' placeholder='Enter Password' />" +
                        "</div>" +
                    "</div>" +
                    "<div class='row text-center'>" +
                        "<div class='col-lg-12'>" +
                            "<button  id='login'  class='btn btn-md btn-primary md-margin'" +
                                       "ng-click='signIn()'>Sign In!</button>" +
                        "</div>" +
                        "<div class='col-lg-12'>" +
                            "<a class='nav'>Forgot Password?</a>" +
                        "</div>" +
                    "</div>" +
                "</div>"+

            '</div>' +
            "<form>"+
            '</div>'
    });*/

}


pixelApp.directive('popOver', function ($compile) {

    /*var itemsTemplate = "<ul class='unstyled'><li ng-repeat='item in items'>{{item}}</li></ul>";
    var getTemplate = function (contentType) {
        var template = '';
        switch (contentType) {
            case 'items':
                template = itemsTemplate;
                break;
        }
        return template;
    }*/

    return {
        template: "<span></span>",
        link: function (scope, element, attrs)
        {
            var popOverContent = "<button id ='customSign' onclick=\"alert(scope.message)\">Here</button>";

            console.log(scope.images);
            console.log(scope.message);

            element.bind('mouseenter',function()
            {
                //alert('here');
                console.log(scope.images);
                scope.$apply("signIn()");
            });

            var options = {
                content: popOverContent,
                placement: "bottom",
                html: true,
                title: scope.title
            };

            $(element).popover(options);

            $("#customSign").bind('click',function()
            {
                //scope.$apply("signIn()");
                alert('here');
            });
        }
    };
});