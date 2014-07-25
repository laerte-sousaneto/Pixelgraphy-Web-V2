/**
 * Created by Lae on 7/21/2014.
 */

pixelApp.factory('userService', function($rootScope, $timeout, dataAccessor)
{
    var service = {};

    service.userID = null;
    service.userProfile = null;
    service.userImages = null;

    service.setUserID = function(userID)
    {
        this.userID = userID;

        dataAccessor.getUser(this.userID,function(data)
        {
            if(!data['error'])
            {
                service.userProfile = data['result'];
            }

            service.notifyProfileUpdate();
        });

        dataAccessor.getUserImages(this.userID,function(data)
        {
            service.userImages = data;

            service.notifyImagesUpdate();
        });


    };

    service.broadcastUpdate = function()
    {
        $rootScope.$broadcast('userUpdate');
    };

    service.notifyProfileUpdate = function()
    {
      $rootScope.$broadcast('profileUpdate');
    };

    service.notifyImagesUpdate = function()
    {
        $rootScope.$broadcast('imagesUpdate');
    };

    return service;
});