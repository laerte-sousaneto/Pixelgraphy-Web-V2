/**
 * Created by Lae on 7/20/2014.
 */
'use strict';

pixelApp.controller('loginController', loginController);

function loginController($scope, dataAccessor, userService, uiService, $timeout)
{
    $scope.username = "laerte";
    $scope.password = "123";
    $scope.loginError = "";
    $scope.hasLoginError = false;

    $scope.statusPanel = false;
    $scope.statusMsg = "Logging In...";
    $scope.statusSubMsg = "Checking Credentials.";


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

                    console.log(data);

                    $scope.statusPanel = true;
                    $scope.hasLoginError = false;
                    $scope.loginError = data['error_msg'];

                    $scope.statusMsg = "Login Succesfull.";
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
                    console.log(data);
                    $scope.statusPanel = false;
                    $scope.hasLoginError = true;
                    $scope.loginError = data['error_msg'];

                }

            }
        );
    }

}