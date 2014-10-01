
pixelApp.controller('pictureDetailsController', pictureDetailsController);

function pictureDetailsController($scope, $timeout, userService, dataModifier)
{
    $scope.image = userService.selectedImage;
    $scope.original = "";
    $scope.comment = "";
    $scope.scrollDiv = document.getElementById('#commentScroll');


    $scope.$on('SelectedImage', function()
    {
        $scope.image = userService.globalImages[userService.selectedImageIndex];
        $scope.original = $scope.image.directory;
        $scope.original = $scope.original.replace("_homepage", "");

        $scope.scrollDiv = document.getElementById('commentScroll');
        $scope.scrollDiv.scrollTop = $scope.scrollDiv.scrollHeight;
    });

    $scope.$on('globalImagesUpdate', function()
    {
        $scope.comment = "";
        $scope.image = userService.globalImages[userService.selectedImageIndex];

        $timeout(function()
        {
            $scope.scrollDiv = document.getElementById('commentScroll');
            $scope.scrollDiv.scrollTop = $scope.scrollDiv.scrollHeight;
        }, 500);


    });

    $scope.isCommentValid = function()
    {
        var regex = new RegExp("^([^ƒ\\^]{10,150})$");
        return regex.test($scope.comment);
    };

    $scope.addComment = function()
    {
        dataModifier.addComment($scope.image.ID, $scope.comment, function(data)
        {
            userService.updateGlobalImages();
        });
    };

    $('a').click(function(){
        $('#pictureDetailsModal').modal('hide');
    });

    $scope.visitProfile = function(username)
    {
        $('#pictureDetailsModal').modal('hide');
        $('#pictureDetailsModal').on('hidden.bs.modal', function (e)
        {
            window.location.href = "http://pixel.laertesousa.com/#/profile/"+username;
        });

    };

    $scope.visitProfile = function(username)
    {
        $('#pictureDetailsModal').modal('hide');
        $('#pictureDetailsModal').on('hidden.bs.modal', function (e)
        {
            window.location.href = "http://pixel.laertesousa.com/#/profile/"+username;
        });

    };

}
