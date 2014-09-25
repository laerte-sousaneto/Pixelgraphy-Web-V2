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

    $scope.tabs = [
        {
            title:'Home',
            content:'Global Feed',
            active: true,
            icon: 'glyphicon-camera' ,
            url: '#'
        },
        {
            title:'Portal',
            content:'Profile',
            active: false,
            disabled: true,
            icon: 'glyphicon-user' ,
            url: '#/portal'
        },
        {
            title:'About',
            content:'',
            active: false,
            url: '#/about',
            icon: 'glyphicon-picture' ,
            disabled: false
        },
        {
            title:'Feedback',
            content:'',
            active: false,
            url: '#/feedback',
            icon: 'glyphicon glyphicon-search' ,
            disabled: false
        }
    ];

    $scope.$on('loggedIn', function()
    {
        $scope.loggedIn = userService.loggedIn;
        $scope.showLogout = !$scope.loggedIn;

        if($scope.loggedIn)
        {
            $scope.tabs[1].disabled = false;
        }
        else
        {
            $scope.tabs[1].disabled = true;
        }
    });

    $scope.$on('enablePortalTab', function()
    {
        $scope.selectTab(1);
    });

    $scope.logout = function()
    {
        sessionStateService.closeSession(function()
        {
            window.location.href='/';
            console.log('session closed');
        });
    };

    $scope.selectTab = function(activeIndex)
    {
        for(var index in $scope.tabs)
        {
            $scope.tabs[index].active = false;
        }

        $scope.tabs[activeIndex].active = true;
        $('#collapseToggleButton').click();

    };
}
