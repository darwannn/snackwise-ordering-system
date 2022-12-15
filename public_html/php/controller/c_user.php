<?php 

require dirname(__FILE__) . '/../classes/User.php';
require dirname(__FILE__) . '/../classes/Validate.php';

$validate = new Validate();
$user = new User();

if(isset($_POST['display_staff']) == 'display_staff') {
    echo $user->display_staff();
}


?>