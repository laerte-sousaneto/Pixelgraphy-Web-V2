/**
 * Created by Lae on 7/20/2014.
 */
'use strict';

pixelApp.controller('loginController', loginController);

function loginController($scope, dataAccessor, userService, uiService, $timeout)
{
    $scope.username = "sousa";
    $scope.password = "lta86t7v";
    $scope.loginError = "";
    $scope.hasLoginError = false;

    $scope.forgotPasswordPanel = false;
    $scope.statusPanel = false;
    $scope.statusMsg = "Logging In...";
    $scope.statusSubMsg = "Checking Credentials.";

    //ForgotPassword
    $scope.email = "";


    $scope.isEmailValid = function()
    {
        var regex = new RegExp("^([a-z0-9._%+-]+(@purchase+\.edu))$");
        return regex.test($scope.email);
        //return true;
    };

    $scope.validate = function()
    {
        return $scope.hasLoginError;
    }

    $scope.signIn = function()
    {
        if(true)
        {
            $scope.statusPanel = true;
        }

        dataAccessor.tryLogin($scope.username, $scope.password, function(data)
            {

                if(!data['error'])
                {
                    userService.setUserID(data['result']);
                    //$("#loginModal").modal('hide');

                    $scope.statusPanel = true;
                    $scope.hasLoginError = false;
                    $scope.loginError = data['error_msg'];

                    $scope.statusMsg = "Login Successful.";
                    $scope.statusSubMsg = "Loading Portal!";

                    uiService.setShowHome(false);

                    $timeout(function()
                    {
                        window.location.href = "#/portal";
                        $("#loginModal").modal('hide');
                        $scope.statusPanel = false;
                    }, 3000);

                }
                else
                {
                    $scope.statusPanel = false;
                    $scope.hasLoginError = true;
                    $scope.loginError = data['error_msg'];

                }

            }
        );
    }

}