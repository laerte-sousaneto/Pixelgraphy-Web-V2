<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lae
 * Date: 7/28/2014
 * Time: 4:30 PM
 */

if(session_id() == '')
{
    session_start();
    session_unset();
    session_destroy();
}