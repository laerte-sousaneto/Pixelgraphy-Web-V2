/**
 * Created by Lae on 9/3/2014.
 */

pixelApp.controller('infoEditController', infoEditController);

function infoEditController($scope, $timeout, userService, dataModifier)
{
    $scope.showLoading = false;

    $scope.$on('profileUpdate', function()
    {
        if(userService.userProfile != null)
        {
            $scope.fullname = userService.userProfile.fullname;
            $scope.major = userService.userProfile.major;
            $scope.gender = userService.userProfile.gender;
            $scope.relationship = userService.userProfile.relationship;
            $scope.birthday = userService.userProfile.DOB;
        }

    });

    $scope.save = function()
    {
        $scope.showLoading = true;

        dataModifier.updateProfile({'fullname':$scope.fullname, 'major':$scope.major, 'gender':$scope.gender, 'relationship':$scope.relationship, 'birthday':$scope.birthday}, function(data)
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
        $scope.fullname = userService.userProfile.fullname;
        $scope.major = userService.userProfile.major;
        $scope.gender = userService.userProfile.gender;
        $scope.relationship = userService.userProfile.relationship;
        $scope.birthday = userService.userProfile.DOB;
    };

    $scope.close = function()
    {
        $('#infoEditModal').modal('hide');
    };

    //Datepicker setup
    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.today = function() {
        $scope.dt = new Date();
    };

    $scope.today();

    $scope.open = function($event) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened = true;
    };

}