<?php
require dirname(__FILE__) . '/../classes/Account.php';
require dirname(__FILE__) . '/../classes/Validate.php';

$account = new Account();
$validate = new Validate();


if (isset($_POST["login"]) == 'login') {
    /*  $output['success'] = '<div class="alert alert-success">Verification code has been sent to </div>';
                 echo json_encode($output); */

    $user_identifier = $_POST['user_identifier'];
    $password = $_POST['password'];

    $validate->validateLength($user_identifier, '', 'user_identifier_error', 'Required Field');
    $validate->validateLength($password, '', 'password_error', 'Required Field' );

    $table_identifier =  $validate->table_identifier($user_identifier, 'user_identifier_error');
/*     $validate->user_identifier($table_identifier, $user_identifier, 'user_identifier_error'); */





    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {

        if( $validate->login_attempt($user_identifier, $table_identifier)) {
            $account->login($user_identifier,$table_identifier,$password);
            } else {
               /*  $output['success'] = '<div class="alert alert-success">hackerman </div>';
                echo json_encode($output); */
                $account->email_attempt($user_identifier, $table_identifier);
            }
       /*  $output['success'] = '<div class="alert alert-success">Verification code has been sent to </div>';
        echo json_encode($output); */
    }
}







if (isset($_POST["register"]) == 'register') {

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


    /*   $validate->validateLength($firstname,'','firstname_error', 'Required Field' );
    $validate->validateLength($lastname,'', 'lastname_error', 'Required Field' ); */
    /*     $validate->validateLength($username, '', 'username_error', 'Required Field' );
    $validate->validateLength($email,'', 'email_error', 'Required Field' );
    $validate->validateLength($contact,'', 'contact_error', 'Required Field' ); */
    /*     $validate->validateLength($password, $retype_password, 'password_error', 'Required Field' );
    $validate->validateLength($password,$retype_password, 'retype_password_error', 'Required Field' ); */
    /* $validate->validateSelectorLength($region,'region_error', 'Required Field' ); */
    /*     $validate->validateSelectorLength($province,'province_error', 'Required Field' );
    $validate->validateSelectorLength($municipality,'municipality_error', 'Required Field' );
    $validate->validateSelectorLength($barangay,'barangay_error', 'Required Field'); */
    /* $validate->validateLength($street,'', 'street_error', 'Required Field' ); */


    if (count($validate->output) > 0) {
        /* echo json_encode($validate->output); */
        echo json_encode($validate->output);
    } else {
        $account->register($firstname, $lastname, $username, $email, $contact, $password, $retype_password, $province, $municipality, $barangay, $street);
    }
}




if (isset($_POST["forgot_password"]) == 'forgot_password') {
    /*  $output['success'] = '<div class="alert alert-success">Verification code has been sent to </div>';
                    echo json_encode($output); */

    $user_identifier = $_POST['user_identifier'];


    $validate->validateLength($user_identifier, '', 'user_identifier_error', 'Required Field');
    

    $table_identifier =  $validate->table_identifier($user_identifier, 'user_identifier_error');


  


    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        
        $account->forgot_password($user_identifier, $table_identifier);
    }
}


if (isset($_POST["new_password"]) == 'new_password') {

    $url_code = $_GET['code'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];



    /*  $validate->validateLength($password, $retype_password, 'password_error', 'Required Field' );
            $validate->validateLength($password,$retype_password, 'retype_password_error', 'Required Field' ); */
    $user_id = $validate->get_user_id($url_code);


    if (count($validate->output) > 0) {

        echo json_encode($validate->output);
    } else {
        $account->new_password($user_id, $password, $retype_password);
        /*    $output['success'] = '<div class="alert alert-success">Vsss </div>';
            echo json_encode($output); */
    }
}
