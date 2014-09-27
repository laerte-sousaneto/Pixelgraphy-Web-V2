/**
 * Created by Lae on 7/20/2014.
 */
'use strict';

pixelApp.controller('loginController', loginController);

function loginController($scope, dataAccessor, dataModifier, userService, uiService, $timeout)
{
    $scope.username = "";
    $scope.password = "";
    $scope.loginError = "";
    $scope.recoverError = "";
    $scope.hasLoginError = false;
    $scope.hasRecoverError = false;

    $scope.loadingImage = false;
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
            $scope.loadingImage = true;
        }

        dataAccessor.tryLogin($scope.username, $scope.password, function(data)
            {

                if(!data['error'])
                {
                    userService.setUserID(data['result']);
                    userService.loggedIn = true;
                    userService.notifyPropertyChanged('loggedIn');
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

    $scope.recoverPassword = function()
    {
        $scope.statusMsg = "Sending recover key to email.";
        $scope.statusSubMsg = "Please Wait.";
        $scope.statusPanel = true;
        $scope.loadingImage = true;

        if($scope.isEmailValid())
        {
            dataModifier.requestPasswordChange($scope.email, function(data)
            {
                $scope.loadingImage = false;

                if(!data['error'])
                {
                    $scope.statusMsg = "An email with intructions to reset your password was sent.";
                    $scope.statusSubMsg = "Please check your email";
                }
                else
                {
                    $scope.statusMsg = "There was an error";
                    $scope.statusSubMsg = data['msg'];

                    $scope.recoverError = data['msg'];
                    $scope.hasRecoverError = true;
                    $scope.statusPanel = false;
                }

                console.log(data);
            });
        }
    };

    $scope.previousPanel = function()
    {
        $scope.forgotPasswordPanel = false;
        $scope.statusPanel = false;
    };
}