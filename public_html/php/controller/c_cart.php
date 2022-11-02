<?php
require dirname(__FILE__) . '/../classes/Cart.php';


$cart = new Cart();



if (isset($_POST["add_to_cart"]) == 'add_to_cart') {
    $quantity = $_POST['quantity'];
    $cart_menu_id = $_POST['cart_menu_id'];
    $user_id = $_POST['user_id']; 

    $cart->add_to_cart($user_id, $cart_menu_id, $quantity  );
 
   
}

if (isset($_POST["add_to_cart_count"]) == 'add_to_cart_count') {
    
    $user_id = $_POST['user_id']; 
    $cart->add_to_cart_count($user_id );
 
   
}



if (isset($_POST["display_cart"])) {

    $user_id = $_POST['user_id'];
    $cart->display_cart($user_id);
    } 

