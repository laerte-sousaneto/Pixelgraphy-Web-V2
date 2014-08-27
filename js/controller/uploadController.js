/**
 * Created by Laerte on 8/5/2014.
 */

'use strict';

pixelApp.controller('uploadController', uploadController);


function uploadController($scope, $timeout, dataModifier, userService)
{
    $scope.newFiles = null;
    $scope.files = [];
    $scope.albums = userService.albums;
    $scope.newAlbum = "";

    $scope.uploadLimit = 3;

    $scope.$watch('newFiles', function()
    {
        if($scope.newFiles != null && notUploadedCount($scope.files.length) < $scope.uploadLimit)
        {
            var length = $scope.newFiles.length;

            for(var x = 0; x < length; x++)
            {
                var fileInfo = $scope.newFiles[x];

                var entry =
                {
                    'file':fileInfo,
                    'name':"",
                    'description':"",
                    'album':null,
                    'size':fileInfo.size,
                    'type':fileInfo.type,
                    'status':'active',
                    'loading':false,
                    'uploaded':false,
                    'response':"",
                    'progress':"0",
                    'source':"image/loading.gif"

                };

                $scope.files.push(entry);

                $scope.sendTempFile($scope.files.length-1);

            }

            $scope.newFiles = null;
        }

    });

    $scope.$on('albums', function()
    {
        $scope.albums = userService.albums;
    });

    $scope.uploadFile = function(fileIndex)
    {
        var file = $scope.files[fileIndex];

        var url = "php/Modifiers/uploadImage.php";

        var xhr = new XMLHttpRequest();
        var fileData = new FormData();

        xhr.open("POST", url, true);

        xhr.onreadystatechange = function()
        {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle response.
                console.log(xhr.responseText);
               // var phpResponse = JSON.parse(xhr.responseText);

                //console.log(phpResponse);
                /*if(!phpResponse['error'])
                {
                    $timeout(function()
                    {


                    },2000);
                }*/
            }
        };

        xhr.upload.addEventListener("progress", function(e)
        {

            if (e.lengthComputable)
            {
                console.log('here');
                var percentage = Math.round((e.loaded * 100) / e.total);

                if(percentage == 100)
                {
                    $scope.$apply(function(){$scope.files[fileIndex].uploaded = true});
                    //userService.updateAlbums();
                }

                $scope.$apply(function(){$scope.files[fileIndex].progress = percentage});
            }
        }, false);

        fileData.append('file', file.file);
        fileData.append('nameInput',file.name);
        fileData.append('album', file.album.ID);
        fileData.append('descriptionInput', file.description);
        fileData.append('isProfile', false);

        // Initiate a multipart/form-data upload
        xhr.send(fileData);
    };

    $scope.sendTempFile = function(fileIndex)
    {
        var file = $scope.files[fileIndex];

        var url = "php/uploadTempImage.php";

        var xhr = new XMLHttpRequest();
        var fileData = new FormData();

        xhr.open("POST", url, true);

        xhr.onreadystatechange = function()
        {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle response.

                var phpResponse = JSON.parse(xhr.responseText);

                //console.log(phpResponse);
                if(!phpResponse['error'])
                {
                    $timeout(function()
                    {
                        $scope.$apply(setTempFile($scope.files[fileIndex],phpResponse['data']));
                        console.log(phpResponse['data']);
                    },2000);
                }
            }
        };

        fileData.append('file', file.file);

        // Initiate a multipart/form-data upload
        xhr.send(fileData);

    };

    $scope.createAlbum = function()
    {
        if($scope.newAlbum.length > 0)
        {
            dataModifier.createAlbum($scope.newAlbum.trim(), function(data)
            {
                if(data == true)
                {
                    userService.updateAlbums();
                    $scope.newAlbum = "";
                }

            });
        }

    }

    $scope.isAlbumValid = function()
    {
        var regex = new RegExp("^(([a-zA-Z0-9\\s]){3,25})$");
        return regex.test($scope.newAlbum);
    }

    $scope.isAlbumSelected = function(album)
    {
        return album != null;
    }

    $scope.isNameValid = function(name)
    {
        var regex = new RegExp("^(([a-zA-Z0-9\\s\\.\\'\\()\\%\\@\\:\\,]){3,25})$");
        return regex.test(name);
    }

    $scope.isDescriptionValid = function(description)
    {
        var regex = new RegExp("^(([a-zA-Z0-9\\s\\n\\.\\'\\()\\%\\@\\:\\,]){10,150})$");
        return regex.test(description);
    }

    $scope.isUploadEnabled = function(fileIndex)
    {
        return ($scope.isNameValid($scope.files[fileIndex].name)
            && $scope.isDescriptionValid($scope.files[fileIndex].description)
            && $scope.isAlbumSelected($scope.files[fileIndex].album)
            && !$scope.files[fileIndex].uploaded);
    }

    userService.updateAlbums();
}


function setTempFile(file, source)
{
    file.source = source;
}
/*
 Directive used to read file from input, while using 2 way binding.
 */
pixelApp.directive("readFile", function ($timeout)
{
    return {

        link: function (scope, element)
        {

            element.unbind("change").bind("change", function (changeEvent)
            {

                if(!scope.$$phase)
                {
                    $timeout(function()
                    {
                        scope.$apply(function(){scope.newFiles = changeEvent.target.files;});
                    },500);

                }

            });



        }
    }
});

function handleEvent(scope, changeEvent)
{
    scope.newFiles = changeEvent.target.files;
}


function notUploadedCount(files)
{
    var length = files.length;
    var count = 0;

    for( var i = 0; i < length; i++)
    {
        if(!files[i].uploaded)
        {
            count++;
        }
    }

    return count;
}


