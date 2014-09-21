<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 5:35 PM
 */

require_once '../Objects/User.class.php';

$user = new User('53fe897c67053');
print_r($user->getAlbums());