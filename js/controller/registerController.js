/**
 * Created by Lae on 7/21/2014.
 */

'use strict';

pixelApp.controller('registerController', registerController);

function registerController($scope)
{
    $scope.username = "laerte";

    $scope.login = true;

    $scope.register = false;

    $scope.signIn = function()
    {
        console.log("hello there");
    }
}
