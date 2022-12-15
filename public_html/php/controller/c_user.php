<?php 

require dirname(__FILE__) . '/../classes/User.php';
require dirname(__FILE__) . '/../classes/Validate.php';

$validate = new Validate();
$user = new User();

if(isset($_POST['display_users']) == 'display_users') {
    echo $user->display_users();
}

if(isset($_POST['delete_user']) == 'delete_user') {
    $user_id = $_POST['user_id'];
    echo $user->delete_user($user_id);
}

if(isset($_POST['update_user']) == 'update_user') {
    $user_id = $_POST['user_id'];
    $new_type = $_POST['new_type'];

    echo $user->update_user($user_id, $new_type);
}


?>