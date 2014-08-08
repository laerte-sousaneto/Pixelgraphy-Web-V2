<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lae
 * Date: 8/8/2014
 * Time: 1:28 PM
 */

require 'ImageServerUpload.class.php';

if(session_id() == '')
{
    session_start();
}

if(isset($_SESSION['userID']))
{
    $user = $_SESSION['userID'];
    $isProfile = $_POST['isProfile'];
    $file = ($_FILES['file']);
    $album = $_POST['album'];
    $fileName = $_POST['nameInput'];
    $desc = $_POST['descriptionInput'];

    $uploader = new ImageServerUpload($user,$file,$fileName,$album,$desc,$isProfile);
    $uploader->uploadImageFile();
}
else
{
    header('Location: ../');
}


