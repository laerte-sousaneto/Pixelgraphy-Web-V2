<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lae
 * Date: 8/7/2014
 * Time: 8:32 PM
 */

require_once '../Objects/ImageServerUpload.class.php';
//error_reporting(E_ALL);

if(session_id() == '')
{
    session_start();
}

$user = $_SESSION['userID'];
$isProfile = false;
$file = ($_FILES['file']);
$fileName = "";
$desc = "";

$uploader = new ImageServerUpload($user,$file,$fileName,"",$desc,$isProfile);
echo json_encode($uploader->uploadTempImageFile());