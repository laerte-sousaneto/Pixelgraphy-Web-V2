<?php
/**
 * Created by IntelliJ IDEA.
 * User: Laerte
 * Date: 9/18/2014
 * Time: 11:49 AM
 */

ini_set('display_errors',1);  error_reporting(E_ALL);

require_once "../Objects/Album.class.php";

//$albumHandler = new AlbumHandler('15');

//$albumHandler->rename("Renaming Album");

$album = Album::createAlbum('53fe897c67053',"testing");