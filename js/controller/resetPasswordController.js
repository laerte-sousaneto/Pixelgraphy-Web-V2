/**
 * Created by Lae on 8/27/2014.
 */

pixelApp.controller('resetPasswordController', resetPasswordController);

function resetPasswordController($scope, $routeParams, dataModifier)
{
    $scope.username = "";
    $scope.password = "";
    $scope.repeatPassword = "";
    $scope.code = $routeParams.code;

    $scope.isUsernameValid = function()
    {
        var regex = new RegExp("^([a-zA-Z0-9\\-\\.]){4,20}$");
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

    $scope.isAllFieldsValid = function()
    {
        return $scope.isUsernameValid() && $scope.isPasswordValid() && $scope.isRepeatPasswordValid();
    }


    $scope.resetPassword = function()
    {
        if($scope.isAllFieldsValid())
        {
            dataModifier.changePassword($scope.code, $scope.password, $scope.repeatPassword, function(data)
            {
                console.log(data);
            });
        }
    };

}
