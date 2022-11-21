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
    

}