/**
 * Created by Lae on 7/21/2014.
 */

pixelApp.factory('userService', function($rootScope, $timeout, dataAccessor, sessionStateService)
{
    var service = {};

    service.userID = null;
    service.userProfile = null;
    service.albums = null;
    service.userImages = null;
    service.globalImages = null;

    service.imageSource = "http://userhome.laertesousa.com/";

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

    service.updateUserProfile = function()
    {
        if(service.userID == null)
        {
            service.userID = sessionStateService.getSessionField('userID', function(data)
            {
                if(!data['error'])
                {
                    service.userID = data['result'];

                    dataAccessor.getUser(service.userID,function(data)
                    {
                        if(!data['error'])
                        {
                            service.userProfile = data['result'];
                        }

                        service.notifyProfileUpdate();
                    });
                }
                else
                {
                    window.location.href='/';
                }

            });
        }
        else
        {
            dataAccessor.getUser(this.userID,function(data)
            {
                if(!data['error'])
                {
                    service.userProfile = data['result'];
                }

                service.notifyProfileUpdate();
            });
        }


    };

    service.updateAlbums = function()
    {
        dataAccessor.getAlbums(function(data)
        {
            if(!data['error'])
            {
                service.albums = data['result'];
            }

            service.notifyPropertyChanged('albums');
        });
    };

    service.updateGlobalImages = function()
    {
        dataAccessor.getImages(function(data)
        {
            var images = data;
            service.globalImages = images;

            service.notifyGlobalImagesUpdate();
        });

    };

    service.notifyPropertyChanged = function(property)
    {
        $rootScope.$broadcast(property);
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

    service.notifyGlobalImagesUpdate = function()
    {
        $rootScope.$broadcast('globalImagesUpdate');
    }

    return service;
});