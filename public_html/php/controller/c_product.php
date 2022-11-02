<?php


require_once dirname(__FILE__).'/../classes/Product.php';
require_once dirname(__FILE__).'/../classes/Validate.php';

$product = new Product();
$validate = new Validate();

if (isset($_POST["action_product"])) {

    if ($_POST['action_product'] == 'Add' || $_POST['action_product'] == 'Update') {
        


       /*  $product_id = $_POST["product_id"]; */
        $product_name = $_POST["product_name"];
        $product_description = $_POST["product_description"];
        $product_category = $_POST["product_category"];
        $product_discount = $_POST["product_discount"];
        $product_price = $_POST["product_price"];
        $product_date = $_POST["product_date"];
        $product_availability = $_POST["product_availability"];
        $product_image = $_POST["product_image"];

  
      $output = array();
      
/*       $validate->validateLength($product_id, '', 'product_id_error', 'Required Field'); */
     /*  $validate->validateLength($product_name, '', 'product_name_error', 'Required Field');
      $validate->validateLength($product_description, '', 'product_description_error', 'Required Field');
      $validate->validateLength($product_category, '', 'product_category_error', 'Required Field');
      $validate->validateLength($product_discount, '', 'product_discount_error', 'Required Field');
      $validate->validateLength($product_price, '', 'product_price_error', 'Required Field');
      $validate->validateLength($product_date, '', 'product_date_error', 'Required Field');
      $validate->validateLength($product_availability, '', 'product_availability_error', 'Required Field'); */
      /* $validate->validateLength($product_image, '', 'product_image_error', 'Required Field'); */
    


              
    
        


        if (count($validate->output) > 0) {
            echo json_encode($validate->output);
        } else {
            if ($_POST['action_product'] == 'Add') {
                $product->add( /* $product_id, */ $product_name, $product_description, $product_category, $product_discount, $product_price, $product_date, $product_availability, $product_image);

            }

            if ($_POST['action_product'] == 'Update') {
                $product->edit($product_id, $product_name, $product_description, $product_category, $product_discount, $product_price, $product_date, $product_availability, $product_image);
            }
        }
    }
    if ($_POST['action_product'] == 'fetch') {

        $product->fetch();
    }





    if ($_POST['action_product'] == 'delete') {

        $product->delete($_POST["id"]);

    }
   
} else {
    if (isset($_GET['fetch'])) {
        $product->filter();
    }
}
