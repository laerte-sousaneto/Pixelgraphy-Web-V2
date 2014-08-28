/**
 * Created by Lae on 8/27/2014.
 */

pixelApp.controller('resetPasswordController', resetPasswordController);

function resetPasswordController($scope, $routeParams, $timeout, dataModifier, userService)
{
    $scope.password = "";
    $scope.repeatPassword = "";
    $scope.code = $routeParams.code;

    $scope.statusPanel = false;
    $scope.statusMsg = "";
    $scope.statusSubMsg = "";
    $scope.resetError = "";
    $scope.hasError = false;

    $scope.isPasswordValid = function()
    {
        var regex = new RegExp("^(?=.*\\d)(?=.*[a-zA-Z]).{4,20}$");
        return regex.test($scope.password);
    };

    $scope.isRepeatPasswordValid = function()
    {
        var regex = new RegExp("^(?=.*\\d)(?=.*[a-zA-Z]).{4,20}$");
        return (regex.test($scope.repeatPassword) && ($scope.password == $scope.repeatPassword));
    };

    $scope.isAllFieldsValid = function()
    {
        return $scope.isPasswordValid() && $scope.isRepeatPasswordValid();
    }


    $scope.resetPassword = function()
    {
        if($scope.isAllFieldsValid())
        {
            $scope.statusPanel = true;
            $scope.statusMsg = "Resetting password... ";
            dataModifier.changePassword($scope.code, $scope.password, $scope.repeatPassword, function(data)
            {
                if(!data['error'])
                {
                    $scope.statusMsg = "Password was successfully reseted.";
                    $scope.statusSubMsg = "You will be logged in to the portal.";

                    userService.setUserID(data['userID']);

                    $timeout(function()
                    {
                        window.location.href = "#/portal";
                    }, 3000);

                }
                else
                {
                    $scope.statusPanel = false;
                    $scope.resetError = data['msg'];
                    $scope.hasError = true;
                }

            });
        }
    };

}
