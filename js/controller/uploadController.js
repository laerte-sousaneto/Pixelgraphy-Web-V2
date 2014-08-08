/**
 * Created by Laerte on 8/5/2014.
 */

'use strict';

pixelApp.controller('uploadController', uploadController);


function uploadController($scope, $timeout, dataModifier, userService)
{
    $scope.newFiles = null;
    $scope.files = [];
    $scope.albums = [{'id':'0', 'name':'Album 1'},{'id':'1', 'name':'Album 2'}];
    $scope.selectedAlbum = $scope.albums[0];
    $scope.newAlbum = "";

    $scope.uploadLimit = 3;

    $scope.$watch('newFiles', function()
    {
        console.log('here');
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
                    'album':$scope.selectedAlbum,
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

    $scope.uploadFile = function(fileIndex)
    {
        var file = $scope.files[fileIndex];

        var url = "php/uploadImage.php";

        var xhr = new XMLHttpRequest();
        var fileData = new FormData();

        xhr.open("POST", url, true);

        xhr.onreadystatechange = function()
        {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle response.
                console.log(xhr.responseText);
               // var phpResponse = JSON.parse(xhr.responseText);

                console.log(phpResponse);
                if(!phpResponse['error'])
                {
                    $timeout(function()
                    {


                    },2000);
                }
            }
        };

        fileData.append('file', file.file);
        fileData.append('nameInput',file.name);
        fileData.append('album', file.album.id);
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

                console.log(phpResponse);
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
}


function setTempFile(file, source)
{
    file.source = source;
    console.log(source);
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
                console.log(element);

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


