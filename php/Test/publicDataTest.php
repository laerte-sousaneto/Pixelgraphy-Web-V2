<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 11:20 PM
 */

require_once '../Objects/PublicData.class.php';

$publicData = new PublicData();

print_r($publicData->retrieveMostRecentImages());