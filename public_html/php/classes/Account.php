<?php
require_once dirname(__FILE__) . "/DbConnection.php";
require_once dirname(__FILE__) . "/Email.php";
require_once dirname(__FILE__) . "/Image.php";

class Account extends DbConnection
{
    public $output = array();
    public $error = array();
    public $password;

    /* generates email verification code */
    public function generateCode()
    {
        $code = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$%', mt_rand(1, 16))), 1, 16);

        /* check if the verification code already exists, if true it will regenerate again */
        $query = $this->connect()->prepare("SELECT * FROM user WHERE code = :code");
        $query->execute([':code' => $code]);

        if ($query->rowCount() > 0) {
            $code = $this->generateCode();
        } else {
            return $code;
        }
    }

    /* deletes verification codes that exist for more than the specified expiration time */
    public function delete_code()
    {
        $query  = $this->connect()->prepare("UPDATE user SET code =:code  WHERE UNIX_TIMESTAMP(NOW())- UNIX_TIMESTAMP(code_expiration) >= :unixtime");
        /* 86400 seconds is equal to 1 day */
        $query->execute([':code' => "", ':unixtime' => 86400]);
    }

    /* returns current date and time  */
    public function get_current_date()
    {
        return  date('Y-m-d H:i:s');
    }

    /* encrypts  entered password */
    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /* validates entered password, it must have 8-20 alphanumeric and must have at least one lowercase, uppercase and special character */
    public function validatePassword($password)
    {
        if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/', $password))
            return true;
        else
            return false;
    }

