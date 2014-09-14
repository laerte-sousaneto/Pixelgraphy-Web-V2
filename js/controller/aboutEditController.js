/**
 * Created by laerte on 9/14/2014.
 */

pixelApp.controller('aboutEditController', aboutEditController);

function aboutEditController($scope, $timeout, userService, dataModifier)
{
    $scope.showLoading = false;

    $scope.$on('profileUpdate', function()
    {
        if(userService.userProfile != null)
        {
            $scope.hobbies = userService.userProfile.hobbies;
            $scope.biography = userService.userProfile.biography;
        }

    });

    $scope.save = function()
    {
        $scope.showLoading = true;

        dataModifier.updateAboutInfo({'hobbies':$scope.hobbies, 'biography':$scope.biography}, function(data)
        {

            if(data == '1')
            {
                userService.updateUserProfile();

                $timeout(function()
                {
                    $scope.showLoading = false;
                    $scope.close();

                }, 1000);

            }

        });
    };

    $scope.reset = function()
    {
        $scope.hobbies = userService.userProfile.hobbies;
        $scope.biography = userService.userProfile.biography;
    };

    $scope.close = function()
    {
        $('#aboutEditModal').modal('hide');
    };


}