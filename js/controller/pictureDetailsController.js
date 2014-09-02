
pixelApp.controller('pictureDetailsController', pictureDetailsController);

function pictureDetailsController($scope, userService)
{
    $scope.image = userService.selectedImage;

    $scope.$on('SelectedImage', function()
    {
       $scope.image = userService.selectedImage;
       $scope.image.directory = $scope.image.directory.replace("_homepage", "");
        console.log($scope.image);
    });
}
