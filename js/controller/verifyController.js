/**
 * Created by Lae on 8/23/2014.
 */

pixelApp.controller('verifyController', verifyController);

function verifyController($scope, $routeParams, $timeout, dataModifier, userService)
{
    $scope.username = $routeParams.username;
    $scope.code = $routeParams.code;

    $scope.verified = false;
    $scope.inProcess = false;
    $scope.verificationComplete = false;
    $scope.error = false;
    $scope.status = "";
    $scope.subStatus = "";

    $scope.isUsernameValid = function()
    {
        var regex = new RegExp("^([a-zA-Z0-9\\-\\.]){4,20}$");
        return regex.test($scope.username);
    };

    $scope.isCodeValid = function()
    {
        var regex = new RegExp("^([0-9]){8}$");
        return regex.test($scope.code);
    };

    $scope.isAllFieldsValid= function()
    {
        return $scope.isUsernameValid() && $scope.isCodeValid();
    };

    $scope.verify = function()
    {
        if($scope.isAllFieldsValid())
        {
            $scope.error = false;
            $scope.inProcess = true;
            $scope.status = "Verifying account, please wait.";
            $scope.subStatus = "";
            dataModifier.verifyAccount($scope.username, $scope.code, function(data)
            {
                $timeout(function()
                {
                    if(!data['error'])
                    {
                        $scope.verificationComplete = true;
                        $scope.status = "Your username was successfully verified.";
                        $scope.subStatus = "You will automatically be logged in to the portal.";
                        userService.setUserID(data['userID']);

                        $timeout(function()
                            {
                                window.location.href = "#/portal";
                            }, 3000);
                    }
                    else
                    {
                        $scope.status = data['msg'];
                        $scope.subStatus = "Please check Username and Verification Code fields.";
                        $scope.inProcess = false;
                        $scope.error = true;
                    }
                },2000);


                console.log(data);
            });
        }

    }

}