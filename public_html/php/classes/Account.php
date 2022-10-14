<?php
session_start();

require_once dirname(__FILE__) . "/DbConnection.php";
require_once dirname(__FILE__) . "/Email.php";


/* require dirname(__FILE__) ."/../../../'vendor/autoload.php";
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi; */
unset($_SESSION["info-otp"]);
/* $error = array(); */

$email = "";
$code = "";
$username = "";



class Account extends DbConnection
{
    public $output = array();
    public $error = array();
    /* public $table_identifier; */
    public $password;
    public $user_identifier;
    public $table_identifier;

    /* Generate Verification Code */
    public function generateCode()
    {
        $code = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$%', mt_rand(1, 16))), 1, 16);

        /* Check if verification code already exist, if true it will regenerate again */
        $query = $this->connect()->prepare("SELECT * FROM user WHERE code = :code");
        $query->execute([':code' => $code]);

        if ($query->rowCount() > 0) {
            $code = $this->generateCode();
        } else {
            return $code;
        }
    }

public function get_time() {
   /*  $date_today = new DateTime();
echo $date_today->format('Y-m-d H:i:s');   
echo $date_today->getTimestamp();  */ 

 return  date('m-d-Y H:i:s');
}

    /* Login */

    public function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;
        else
            return false;
    }

    public function table_identifier($user_identifier)
    {
        if ($this->validateEmail($user_identifier)) {
            return $this->table_identifier = "email";
        } else {

            return $this->table_identifier = "phone";
        }
    }


    public function login($user_identifier, $table_identifier, $password)
    {
        if (isset($_POST['login'])) {

            $query  = $this->connect()->prepare("SELECT user_id , password, attempt FROM user where " . $table_identifier . " = :user_identifier");

            $query->execute([':user_identifier' => $user_identifier]);
            if ($query->rowCount() > 0) {

                $fetch = $query->fetch(PDO::FETCH_ASSOC);
                $fetch_pass = $fetch['password'];
                $fetch_user_id = $fetch['user_id'];
                $fetch_attempt = $fetch['attempt'];

                if (password_verify($password, $fetch_pass)) {

                    $_SESSION['user_id'] = $fetch_user_id;
                    $_SESSION['password'] = $password;
                    $output['success'] = '<div class="alert alert-success">Suces</div>';
                    echo json_encode($output);
                } else {
                    
                    $query =  $this->connect()->prepare("UPDATE user SET attempt = :fetch_attempt WHERE user_id = :fetch_user_id");
                    $result = $query->execute([':fetch_attempt' =>  $fetch_attempt + 1, ':fetch_user_id' => $fetch_user_id]);

                    if ($result) {



                        $output['error'] = '<div class="alert alert-success">Incorrect cre daw more attempts</div>';
                    echo json_encode($output);
                    } else {

                        $output['error'] = '<div class="alert alert-success">bakit ayaw cre</div>';
                    echo json_encode($output);
                    }
                }
            } else {
                $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.2</div>';
                echo json_encode($output);
            }
        }
    }

    public function email_attempt($user_identifier, $table_identifier)
    {

        $query  = $this->connect()->prepare("SELECT email FROM user where " . $table_identifier . " = :table_identifier");


        $query->execute([':table_identifier' => $user_identifier]);

        if ($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);

            $fetch_email = $fetch['email'];

            $code = $this->generateCode();





            $code = $this->generateCode();
            $query =  $this->connect()->prepare("UPDATE user SET code = :code WHERE email = :email");
            $result = $query->execute([':code' => $code, ':email' => $fetch_email]);

            if($result) {
            $email = 'darwinsanluis.ramos14@gmail.com';
            $subject = 'SnackWise Reset ';
            $body = "
        
        <div>        
            
            <a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/reset.php?code=" . $code . "' >" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/reset.php?code=" . $code . "</a>
            
        </div>                    
        ";

            $email_verification = new Email();
            if ($email_verification->sendEmail($email, $subject, $body)) {
                $output['error'] = '<div class="alert alert-success">Too many login attemp. an email has been sent to reset .1</div>';
                echo json_encode($output);
            } else {
                $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.1</div>';
                echo json_encode($output);
            }
        } else {
            $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.21111</div>';
            echo json_encode($output);
        }
    }
    }



    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }



    public function validatePassword($password)
    {
        if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/', $password))
            return true;
        else
            return false;
    }


    /* Register */
    public function register($firstname, $lastname, $username, $email, $contact, $password, $retype_password, $province, $municipality, $barangay, $street)
    {
        /* Check if email if already registered */
        /* if ($this->validateEmail($email)) { */
        //invoke the function that generates verification code

        $encryptPassword = $this->encryptPassword($password);
        $attempt = 0;
        $status = "unverified";
        $code = $this->generateCode();
        $user_type = "staff";

        $query = $this->connect()->prepare("INSERT INTO user (firstname, lastname, username, email, contact, password, province, municipality, barangay, street,attempt,code, status, user_type) VALUES( :firstname, :lastname, :username, :email, :contact, :password, :province, :municipality, :barangay, :street,:attempt,:code, :status, :user_type)");

        $result = $query->execute([":firstname" => $firstname, ":lastname" => $lastname, ":username" => $username, ":email" => $email, ":contact" => $contact, ":password" => $password, ":province" => $province, ":municipality" => $municipality, ":barangay" => $barangay, ":street" => $street, ":attempt" => $attempt, ":code" => $code, ":status" => $status, ":user_type" => $user_type]);

        if ($result) {
            $email = 'darwinsanluis.ramos14@gmail.com';
            $subject = 'SnackWise Account Verification';
            $body = "
                
                <div>        
                    <button class=''><a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/activate.php?code=" . $code . "'>Verify Your Account</a></button>
                    
                    <p class='text'>If the button does not work for any reason, you can also paste the following into your browser:</p>
                   
                    <a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/activate.php?code=" . $code . "' >" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/activate.php?code=" . $code . "</a>
                    
                </div>                    
                ";

            $email_verification = new Email();
            if ($email_verification->sendEmail($email, $subject, $body)) {


                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;

                $output['success'] = '<div class="alert alert-success">Verification code has been sent to' . $email . '</div>';
                echo json_encode($output);
            } else {
                $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.1</div>';
                echo json_encode($output);
            }
        } else {
            $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.2</div>';
            echo json_encode($output);
        }

        /* } else {
            $this->error['email'] = "Invalid Email";
        } */
    }


    public function forgot_password($user_identifier, $table_identifier)
    {



        $query  = $this->connect()->prepare("SELECT email, username, contact FROM user where " . $table_identifier . " = :table_identifier");


        $query->execute([':table_identifier' => $user_identifier]);

        if ($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);

            $fetch_email = $fetch['email'];

            $code = $this->generateCode();
            $query =  $this->connect()->prepare("UPDATE user SET code = :code WHERE email = :email");
            $result = $query->execute([':code' => $code, ':email' => $fetch_email]);
            if ($result) {
                /*   $fetch_email = 'darwinsanluis.ramos14@gmail.com'; */
                $subject = 'SnackWise Forgot Password';
                $body = "
                <div>        
                <button class=''><a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/new-password.php?code=" . $code . "'>Verify Your Account</a></button>
                
                <p class='text'>If the button does not work for any reason, you can also paste the following into your browser:</p>
               
                <a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/new-password.php?code=" . $code . "' >" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/new-password.php?code=" . $code . "</a>
                
            </div>  
                
                ";

                $email_verification = new Email();
                if ($email_verification->sendEmail($fetch_email, $subject, $body)) {


                    $_SESSION['forgot-email'] = $fetch_email;

                    $output['success'] = '<div class="alert alert-success">Link to change pass' . $fetch_email . '</div>';
                    echo json_encode($output);
                    exit();
                } else {
                    $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.1112</div>';
                    echo json_encode($output);
                }
            } else {
                $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.211111111111111</div>';
                echo json_encode($output);
            }
        } else {
            $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.21111</div>';
            echo json_encode($output);
        }
    }
    /* Change Password */
    public function new_password($user_id, $password, $retypePassword)
    {



        $forgotEmail = $_SESSION['forgot-email'];


        $status = "verified";
        $code = 0;

        $encryptPassword = $this->encryptPassword($password);
        $query = $this->connect()->prepare("UPDATE user SET password = :password, code = :code, status = :status WHERE user_id = :user_id");
        $result = $query->execute([':password' => $encryptPassword, ':code' => $code, ':status' => $status, ':user_id' => $user_id]);

        if ($result) {

            $output['success'] = '<div class="alert alert-success">Your password has been changed! Please login with your new password</div>';
            echo json_encode($output);
            /*  header('Location: login'); */
            exit;
        } else {
            $output['success'] = '<div class="alert alert-success">Your password has been changed! Please login with your new password</div>';
            echo json_encode($output);
        }
    }



    public function activate()
    {

        $url_code = $_GET["code"];
        $status = "verified";
        $code = 0;
        echo  $url_code;
        $query  = $this->connect()->prepare("UPDATE user SET code = :code, status = :status WHERE code = :url_code");
        $result = $query->execute([':code' => $code, ':status' => $status, ':url_code' => $url_code]);
        if ($result) {
            
            $_SESSION['activate_success'] = "Your account has been activated";
            /* echo "exist"; */
            
            header('Location: login.php');
        } else {
           
            header('Location: error');

            /*  header('location: error'); */
        }
    }

    public function reset_attempt()
    {

        $url_code = $_GET["code"];
      
        $code = 0;
        $attempt = 0;
 
        $query  = $this->connect()->prepare("UPDATE user SET code = :code, attempt = :attempt WHERE code = :url_code");
        $result = $query->execute([':code' => $code,  ':attempt' => $attempt, ':url_code' => $url_code]);
        if ($result) {
           
            /* echo "exist"; */
            $_SESSION['activate_success'] = "Your account has been verified. You can now login";
            header('Location: login');
        } else {
            
            header('Location: error');

            /*  header('location: error'); */
        }
    }

    public function edit()
    {
    }

    public function fetch($id)
    {
        $query = $this->connect()->prepare("SELECT id, email , phone, image FROM (SELECT id,  email , phone, image FROM user UNION SELECT id,  email , phone, image FROM staff) unioned where id = :id");
        $result = $query->execute([':id' => $id]);
        if ($result) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "failed";
        }
    }

    public function save($fetch_id)
    {

        $email = ($_POST['email']);
        $phone = ($_POST['phone']);





        if ($_FILES["picture"]["error"] > 0) {
            $query  = $this->connect()->prepare("UPDATE user SET email = :email, phone = :phone WHERE id = :fetch_id");
            $result = $query->execute([':email' => $email, ':phone' => $phone, ':fetch_id' => $fetch_id]);
        } else {
            /* $imagePath =$_FILES["picture"]["tmp_name"]; */
            $imagePath = ($_POST['cropImage']);
            $imageTitle = "project";
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => 'dhzn9musm',
                    'api_key' => '364195656183668',
                    'api_secret' => 'djFdPLL9D2O2lxNxApJNBxVY1iY'
                ],

                'url' => [
                    'secure' => true
                ]
            ]);


            $data =  (new UploadApi())->upload(
                $imagePath,
                [
                    'folder' => 'SL Visuals/',
                    'public_id' => $imageTitle,
                    'overwrite' => true,
                ],
            );
            $imageLink = "v" . $data['version'] . "/" . $data['public_id'];


            $query  = $this->connect()->prepare("UPDATE user SET email = :email, phone = :phone, image = :image WHERE id = :fetch_id");
            $result = $query->execute([':email' => $email, ':phone' => $phone, ':image' => $imageLink, ':fetch_id' => $fetch_id]);
        }





        /*  $query  = $this->connect()->prepare("UPDATE user SET email = :email, phone = :phone WHERE id = :fetch_id");
            $result = $query->execute([":email" => $email,':phone' => $phone,':fetch_id' => $fetch_id]); */

        if ($result) {
            $success = "Your information has been edited";
            $_SESSION['success'] = $success;
            /* echo "exist"; */
        } else {
            echo "failed";
        }
        /* echo "<meta http-equiv='refresh' content='0'>"; */
    }
}
