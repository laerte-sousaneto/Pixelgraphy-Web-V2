/**
 * Created by laerte on 9/22/2014.
 */

pixelApp.controller('searchController', searchController);

function searchController($scope, dataAccessor)
{
    $scope.search = "";

    dataAccessor.getAllUsers(function(data)
    {
        if(!data['error'])
        {
            $scope.users = data['result'];
        }

    });

    $scope.visitProfile = function(username)
    {
        window.location.href = "http://pixel.laertesousa.com/#/profile/"+username;
    };

    $scope.convertToDate = function (stringDate)
    {
        var dateOut = new Date(stringDate);
        dateOut.setDate(dateOut.getDate() + 1);
        return dateOut;
    };
}