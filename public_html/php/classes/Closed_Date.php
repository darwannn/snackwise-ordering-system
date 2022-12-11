<?php
/* session_start(); */

require_once dirname(__FILE__) . "/DbConnection.php";

class Closed_Date extends DbConnection
{
    /*-------------------- STAFF -------------------- */
    /* closed-date.php */
    /* displays the date when the business is closed  */
    public function display_closed_date()
    {
        $result = $query = $this->connect()->prepare("SELECT closed_date_id, date FROM closed_date");
        $query->execute();
        if ($result) {
            $data = array();
            foreach ($result as $row) {
                $sub_array = array();
                $sub_array['date'] = date("F d, Y", strtotime($row["date"]));
                $sub_array['closed_date_id'] = $row["closed_date_id"];
                $sub_array['filter_date'] = $row["date"];
                $data[] = $sub_array;
            }
            $output = array("data" => $data);
        } else {
            $output['error'] = 'No available data';
        }
        echo json_encode($output);
    }


    /* adds the selected date to the closed date table  */
    public function add_closed_date($date)
    {  
        $query = $this->connect()->prepare("INSERT INTO closed_date (date) VALUES(:date)");
        $result = $query->execute([":date" => $date]);
        if ($result) {
            $output['success'] = 'Date added';
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }

    /* removes the selected date to the closed date table */
    public function delete_closed_date($closed_date_id)
    {
        $query = $this->connect()->prepare("DELETE FROM closed_date WHERE closed_date_id = :closed_date_id");
        $result = $query->execute([":closed_date_id" => $closed_date_id]);
        if ($result) {
            $output['success'] = 'Date deleted';
 
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }

    /*  deletes dates that already passed by */
    public function delete_past_closed_date()
    {
        $query  = $this->connect()->prepare("DELETE FROM closed_date WHERE UNIX_TIMESTAMP(NOW())- UNIX_TIMESTAMP(date) > :unixtime");
        $result = $query->execute([':unixtime' => 0]);
    }
}
