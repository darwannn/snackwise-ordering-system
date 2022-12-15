<?php

use function GuzzleHttp\Promise\each;

require_once dirname(__FILE__) . "/DbConnection.php";




class User extends DbConnection {

    // Display all users 
    public function display_users() {

        $query = 'SELECT user_id, CONCAT(firstname," ", lastname) AS fullname, email, user_type FROM user WHERE (user_type="customer") OR (user_type="staff")';

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
            $output['success'] = 'User'. $userID .' Deleted';
        }
        else {
            $output['error'] = 'Something went wrong! Please try again later';
        }

        return json_encode($output);

    }

    // Update user
    public function update_user($user_id, $new_type) {
        $query = 'UPDATE user SET user_type = :user_type WHERE user_id = :user_id';
        $stmt = $this->connect()->prepare($query);

        $result = $stmt->execute([
            'user_type' => $new_type,
            'user_id' => $user_id
        ]);

        if($result) {
            $output['success'] = 'User ' . $user_id . ' updated.';
        }
        else {
            $output['error'] = 'Something went wrong! Please try again later';
        }

        return json_encode($output); 
    }

}

?>