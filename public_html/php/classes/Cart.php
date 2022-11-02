<?php
session_start();

require_once dirname(__FILE__) . "/DbConnection.php";

class Cart extends DbConnection
{
    public function add_to_cart($user_id, $cart_menu_id, $quantity)
    {
        $query = $this->connect()->prepare("INSERT INTO cart (user_id, menu_id, quantity) VALUES( :user_id, :menu_id, :quantity)");

        $result = $query->execute([":user_id" => $user_id, ":menu_id" => $cart_menu_id, ":quantity" => $quantity]);

        if ($result ) {
            $output['success'] = '<div class="alert alert-success">Verification code has been sent to </div>';
            echo json_encode($output);
        } else {
            $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.1</div>';
            echo json_encode($output);
        }
    }

    public function add_to_cart_count($user_id){
        $query = $this->connect()->prepare("SELECT * FROM cart WHERE user_id = :user_id");
$result = $query->execute([":user_id" => $user_id]);

if ($result ) {
    $output['cart_count'] = $query->rowCount();
    echo json_encode($output);
} else {
    $output['error'] = '<div class="alert alert-success">Something went wrong! Please try again later.1</div>';
    echo json_encode($output);
}
    
    }







    public function display_cart($user_id) {
        $data = array();
		

		$query = $this->connect()->prepare ("SELECT * FROM cart WHERE user_id = :user_id");


         $query->execute([":user_id" => 1]);


        if ($query->rowCount() > 0) {


            
		$result = $this->connect()->query($query);
		foreach ($result as $row) {
			$sub_array = array();

			$sub_array['cart_id'] = $row['cart_id'];
			$sub_array['user_id'] = $row['user_id'];
			$sub_array['menu_id'] = $row['menu_id'];
			$sub_array['quantity'] = $row['quantity'];
			$data[] = $sub_array;
		}

		$output = array(
			"data"				=>	$data
		);
	
		echo json_encode($output);
        
        } else {
            $output['error'] = 'No cartt' .$user_id;
            echo json_encode($output);
        }
    }
}
