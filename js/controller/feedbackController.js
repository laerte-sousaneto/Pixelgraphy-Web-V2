/**
 * Created by Laerte on 7/26/2014.
 */

'use strict';

pixelApp.controller('feedbackController', feedbackController);

function feedbackController($scope, $http, uiService)
{
    uiService.enableFeedbackTab();
    $scope.fullname = "";
    $scope.email = "";
    $scope.subject = "";
    $scope.message = "";

    $scope.sending = false;
    $scope.sent = false;

    $scope.send = function()
    {
        $scope.sending = true;

        $http(
            {
                method: 'POST',
                url: '../../php/Other/contact.php',
                data: $.param(
                    {
                        'fullname': $scope.fullname,
                        'email': $scope.email,
                        'subject': $scope.subject,
                        'message': $scope.message
                    }),
                headers :   { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
            }
        ).success(function(data)
            {
                console.log(data);
                if(!data['error'])
                {
                    $scope.sent = true;
                }

            }
        );

    };

}