<?php


require_once dirname(__FILE__) . '/../classes/Menu.php';
require_once dirname(__FILE__) . '/../classes/Validate.php';

$menu = new Menu();
$validate = new Validate();

if (isset($_POST["action_menu"])) {

    if ($_POST['action_menu'] == 'Add' || $_POST['action_menu'] == 'Update') {
        

        $menu_id = $_POST["menu_id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $category = $_POST["category"];
        $discount = $_POST["discount"];
        $price = $_POST["price"];
        $date = $_POST["date"];
        $availability = $_POST["availability"];


        if ($_POST["edit_menu_image"] =="") {
            $image = $_FILES["image"]["tmp_name"];
        } else {
            $image = $_POST["edit_menu_image"];
        }
      
      

      
      
      $output = array();
      
   
     $validate->validateLength($name,'','name_error', 'Required' );
     $validate->validateLength($description,'','description_error', 'Required' );
     $validate->validateLength($category,'','category_error', 'Required' );
     $validate->validateLength($discount,'','discount_error', 'Required' );
     $validate->validateLength($price,'','price_error', 'Required' );
     $validate->validateLength($date,'','date_error', 'Required' );
     /* $validate->validateLength($availability,'','availability_error', 'Required' ); */
     $validate->validateLength($image,'','image_error', 'Required' );


    


        if (count($validate->output) > 0) {
            echo json_encode($validate->output);
        } else {
            if ($_POST['action_menu'] == 'Add') {

             
                $menu->add($menu_id, $name, $description, $category, $discount, $price, $date, $availability, $image);

            }


            if ($_POST['action_menu'] == 'Update') {



                $menu->edit($menu_id, $name, $description, $category, $discount, $price, $date, $availability, $image);
              
            }
        }
    }
    if ($_POST['action_menu'] == 'fetch') {

        $menu->fetch();
   
    }





    if ($_POST['action_menu'] == 'delete') {

        $menu->delete($_POST["id"]);

    }
    
} else {
    if (isset($_GET['fetch'])) {
        $menu->filter();
    }
}


if (isset($_POST["display_menu"])) {
$menu->display_menu();
} 