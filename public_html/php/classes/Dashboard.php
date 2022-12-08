<?php
/* session_start(); */

require_once dirname(__FILE__) . "/DbConnection.php";


class Dashboard  extends DbConnection{
    public function display_dashboard($startdate,$enddate) {
        $result = $query = $this->connect()->prepare("SELECT date, SUM(price) AS profit FROM transaction WHERE date BETWEEN :startdate AND :enddate GROUP BY date");
        $query->execute([":startdate"=>$startdate,":enddate"=>$enddate]);
		if ($result->rowCount() > 0) {
		$data = array();
		foreach ($result as $row) {
			$sub_array = array();
			$sub_array['date'] = $row['date'];
			$sub_array['profit'] = $row['profit'];
			$data[] = $sub_array;
		}
		$output = array("data"=>$data);
	} else {
		$output['empty'] = "No items found";
	}
		echo json_encode($output);
	}

	public function get_information() {
		$sub_array = array();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $total_orders = $this->connect()->prepare("SELECT order_id, date FROM orders WHERE status != :status");
        $total_orders->execute([":status" => "Cancelled"]);
        $sub_array['total_orders'] =    $total_orders->rowCount();

        $total_pending = $this->connect()->prepare("SELECT order_id, date FROM orders WHERE status = :confirmed_status OR status = :placed_status");
        $total_pending->execute([":confirmed_status" => "Confirmed",":placed_status" => "Placed"]);
        $sub_array['total_pending'] =    $total_pending->rowCount();

        $total_cancelled = $this->connect()->prepare("SELECT order_id, date FROM orders WHERE status = :status");
        $total_cancelled->execute([":status" => "Cancelled"]);
        $sub_array['total_cancelled'] =    $total_cancelled->rowCount();

        $total_staffs = $this->connect()->prepare("SELECT user_id FROM user WHERE user_type = :user_type");
        $total_staffs->execute([":user_type" => 'staff']);
        $sub_array['total_staffs'] =    $total_staffs->rowCount();

        $total_users = $this->connect()->prepare("SELECT user_id FROM user");
        $total_users->execute([]);
        $sub_array['total_users'] =    $total_users->rowCount();

        $total_items = $this->connect()->prepare("SELECT menu_id FROM menu");
        $total_items->execute([]);
        $sub_array['total_items'] =   $total_items->rowCount();

        $total_available = $this->connect()->prepare("SELECT menu_id FROM menu WHERE availability = :availability");
        $total_available->execute([":availability" => 'Available']);
        $sub_array['total_available'] =    $total_available->rowCount();

        $data[] = $sub_array;

        $output = array("data" => $data);
        echo json_encode($output);
	}
    

}