<?php
    require dirname(__FILE__) .'/../PHPMailer/PHPMailerAutoload.php';

    class Email {

        public function sendEmail($email, $subject, $body) {
            $from = "smtpwebsitesmtp@gmail.com";
            $password = "youdtwsweknzggyz";

            date_default_timezone_set('Etc/UTC');
            $mail = new PHPMailer();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->SMTPKeepAlive = true;
            $mail->Mailer = "smtp";
            $mail->isSMTP();

            $mail->Host = gethostbyname('ssl://smtp.gmail.com');
            $mail->Host = 'smtp.gmail.com';
            $mail->Subject = $subject;
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth = true;
            $mail->Username = $from;
            $mail->Password = $password;
            $mail->FromName = "SnackWise";


            $mail->addAddress($email);
            $mail->msgHTML($body);
            return $mail->send();
        }
    }
?>