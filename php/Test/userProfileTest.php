<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 5:59 PM
 */

require_once '../Objects/UserProfile.class.php';

$userProfile = new UserProfile('53fe897c67053');

$userProfile->updateAboutInfo("Testing hobbies 3", "Testing biography 3");
$userProfile->updateProfileInfo("Laerte Sousa Neto", "Comp", "ma", "wtf", "2131233");

print_r($userProfile->getAssoc());