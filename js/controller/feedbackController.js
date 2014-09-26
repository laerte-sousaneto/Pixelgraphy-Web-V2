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

    $scope.isNameValid = function()
    {
        var regex = new RegExp("^(([a-zA-Z0-9\\s\\.\\'\\()\\%\\@\\:\\,]){3,25})$");
        return regex.test($scope.fullname);
    };

    $scope.isSubjectValid = function()
    {
        var regex = new RegExp("^(([a-zA-Z0-9\\s\\.\\'\\()\\%\\@\\:\\,]){3,100})$");
        return regex.test($scope.subject);
    };

    $scope.isMessageValid = function()
    {
        var regex = new RegExp("^(([a-zA-Z0-9\\s\\n\\.\\'\\()\\%\\@\\:\\,]){10,500})$");
        return regex.test($scope.message);
    };

    $scope.isEmailValid = function()
    {
        var regex = new RegExp("^([a-z0-9._]+@[a-zA-Z0-9\.\-]+(.)(com|edu|net|org))$");
        return regex.test($scope.email);
    };

    $scope.isAllFieldsValid = function()
    {
      return $scope.isNameValid() && $scope.isSubjectValid() && $scope.isEmailValid() && $scope.isMessageValid();
    };

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