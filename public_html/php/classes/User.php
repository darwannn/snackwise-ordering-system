<?php

use function GuzzleHttp\Promise\each;

require_once dirname(__FILE__) . "/DbConnection.php";




class User extends DbConnection {

    // Display all staffs

    public function display_staff() {

        // $mysqli = new mysqli("localhost", "root", "", "snackwise");

        // if ($mysqli->connect_error) {
        //     die("Connection failed: " . $mysqli->connect_error);
        // }

        $query = 'SELECT user_id, CONCAT(firstname," ", lastname) AS fullname, email, user_type FROM user';

        // $result = $mysqli->query($query);

        // // Fetch the rows as an associative array
        // $rows = array();
        // while ($row = $result->fetch_assoc()) {
        //     $rows[] = $row;
        // }

        // // Convert the array to a JSON object and print it
        // return json_encode($rows);

        $stmt = $this->connect()->prepare($query);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);


        
    }

}

?>