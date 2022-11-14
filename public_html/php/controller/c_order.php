<?php
require dirname(__FILE__) . '/../classes/Order.php';
require_once dirname(__FILE__) . '/../classes/Validate.php';

$order = new Order();
$validate = new Validate();



/* order.php */
if (isset($_POST["display_order"])) {
    $user_id = $_SESSION['user_id'];
    $order->display_order($user_id);
}
if (isset($_POST["display_completed_order"])) {
    $user_id = $_SESSION['user_id'];
    $order->display_completed_order($user_id);
}
if (isset($_POST["delete_order"])) {
    $order_id = $_POST['order_id'];
    $order->delete_order($order_id);
}

/* cart.php */
if (isset($_POST["add_order"]) == 'add_order') {
    $cartlist = $_POST['cartlist'];
    $user_id = $_SESSION['user_id'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $order->add_order($user_id, $cartlist, $date, $time);
}

if (isset($_POST["qr_claim_order"]) == 'qr_claim_order') {
    $qr_code_id = $_POST['qr_code_id'];

    $order->claim_order("","",$qr_code_id);
}
if (isset($_POST["claim_order"]) == 'claim_order') {
    $order_id = $_POST['order_id'];
    $user_id = $_POST['user_id'];
 

    $order->claim_order($order_id, $user_id,"");
}

if (isset($_POST["qr_fetch_info"]) == 'qr_fetch_info') {
    $qr_code_id = $_POST['qr_code_id'];

    $order->qr_fetch_info($qr_code_id);
}

















/* --------------------admin */
if (isset($_POST["action_order"])) {

    if ($_POST['action_order'] == 'Add' || $_POST['action_order'] == 'Update') {


        $order_id = $_POST["order_id"];
        /*  $customer_name = $_POST["customer_name"];
        $order_name = $_POST["order_name"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $total_price = $_POST["total_price"]; */
        $date = $_POST["date"];
        $time = $_POST["time"];
        $status = $_POST["status"];




        $output = array();


        /*    $validate->validateLength($customer_name,'','customer_name_error', 'Required' );
     $validate->validateLength($order_name,'','order_name_error', 'Required' );
     $validate->validateLength($price,'','price_error', 'Required' );
     $validate->validateLength($quantity,'','quantity_error', 'Required' );
     $validate->validateLength($total_price,'','total_price_error', 'Required' ); */

        /*      $validate->validateLength($date,'','date_error', 'Required' );
     $validate->validateLength($time,'','time_error', 'Required' );
     $validate->validateLength($status,'','status_error', 'Required' );
 */




        if (count($validate->output) > 0) {
            echo json_encode($validate->output);
        } else {
            if ($_POST['action_order'] == 'Add') {

                $order->add($order_id,  $date, $time, $status);
                /*  $order->add( $order_id, $customer_name, $order_name, $price, $quantity, $total_price , $date, $time, $status); */
            }


            if ($_POST['action_order'] == 'Update') {



                /*  $order->edit($order_id, $customer_name, $order_name, $price, $quantity, $total_price , $date, $time, $status); */
                $order->admin_edit_order($order_id,  $date, $time, $status);
            }
        }
    }
    if ($_POST['action_order'] == 'fetch') {

        $order->fetch();
    }





    if ($_POST['action_order'] == 'delete') {
        $del_notif = $_POST['del_notif'];
        $order_id = $_POST['order_id'];
        $user_id = $_POST['user_id'];
        $order->admin_delete_order($order_id, $user_id, $del_notif);
    }
} else {
    if (isset($_GET['fetch'])) {
        $order->filter();
    }
}

/* 
if (isset($_POST["display_menu"])) {
    $order->display_menu();
}
 */