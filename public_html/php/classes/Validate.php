<?php

require_once dirname(__FILE__) . "/DbConnection.php";


class Validate extends DbConnection
{
  public $output = array();

  public function sanitizeString($input)
  {
    return filter_input(INPUT_POST, $input, FILTER_SANITIZE_SPECIAL_CHARS);
  }
  public function sanitizeInt($input)
  {
    return filter_input(INPUT_POST, $input, FILTER_SANITIZE_NUMBER_INT);
  }


 /*  public function user_identifier($table, $user, $name)
  {
    if ($this->isEmail($user) == "email") {
      if ($this->isTakenEmail($user)) {
        $this->output[$name] = ' The email not found';
      } else {
        unset($this->output[$name]);
      }
    } else   if ($this->isContact($user) == "contact") {
      if ($this->isTakenContact($user)) {
        $this->output[$name] = '  phone not found!';
      } else {
        unset($this->output[$name]);
      }
    } else {
      if ($this->isTakenUsername($user)) {
        $this->output[$name] = ' Username not found';
      } else {
        unset($this->output[$name]);
      }
    }
  } */

  public function table_identifier($input, $name)
  {
    if ($this->isEmail($input)) {
      return "email";
    } else if ($this->isContact($input)) {
      return "contact";
    } else {
      return "username";
    }
  }

  public function validateLength($input, $compare_input, $name, $message)
  {
    if (empty($input)) {
      $this->output[$name] = $message;
    } else {
      unset( $this->output[$name]);
      if (strpos($name, "category")) {
        if ($input == "select") {
          $this->output[$name] = $message;
        }
      }
      
      if (strpos($name, "identifier")) {
        if ($this->isEmail($input) == "email") {
          if ($this->isTakenEmail($input)) {
            $this->output[$name] = ' The email not found';
          } else {
            $this->output[$name] = '';
            unset($this->output[$name]);
          }
        } else   if ($this->isContact($input) == "contact") {
          if ($this->isTakenContact($input)) {
            $this->output[$name] = '  phone not found!';
          } else {
    
            $this->output[$name] = '';
            unset($this->output[$name]);
          }
        } else {
          if ($this->isTakenUsername($input)) {
            $this->output[$name] = ' Username not found';
          } else {
          
            $this->output[$name] = '';
            unset($this->output[$name]);
          }
        }
      } 


      if (strpos($name, "email")) {
        if ($this->isEmail($input)) {
          if ($this->isTakenEmail($input)) {
            $this->output[$name] = '';
            unset($this->output[$name]);
          } else {
            $this->output[$name] = ' The email you have entered is already registered!';
          }
        } else {
          $this->output[$name] = 'Not Emaild';
        }
      }

      if (strpos($name, "contact")) {
        if ($this->isContact($input)) {
          if ($this->isTakenContact($input)) {
            $this->output[$name] = '';
            unset($this->output[$name]);
          } else {
            $this->output[$name] = ' taken phone!';
          }
        } else {
          $this->output[$name] = ' Not Phone';
        }
      }

      if (strpos($name, "username")) {
        if ($this->isTakenUsername($input)) {
          $this->output[$name] = '';
          unset($this->output[$name]);
        } else {
          $this->output[$name] = ' Username Not available';
        }
      }
      
     



      if (strpos($name, "password")) {
        if ($compare_input == "") {
          if (empty($input)) {
            $this->output[$name] = $message;
          } else {
            $this->output[$name] = '';
            unset($this->output[$name]);
          }
        } else {


          if (strpos($name, "password")) {
            if ($this->hasMeet($input)) {
              $this->output[$name] = '';
              unset($this->output[$name]);
            } else {
              $this->output[$name] = ' Password does not meet thge requirment';
            }
          }


          if (strpos($name, "retype")) {
            if (empty($compare_input)) {
              $this->output[$name] = $message;
            } else {
              if ($this->isMatch($input, $compare_input)) {
                $this->output[$name] = '';
                unset($this->output[$name]);
              } else {
                $this->output['account_retype_password_error'] = ' Not Match';
              }
            }
          }

          
        }
      }
    }
  }


  public function login_attempt($user, $table) {
    $query = $this->connect()->prepare("SELECT attempt FROM user where ".$table." = :email AND attempt >= 3");
    $query->execute([':email' => $user]);

    if (!$query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }


  public function validateSelectorLength($input, $name, $message)
  {
    if ($input == "none") {
      $this->output[$name] = $message;
    } else {
      $this->output[$name] = '';
      unset($this->output[$name]);
    }
  }

  public function isContact($input)
  {
    if (strlen($input) == 11 && is_numeric((int)$input)) {
      return true;
    } else {
      return false;
    }
  }

  public function isEmail($input)
  {
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
      return true;
    } else {

      return false;
    }
  }

  public function isTakenEmail($input)
  {
    $query = $this->connect()->prepare("SELECT email FROM user where email = :email");
    $query->execute([':email' => $input]);

    if (!$query->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function isMatch($input, $compare_input)
  {


    if ($input == $compare_input) {
      return true;
    } else {
      /* $this->output[$name] = $message; */

      return false;
    }
  }
  public function hasMeet($input)
  {


    if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/', $input)) {
      return true;
    } else {

      return false;
    }
  }




  public function isTakenContact($input)
  {


    $query = $this->connect()->prepare("SELECT contact FROM user where contact = :contact");
    $query->execute([':contact' => $input]);


    if (!$query->rowCount() > 0) {
      return true;
    } else {

      return false;
    }
  }


  public function isTakenUsername($input)
  {

    $query = $this->connect()->prepare("SELECT username FROM user where username = :username");
    $query->execute([':username' => $input]);

    if (!$query->rowCount() > 0) {
      return true;
    } else {

      return false;
    }
  }

  public function validate_code()
  {
    if (isset($_GET["code"])) {
      $url_code = $_GET["code"];
      // if($code != 0) {


      $query = $this->connect()->prepare("SELECT * FROM user WHERE code = :code");
      $query->execute([':code' => $url_code]);

      if ($query->rowCount() > 0) {
        /*  $fetch = $query->fetch(PDO::FETCH_ASSOC);
              $fetch_user_id = $fetch['user_id'];
             
              return  $fetch_user_id; */
        return  true;
      } else {
        //if code does not exist in the  database

        header('location: error');
      }
      //}
    } else {
      //if the url has no parameter
      header('location: error');
    }
  }

  public function get_user_id($url_code)
  {
    $query = $this->connect()->prepare("SELECT * FROM user WHERE code = :code");
    $query->execute([':code' => $url_code]);

    if ($query->rowCount() > 0) {
      $fetch = $query->fetch(PDO::FETCH_ASSOC);
      $fetch_user_id = $fetch['user_id'];

      return  $fetch_user_id;
    } else {
      //if code does not exist in the  database

      return false;
    }
  }
}
