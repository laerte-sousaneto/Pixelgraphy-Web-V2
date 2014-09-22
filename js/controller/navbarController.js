/**
 * Created by laerte on 9/21/2014.
 */

pixelApp.controller('navbarController', navbarController);

function navbarController($scope, userService, sessionStateService)
{
    userService.updateUserProfile(false);

    $scope.loggedIn = userService.loggedIn;
    $scope.showLogout = !$scope.loggedIn;
    $scope.showEnterPortal = false;

    $scope.$on('loggedIn', function()
    {
        $scope.loggedIn = userService.loggedIn;
        $scope.showLogout = !$scope.loggedIn;
    });

    $scope.logout = function()
    {
        sessionStateService.closeSession(function()
        {
            window.location.href='/';
            console.log('session closed');
        });
    };
}
