/**
 * Created by Laerte on 7/26/2014.
 */

'use strict';

pixelApp.controller('aboutController', aboutController);

function aboutController($scope, uiService)
{
    uiService.enableAboutTab();
}
