/**
 * Created by Lae on 7/21/2014.
 */

pixelApp.factory('userService', function($rootScope, $timeout, dataAccessor, sessionStateService)
{
    var service = {};

    service.userID = null;
    service.userProfile = null;
    service.albums = null;
    service.globalImages = null;
    service.selectedImageIndex = null;

    service.loggedIn = false;

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

    };

    service.setSelectedImage = function(index)
    {
        service.selectedImageIndex = index;
        service.notifyPropertyChanged("SelectedImage");
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
                        service.loggedIn = true;

                        service.notifyProfileUpdate();
                    });

                    return true;
                }
                else
                {
                    window.location.href='/';
                    service.loggedIn = false;
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