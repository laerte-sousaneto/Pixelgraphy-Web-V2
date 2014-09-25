
pixelApp.controller('navigationController', navigationController);

function navigationController($scope)
{
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
}