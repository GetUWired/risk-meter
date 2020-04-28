<?php
/*
Template Name: Processing Create User
*/

//Using this page template/Wordpress page to process functions found in the plugin file guw-risk-meter-user/create_user.php 


switch ($_POST["action"]) {
    case "guw_create_user":
        guw_create_user();
    case "guw_remove_access_to_site_after_failed_payment":
    	guw_remove_access_to_site_after_failed_payment();
    case "guw_create_locked_role":
    	guw_create_locked_role();
    default:
    	echo "<p style='font-size: 18px; text-align: center; margin: 25px 10px;'>You have reached this page in error. </p><p style='font-size: 18px; text-align: center; margin: 25px 10px;'>Please click the link to return to <a href='https://realriskmeter.com'>The Real Risk Meter</a> homepage.</p>";
}
