<?php
/* this page is used to verify the account of a user */
require_once dirname(__FILE__) . "/php/classes/Notification.php";
require_once dirname(__FILE__) . "/php/classes/Validate.php";

$notification = new Notification();
$validate = new Validate();

/* checks if the verification code in the URL parameter is in the database */
if ($validate->validate_code()) {
    $notification->subscribe();
}
