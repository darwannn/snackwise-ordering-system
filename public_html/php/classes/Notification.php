<?php

require_once dirname(__FILE__) . '/../../vendor/autoload.php';
require_once dirname(__FILE__) . "/DbConnection.php";
require_once dirname(__FILE__) . "/Email.php";
require_once dirname(__FILE__) . "/Account.php";

class Notification extends DbConnection
{
     /* -------------------- notification */
    public function insert_notif( $user_id, $order_id, $type, $message) {
        $status = "unread";
        date_default_timezone_set('Asia/Manila');
        $date_time =  date("Y-m-d H:i:s");
        $query = $this->connect()->prepare("INSERT INTO notification ( user_id, order_id, type, message, date, status) VALUES( :user_id, :order_id, :type,:message, :date, :status)");
        $result = $query->execute([":user_id" => $user_id, ":order_id" => $order_id,":type" => $type,":message" => $message, ":date" => $date_time, ":status" => $status]);
    }

   /*  display all the notifications intended for the customer */
    public function display_notification($user_id, $type)
    {

        if($type == "customer") {
        $result = $query = $this->connect()->prepare("SELECT * FROM notification WHERE user_id =:user_id ORDER BY date DESC");
        $query->execute([":user_id" => $user_id]);
    } else {
        $result = $query = $this->connect()->prepare("SELECT * FROM notification WHERE user_id =:user_id  ORDER BY date DESC");
        $query->execute([":user_id" => 0]);
    }
        if ($result) {
            $data = array();
            foreach ($result as $row) {
                $sub_array = array();
                $sub_array['notification_id'] = $row['notification_id'];
                $sub_array['user_id'] = $row['user_id'];
                $sub_array['message'] = $row['message'];
                $sub_array['date'] = $row['date'];
                $sub_array['status'] = $row['status'];
                $sub_array['type'] = $row['type'];
                $sub_array['order_id'] = $row['order_id'];
                $data[] = $sub_array;
            }
            $output = array("data"=>$data);
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }

    /*  count all the unread notification of a customer */
    public function notification_count($user_id, $type){
       
        if($type == "customer") {
            $query = $this->connect()->prepare("SELECT * FROM notification WHERE user_id = :user_id AND status = :status");
            $query->execute([":user_id" => $user_id, ":status" => 'unread']);
        } else {

            $query = $this->connect()->prepare("SELECT * FROM notification WHERE user_id = :user_id AND status = :status");
            $query->execute([":user_id" => 0, ":status" => 'unread']);
        }
       
    
        $output['notification_count'] = $query->rowCount();
        echo json_encode($output);
    }

    /* changes the status of notification from unread to read  */
    public function update_notification($user_id, $type){
        $status = 'read';
        if($type == "customer") {
            $query  = $this->connect()->prepare("UPDATE notification SET status = :status WHERE user_id = :user_id");
            $query->execute([':status' => $status, ':user_id' => $user_id]);
        } else {

            $query  = $this->connect()->prepare("UPDATE notification SET status = :status WHERE user_id = :user_id");
            $query->execute([':status' => $status, ":user_id" => 0 ]);
        }
        echo json_encode("");
    }

     /* -------------------- newsletter*/
    public function newsletter($email) {
        $status =  "unverified";
        $account = new Account();
        $validate = new Validate();
        $code = $account->generate_code();
        $query = $this->connect()->prepare("SELECT * FROM newsletter WHERE email = :email");
        $query->execute([':email' => $email]);
        if  ($query->rowCount() > 0) {
            $query = $this->connect()->prepare("UPDATE newsletter SET code=:code, status =:status WHERE email =:email");
             $result = $query->execute([":code" => $code,":status"=>'unverified',":email"=>$email]); 
            } else {
        $query = $this->connect()->prepare("INSERT INTO newsletter (email, code, status) VALUES( :email, :code, :status  )");
        $result = $query->execute([":email" => $email,":code" => $code,":status" => $status]);
    }
        if ($result) {
            $newsletter_verification = new Email();
            $subject = 'SnackWise Newsletter Subscription';
            $notice = "Click the button below <br> to subscribe in our newsletter.";
            $link = "/subscribe.php?code=" . $code;
            $button_value = "Subscribe";
            $body = $account->email_template($link, $notice, $button_value);
            if ($newsletter_verification->sendEmail("SnackWise", $email, $subject, $body, "account")) {
                $output['success'] = 'To verify your subscription, we have sent an email to '.$email.'';
            } else {
                $output['error'] = 'Something went wrong! Please try again later.';
            }
            
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
            
        }
        echo json_encode($output);
    }

    /* subscribe.php */
     /* changes the status of the newsletter subscription to subscribed */
     public function subscribe()
     {
         $url_code = $_GET["code"];
         $status = "subscribed";
         $code = 0;
         /* checks if the verification code in the URL parameter exists */
         $query  = $this->connect()->prepare("UPDATE newsletter SET code = :code, status = :status WHERE code = :url_code");
         $result = $query->execute([':code' => $code, ':status' => $status, ':url_code' => $url_code]);
         if ($result) {
             $_SESSION['activate_success'] = 'You have successfully subscribed to our newsletter.';
             header('Location: menu.php');
         } else {
             header('Location: error');
         }
     }

    /* -------------------- contact-us.php */
    /* invoked when a customer submits a message from contact us  */

    public function send_email_message($name, $email,$subject,$message){
        $email_verification = new Email();
       if ($email_verification->sendEmail("Customer: ". $name,$email, $subject, $message, "contact")) {
        $output['success'] = 'Message sent successfully';
    } else {
        $output['error'] = 'Something went wrong! Please try again later.';
    }
       echo json_encode($output);
    }
}
