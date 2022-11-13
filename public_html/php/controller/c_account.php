<?php
require dirname(__FILE__) . '/../classes/Account.php';
require dirname(__FILE__) . '/../classes/Validate.php';
$account = new Account();
$validate = new Validate();

if (isset($_POST["login"])) {
    $user_identifier = $_POST['user_identifier'];
    $password = $_POST['password'];

    $validate->validateLength($password, '', 'password_error', 'Required field' );
    
    $table_identifier =  $validate->table_identifier($user_identifier, 'user_identifier_error');
    $validate->user_identifier($table_identifier, $user_identifier, 'user_identifier_error');
    $validate->validateLength($user_identifier, '', 'user_identifier_error', 'Required field');
    

    /* checks if the validation above returns an error or not, if true it will display the error */
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        /* checks if the maximum login incorrect attempt has been reached, if true it will invoke the email_attept function and sends an email verification to the user */
        if( $validate->login_attempt($user_identifier, $table_identifier)) {
            $account->login($user_identifier,$table_identifier,$password);
        } else {
            $account->email_attempt($user_identifier, $table_identifier);
        }
    }
}

if (isset($_POST["register"])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $user_type = $_SESSION['user_type'];

    $validate->validateLength($firstname,'','firstname_error', 'Required field' );
    $validate->validateLength($lastname,'', 'lastname_error', 'Required field' );
    $validate->validateLength($username, '', 'username_error', 'Required field' );
    $validate->validateLength($email,'', 'email_error', 'Required field' );
    $validate->validateLength($contact,'', 'contact_error', 'Required field' );
    $validate->validateLength($password, $retype_password, 'password_error', 'Required field' );
    $validate->validateLength($password,$retype_password, 'retype_password_error', 'Required field' );
    $validate->validateSelectorLength($region,'region_error', 'Required field' );
    $validate->validateSelectorLength($province,'province_error', 'Required field' );
    $validate->validateSelectorLength($municipality,'municipality_error', 'Required field' );
    $validate->validateSelectorLength($barangay,'barangay_error', 'Required field');
    $validate->validateLength($street,'', 'street_error', 'Required field' );

    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $account->register($firstname, $lastname, $username, $email, $contact, $password, $retype_password, $region, $province, $municipality, $barangay, $street, $user_type);
    }
}

if (isset($_POST["forgot_password"])) {
    $user_identifier = $_POST['user_identifier'];
    $validate->validateLength($user_identifier, '', 'user_identifier_error', 'Required field');
    $table_identifier =  $validate->table_identifier($user_identifier, 'user_identifier_error');

    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $account->forgot_password($user_identifier, $table_identifier);
    }
}

if (isset($_POST["new_password"])) {
    $url_code = $_GET['code'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];

    $validate->validateLength($password, $retype_password, 'password_error', 'Required field' );
    $validate->validateLength($password,$retype_password, 'retype_password_error', 'Required field' );
    $user_id = $validate->get_user_id($url_code);

    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $account->new_password($user_id, $password, $retype_password);
    }
}

/* -------------------- update user profile */

if (isset($_POST["update"])) {
    $image = $_POST['crop_image'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $user_id  = $_POST['user_id'];

    $validate->validateLength($firstname,'','firstname_error', 'Required field' );
    $validate->validateLength($lastname,'', 'lastname_error', 'Required field' );
    $validate->validateLength($username, '', 'username_error', 'Required field' );
    $validate->validateLength($email,'', 'email_error', 'Required field' );
    $validate->validateLength($contact,'', 'contact_error', 'Required field' );
/*     $validate->validateLength($password, $retype_password, 'password_error', 'Required field' );
    $validate->validateLength($retype_password,$retype_password, 'retype_password_error', 'Required field' ); */
    $validate->validateSelectorLength($region,'region_error', 'Required field' );
    $validate->validateSelectorLength($province,'province_error', 'Required field' );
    $validate->validateSelectorLength($municipality,'municipality_error', 'Required field' );
    $validate->validateSelectorLength($barangay,'barangay_error', 'Required field');
    $validate->validateLength($street,'', 'street_error', 'Required field' );

    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $account->update($user_id,$firstname, $lastname, $username, $email, $contact, $region, $province, $municipality, $barangay, $street, $image);
    }
}

if (isset($_POST["fetch_account"])) {
    $user_id = $_POST['user_id'];
    $account->fetch_user($user_id);
}

if (isset($_POST["delete_account"])) {
    $user_id = $_POST['user_id'];
    $account->delete_account($user_id);
}

if (isset($_POST["change_password"])) {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];
   
    $validate->validateLength($password, $password, 'password_error', 'Required field' );
    $validate->validateLength($current_password, $password, 'current_password_error', 'Required field' );
  
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $account->change_password($user_id, $password, $retype_password);
    }
}

if (isset($_POST["match_password"])) {
    $user_id = $_POST['user_id'];
    $current_password = $_POST['current_password'];
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        if ($validate->match_current_password($current_password, $user_id)){
        } 
    }
}

if (isset($_POST["password_requirment"])) {
    $retype_password = $_POST['retype_password'];
    $password = $_POST['password'];

    $validate->validateLength($password, $password, 'password_error', 'Required field' );
    $validate->validateLength($password,$retype_password, 'retype_password_error', 'Required field' );
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
            $output['success'] = 'Success';
            echo json_encode($output);
    }
}