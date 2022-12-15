<?php

use function GuzzleHttp\Promise\each;

require_once dirname(__FILE__) . "/DbConnection.php";




class User extends DbConnection {

    // Display all users 

    public function display_staff() {

        $query = 'SELECT user_id, CONCAT(firstname," ", lastname) AS fullname, email, user_type FROM user';

        $stmt = $this->connect()->prepare($query);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($result);
        
    }

    // Delete users 

    public function delete_user($userID) {
        $query = 'DELETE FROM user WHERE user_id = :user_id';
        $stmt = $this->connect()->prepare($query);

        $result = $stmt->execute(['user_id' => $userID]);

        if($result) {
            $output['success'] = 'User Deleted';
        }
        else {
            $output['error'] = 'Something went wrong! Please try again later';
        }

        return json_encode($output);

    }

}

?>