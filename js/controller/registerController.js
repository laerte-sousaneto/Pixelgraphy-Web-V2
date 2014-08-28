/**
 * Created by Lae on 7/21/2014.
 */

'use strict';

pixelApp.controller('registerController', registerController);

function registerController($scope, $timeout, dataModifier)
{
    $scope.password = "";
    $scope.repeatPassword = "";
    $scope.email = "";

    $scope.password = "lta86t7v";
    $scope.repeatPassword = "lta86t7v";
    $scope.email = "sousa.lae@gmail.com";

    $scope.registered = false;
    $scope.inProcess = false;
    $scope.statusMsg = "";
    $scope.statusSubMsg = "";

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
        return regex.test($scope.email);
        //return true;
    };

    $scope.isAllFieldsValid = function()
    {
        return $scope.isPasswordValid() && $scope.isRepeatPasswordValid() && $scope.isEmailValid();
    }


    $scope.register = function()
    {
        if($scope.isAllFieldsValid())
        {
            $scope.statusMsg = "Registering your account...";
            $scope.statusSubMsg = "Checking given information.";
            $scope.inProcess = true;

            dataModifier.register($scope.email,$scope.password, $scope.repeatPassword, function(data)
            {
                {
                    if(!data['error'])
                    {
                        console.log(data);
                        $scope.statusMsg = "Account successfully registered.";
                        $scope.statusSubMsg = "Please check your email for validation code.";
                        $scope.registered = true;
                    }
                    else
                    {
                        console.log(data);
                        $scope.statusMsg = data['msg'];
                        $scope.statusSubMsg = "";
                        $scope.inProcess = false;
                    }
                }

            });
        }

    };

    $scope.goToVerify = function()
    {
        $('#registerModal').modal('hide');

        $timeout(function()
        {
            window.location.href = "http://pixel.laertesousa.com/#/verify/%20/%20";
        },300);

    };
}