    /* gets admin registered email address */
    public function get_admin_email()
    {
        $query = $this->connect()->prepare("SELECT email FROM user WHERE user_type = :user_type");

        $result = $query->execute([":user_type" => "admin"]);

        if ($result) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            return $fetch['email'];
        } else {
            $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.2</div>';
            echo json_encode($output);
        }
    }


    /* -------------------- login */

    public function login($user_identifier, $table_identifier, $password)
    {
            /* checks if the information entered exist  */
            $query  = $this->connect()->prepare("SELECT user_id , password, attempt, user_type FROM user where " . $table_identifier . " = :user_identifier");
            $query->execute([':user_identifier' => $user_identifier]);
            if ($query->rowCount() > 0) {
                $fetch = $query->fetch(PDO::FETCH_ASSOC);
                $fetch_pass = $fetch['password'];
                $fetch_user_id = $fetch['user_id'];
                $fetch_attempt = $fetch['attempt'];
                $fetch_user_type = $fetch['user_type'];

                /* verify if the password entered and the password in the database matches, if true login incorrect attempt counter will be reset to 0 else it will be increased by 1 */
                if (password_verify($password, $fetch_pass)) {
                    $query  = $this->connect()->prepare("UPDATE user SET attempt = :attempt WHERE user_id = :user_id");
                    $result = $query->execute([':attempt' => '0', ':user_id' => $fetch_user_id]);
                    if ($result) {
                        $_SESSION['user_id'] = $fetch_user_id;
                        $_SESSION['password'] = $password;
                        $_SESSION['user_type'] = $fetch_user_type;
                        $output['success'] = 'Login Successfully';
                    }
                } else {
                    $query =  $this->connect()->prepare("UPDATE user SET attempt = :fetch_attempt WHERE user_id = :fetch_user_id");
                    $result = $query->execute([':fetch_attempt' =>  $fetch_attempt + 1, ':fetch_user_id' => $fetch_user_id]);
                    if ($result) {
                        $output['error'] = '<div class="alert alert-success">Incorrect Password</div>';
                    } else {
                        $output['error'] = 'Something went wrong! Please try again later.';
                    }
                }
            } else {
                $output['error'] = 'Something went wrong! Please try again later.';
            }
            echo json_encode($output);
    }

    /* sends an email verification when the maximum login incorrect attempt has been met */
    public function email_attempt($user_identifier, $table_identifier)
    {
        $query  = $this->connect()->prepare("SELECT email FROM user where " . $table_identifier . " = :table_identifier");
        $query->execute([':table_identifier' => $user_identifier]);
        if ($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $fetch_email = $fetch['email'];
            $code = $this->generateCode();
            $code_expiration = $this->get_current_date();
            $query =  $this->connect()->prepare("UPDATE user SET code = :code, code_expiration = :code_expiration WHERE email = :email");
            $result = $query->execute([':code' => $code, ':code_expiration' => $code_expiration, ':email' => $fetch_email]);
            if ($result) {
                $email = 'darwinsanluis.ramos14@gmail.com';
                $subject = 'SnackWise Reset ';
                $body = "
                        <div>        
                            <a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/reset.php?code=" . $code . "' >" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/reset.php?code=" . $code . "</a>  
                        </div>                    
                        ";

                $email_verification = new Email();
                if ($email_verification->sendEmail("SnackWise",$email, $subject, $body,"account")) {
                    $output['error'] = 'Too many incorrect login attempts. We have sent an email to verify your identity.';
                } else {
                    $output['error'] = 'Something went wrong! Please try again later.';
                }
            } else {
                $output['error'] = 'Something went wrong! Please try again later';
            }
        }
        echo json_encode($output);
    }


    /* -------------------- register */
    public function register($firstname, $lastname, $username, $email, $contact, $password, $retype_password, $region, $province, $municipality, $barangay, $street, $user_type)
    {
        $attempt = 0;
        $status = "unverified";

        $code = $this->generateCode();
        $code_expiration = $this->get_current_date();
        $encryptPassword = $this->encryptPassword($password);

        $query = $this->connect()->prepare("INSERT INTO user (firstname, lastname, username, email, contact, password, region, province, municipality, barangay, street,attempt,code,code_expiration, status, user_type) VALUES( :firstname, :lastname, :username, :email, :contact, :password, :region, :province, :municipality, :barangay, :street,:attempt,:code, :code_expiration,:status, :user_type)");
        $result = $query->execute([":firstname" => $firstname, ":lastname" => $lastname, ":username" => $username, ":email" => $email, ":contact" => $contact, ":password" => $encryptPassword, ":region" => $region, ":province" => $province, ":municipality" => $municipality, ":barangay" => $barangay, ":street" => $street, ":attempt" => $attempt, ":code" => $code, ":code_expiration" => $code_expiration, ":status" => $status, ":user_type" => $user_type]);

        if ($result) {

            /* user_type determines wether the person registering is a customer or staff,
            if it is equal to customer, the email verification will be sent to the entered emeil address, 
            else it will be send to the admin email address */

            if ($user_type == "customer") {
                $email = 'darwinsanluis.ramos14@gmail.com';
                $subject = 'SnackWise Account Verification';
                $body = "
                
                <div>        
                    <button class=''><a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/activate.php?code=" . $code . "'>Verify Your Account</a></button>
                    <p class='text'>If the button does not work for any reason, you can also paste the following into your browser:</p>
                    <a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/activate.php?code=" . $code . "' >" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/activate.php?code=" . $code . "</a>
                    
                </div>                    
                ";
            } else {
                $email=$this->get_admin_email();
                $subject = 'SnackWise Staff Account Verification';
                $body = "
                <div>        
                        <button class=''><a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/activate.php?code=" . $code . "'>Verify Your Account</a></button>
                        <p class='text'>If the button does not work for any reason, you can also paste the following into your browser:</p>
                        <a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/activate.php?code=" . $code . "' >" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/activate.php?code=" . $code . "</a>
                    </div>                    
                    ";
                }
                
                
                $email_verification = new Email();
            if ($email_verification->sendEmail("SnackWise",$email, $subject, $body,"account")) {

                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;

                if ($user_type == "user") {
                    $output['success'] = 'Verification code has been sent to' . $email . '';
                } else {
                    $fetch_email = $this->get_admin_email();
                    $output['success'] = 'Verification code has been sent to' . $fetch_email . '';
                }
            } else {
                $output['error'] = 'Something went wrong! Please try again later.';
            }
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }

/* -------------------- register */
/* when a user (both customer and staff) forgot their password, they can change their password using the link that will be sent to their email address*/
    public function forgot_password($user_identifier, $table_identifier)
    {
        $query  = $this->connect()->prepare("SELECT email, username, contact FROM user where " . $table_identifier . " = :table_identifier");
        $query->execute([':table_identifier' => $user_identifier]);
        if ($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $fetch_email = $fetch['email'];

            $code_expiration = $this->get_current_date();
            $code = $this->generateCode();
            
            $query =  $this->connect()->prepare("UPDATE user SET code = :code, code_expiration = :code_expiration, WHERE email = :email");
            $result = $query->execute([':code' => $code, ':code_expiration' => $code_expiration, ':email' => $fetch_email]);
            if ($result) {

                $subject = 'SnackWise Forgot Password';

                //the link will redirect the user to account/new-password
                $body = "
                <div>        
                    <button class=''><a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/new-password.php?code=" . $code . "'>Verify Your Account</a></button>
                    <p class='text'>If the button does not work for any reason, you can also paste the following into your browser:</p>
                    <a href='" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/new-password.php?code=" . $code . "' >" . $_SERVER['SERVER_NAME'] . dirname(pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME), 2) . "/account/new-password.php?code=" . $code . "</a> 
                </div>  
                ";

                $email_verification = new Email();
                if ($email_verification->sendEmail( "SnackWise",$fetch_email, $subject, $body,"account")) {
                    $_SESSION['forgot-email'] = $fetch_email;
                    $output['success'] = 'Link to change your password has been sent to' . $fetch_email . '';
                } else {
                    $output['error'] = 'Something went wrong! Please try again later.';
                }
            } else {
                $output['error'] = 'Something went wrong! Please try again later.';
            }
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }

    /* -------------------- new-password */
    /* invoked when a user changes its password from new-password */
    public function new_password($user_id, $password, $retypePassword)
    {
        $status = 'verified';
        $code = 0;
        $encryptPassword = $this->encryptPassword($password);
        $query = $this->connect()->prepare("UPDATE user SET password = :password, code = :code, status = :status WHERE user_id = :user_id");
        $result = $query->execute([':password' => $encryptPassword, ':code' => $code, ':status' => $status, ':user_id' => $user_id]);
        if ($result) {
            $output['success'] = 'Your password has been changed! Please login with your new password';
            /*  header('Location: login'); */
            exit;
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }

    /* changes the status of the user account to verified */
    public function activate()
    {
        $url_code = $_GET["code"];
        $status = "verified";
        $code = 0;

        /* checks if the verification code in the URL parameter exists */
        $query  = $this->connect()->prepare("UPDATE user SET code = :code, status = :status WHERE code = :url_code");
        $result = $query->execute([':code' => $code, ':status' => $status, ':url_code' => $url_code]);
        if ($result) {
            $_SESSION['activate_success'] = "Your account has been activated";
            header('Location: login.php');
        } else {
            header('Location: error');
        }
    }
    
   

    /* -------------------- edit-profile */
    /* gets the information of user based in user_id */
    public function fetch_user($user_id)
    {
        $query = $this->connect()->prepare("SELECT * FROM user where user_id = :user_id");
        $result = $query->execute([':user_id' => $user_id]);
        $data = array();

        if ($result) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);

            $sub_array = array();

            $sub_array['user_id'] = $fetch['user_id'];
            $sub_array['firstname'] = $fetch['firstname'];
            $sub_array['lastname'] = $fetch['lastname'];
            $sub_array['username'] = $fetch['username'];
            $sub_array['email'] = $fetch['email'];
            $sub_array['contact'] = $fetch['contact'];
            $sub_array['region'] = $fetch['region'];
            $sub_array['municipality'] = $fetch['municipality'];
            $sub_array['barangay'] = $fetch['barangay'];
            $sub_array['street'] = $fetch['street'];
            $sub_array['image'] = $fetch['image'];
            $data[] = $sub_array;
            $output = array("data"=>$data);
        } else {
            $output['activate_success'] = "Your account has been verified. You can now login";
        }
        echo json_encode($output);
    }

    /* -------------------- */
    /* updates the user account, it also allows the user to upload a profile picture  */
    public function update($user_id, $firstname, $lastname, $username, $email, $contact, $region, $province, $municipality, $barangay, $street, $image)
    {
        /* determines if a new profile picture has been uploaded */
        if ($image == "") {
            $query = $this->connect()->prepare("SELECT image FROM user where user_id = :user_id");
            $result = $query->execute([':user_id' => $user_id]);

            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $image_link = $fetch['image'];
        } else {
            $upload_image = new Image();
            $data = $upload_image->upload_image($image, $username, "SnackWise/User/");
            $image_link = "v" . $data['version'] . "/" . $data['public_id'];
        }

        $query = $this->connect()->prepare("UPDATE user SET firstname =:firstname, lastname=:lastname, username=:username, email=:email, contact=:contact, region=:region, province=:province, municipality=:municipality, barangay=:barangay, street=:street, image=:image where user_id = :user_id");
        $result = $query->execute([":firstname" => $firstname, ":lastname" => $lastname, ":username" => $username, ":email" => $email, ":contact" => $contact, ":region" => $region, ":province" => $province, ":municipality" => $municipality, ":barangay" => $barangay, ":street" => $street, ":image" => $image_link, ':user_id' => $user_id]);
        if ($result) {
            $output['error'] = 'Your profile has been updated';
 
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);

    }

    /* invoked when a user changes its password from edit-user */
    public function change_password($user_id, $password, $retype_password)
    {
        $encryptPassword = $this->encryptPassword($password);
        $query = $this->connect()->prepare("UPDATE user SET password = :password WHERE user_id = :user_id");
        $result = $query->execute([':password' => $encryptPassword, ':user_id' => $user_id]);
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

    /* -------------------- */
    /* deletes user account */
    public function delete_account($user_id)
    {
        $query = $this->connect()->prepare("DELETE FROM user  WHERE user_id = :user_id");
        $result = $query->execute([ ':user_id' => $user_id]);

        if ($result) {
        $output['success'] = 'Account Deleted';
            echo json_encode($output);
            header('Location: login');
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
            echo json_encode($output);
        }
       
    }

    /* -------------------- */
     /* changes the login incorrect attempt counter to 0 */
     public function reset_attempt()
     {
         $url_code = $_GET["code"];
         $code = 0;
         $attempt = 0;
         $query  = $this->connect()->prepare("UPDATE user SET code = :code, attempt = :attempt WHERE code = :url_code");
         $result = $query->execute([':code' => $code,  ':attempt' => $attempt, ':url_code' => $url_code]);
         if ($result) {
             $_SESSION['activate_success'] = "Your account has been verified. You can now login";
             header('Location: login');
         } else {
             header('Location: error');
         }
     }
}
