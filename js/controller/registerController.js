/**
 * Created by Lae on 7/21/2014.
 */

'use strict';

pixelApp.controller('registerController', registerController);

function registerController($scope, dataModifier)
{
    $scope.username = "";
    $scope.password = "";
    $scope.repeatPassword = "";
    $scope.email = "";


    $scope.isUsernameValid = function()
    {
        var regex = new RegExp("^([a-zA-Z0-9]){4,20}$");
        return regex.test($scope.username);
    };

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

    $scope.isEmailValid = function()
    {
        var regex = new RegExp("^([a-z0-9._%+-]+(@purchase+\.edu))$");
        //return regex.test($scope.email);
        return true;
    };

    $scope.isAllFieldsValid = function()
    {
        return $scope.isUsernameValid() && $scope.isPasswordValid() && $scope.isRepeatPasswordValid() && $scope.isEmailValid();
    }


    $scope.register = function()
    {
        if($scope.isAllFieldsValid())
        {
            dataModifier.register($scope.username,$scope.password, $scope.repeatPassword, $scope.email, function(data)
            {
                {
                    console.log(data);
                }

            });
        }

    };
}
