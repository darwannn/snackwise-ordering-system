<?php
require dirname(__FILE__) . '/../classes/Closed_Date.php';
require dirname(__FILE__) . '/../classes/Validate.php';

$closed_date = new Closed_Date();
$validate = new Validate();
$closed_date->delete_past_closed_date();
if (isset($_POST["display_closed_date"]) == 'display_closed_date') {
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $closed_date->display_closed_date();
    }
}
if (isset($_POST["add_closed_date"]) == 'add_closed_date') {

    date_default_timezone_set('Asia/Manila');
    $date_today = date('Y-m-d');

    $date = $_POST['date'];
    $day_in_numbers  = date("Y-m-d", strtotime($date));

    if ($validate->validate_date($date)) {
        $output['error'] = 'Date already added';
        echo json_encode($output);
    } else {
        if($date_today !=  $day_in_numbers) {
        $closed_date->add_closed_date($day_in_numbers);
        }else {
            $output['error'] = 'Select another date';
            echo json_encode($output);
        }
    }
}
if (isset($_POST["delete_closed_date"]) == 'delete_closed_date') {
    $closed_date_id = $_POST['closed_date_id'];
    if (count($validate->output) > 0) {
        echo json_encode($validate->output);
    } else {
        $closed_date->delete_closed_date($closed_date_id);
    }
}
