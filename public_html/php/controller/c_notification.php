<?php
require dirname(__FILE__) . '/../classes/Notification.php';
require dirname(__FILE__) . '/../classes/Validate.php';

$validate = new Validate();

$notification = new Notification();

/* -------------------- notification */
if (isset($_POST["display_notification"])) {
    if ($validate->is_logged_in("customer")) {
        $output['error'] = "0";
        echo json_encode($output);
    } else {
        $user_id = $_SESSION['user_id'];
        $user_type = $_SESSION['user_type'];
        if ($user_type == "customer") {
            $notification->display_notification($user_id, "customer");
        } else {
            $notification->display_notification($user_id, "admin");
        }
    }
}
if (isset($_POST["notification_count"])) {
    if ($validate->is_logged_in("customer")) {
        $output['error'] = "0";
        echo json_encode($output);
    } else {
        $user_id = $_SESSION['user_id'];
        $user_type = $_SESSION['user_type'];
        if ($user_type == "customer") {
            $notification->notification_count($user_id, "customer");
        } else {
            $notification->notification_count($user_id, "staff");
        }
    }
}

if (isset($_POST["update_notification"])) {
    if ($validate->is_logged_in("customer")) {
        $output['error'] = "0";
        echo json_encode($output);
    } else {
        $user_id = $_SESSION['user_id'];
        $user_type = $_SESSION['user_type'];
        if ($user_type == "customer") {
            $notification->update_notification($user_id, "customer");
        } else {
            $notification->update_notification($user_id, "staff");
        }
    }
}

/* -------------------- newsletter */
if (isset($_POST["newsletter"])) {
    $email = $_POST['email'];
    $validate->validate_length($email, 'email-newsletter', 'newsletter_email_error', 'Required field');
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $notification->newsletter($email);
    }
}

/* -------------------- contact-us.php */
if (isset($_POST["send_email_message"])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $validate->validate_length($name, '', 'name_error', 'Required field');
    $validate->validate_length($email, 'email-contact', 'email_error', 'Required field');
    $validate->validate_length($subject, '', 'subject_error', 'Required field');
    $validate->validate_length($message, '', 'message_error', 'Required field');

    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $notification->send_email_message($name, $email, $subject, $message);
    }
}
