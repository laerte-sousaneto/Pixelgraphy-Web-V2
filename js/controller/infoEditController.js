/**
 * Created by Lae on 9/3/2014.
 */

pixelApp.controller('infoEditController', infoEditController);

function infoEditController($scope, userService, dataModifier)
{

    $scope.$on('profileUpdate', function()
    {
        if(userService.userProfile != null)
        {
            $scope.fullname = userService.userProfile.fullname;
            $scope.major = userService.userProfile.major;
            $scope.gender = userService.userProfile.gender;
            $scope.relationship = userService.userProfile.relationship;
            $scope.birthday = userService.userProfile.birthday;
        }

    });


    $scope.save = function()
    {
        dataModifier.updateProfile({'fullname':$scope.fullname, 'major':$scope.major, 'relationship':$scope.relationship, 'birthday':$scope.birthday}, function(data)
        {
            console.log(data);
            userService.updateUserProfile()
        });
    };

    $scope.reset = function()
    {

    };

}