<?php
/**
 * Created by IntelliJ IDEA.
 * User: Laerte
 * Date: 9/18/2014
 * Time: 1:43 PM
 */

ini_set('display_errors',1);  error_reporting(E_ALL);
require_once "../Objects/Image.php";

$image = new Image('53fe8a058c51d');

//$imageHandler->rename('Renaming Image');
//$imageHandler->changeDescription('Changing description');
//$imageHandler->changeAlbum('16');

//echo $image->addComment('53fe897c67053',"Testing comment add");
print_r($image->getComments());