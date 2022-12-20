<?php
/* session_start(); */

require_once dirname(__FILE__) . "/DbConnection.php";
require_once dirname(__FILE__) . "/Image.php";
require_once dirname(__FILE__) . "/../../vendor/phpqrcode/qrlib.php";
require_once dirname(__FILE__) . '/../classes/Validate.php';
require_once dirname(__FILE__) . '/../classes/Notification.php';
require_once dirname(__FILE__) . '/../classes/Cart.php';


class Order extends DbConnection
{

    /* -------------------- order.php*/
    /* invoked when the items on the cart have been ordered by the customer */
    public function add_order($user_id, $cartlist, $date, $time)
    {
        $status = "Placed";
        $qr_code = $this->generate_qr_code();

        /* generates a QR code image and placed it in a temporary folder,
        once it has been uploaded to cloud storage, the temporary file will be deleted */
        $PNG_TEMP_DIR = '../../img/temp/';
        $filename = $PNG_TEMP_DIR . $qr_code . '.png';
        QRcode::png($qr_code, $filename);
        $qr_directory =  $PNG_TEMP_DIR . $filename;
        $upload_image = new Image();
        $data = $upload_image->upload_image($qr_directory, $qr_code, "SnackWise/QR/");
        $image_link = "v" . $data['version'] . "/" . $data['public_id'];

        unlink($PNG_TEMP_DIR . $qr_code . '.png');

        $cart = new Cart();
        $total_price = $cart->get_price($cartlist, "return");
        /* transfers selected item/s to the order table */
        $query = $this->connect()->prepare("INSERT INTO orders ( user_id, date, time, total_price, qr_code, qr_image, status) VALUES( :user_id, :date, :time, :total_price, :qr_code, :qr_image, :status)");
        $result = $query->execute([":user_id" => $user_id, ":date" => $date, ":time" => $time, ":total_price" => $total_price,  ":qr_code" => $qr_code, ":qr_image" => $image_link, ":status" => $status]);
        if ($result) {
            $cart_id = explode(',', $cartlist);
            for ($i = 0; $i < count($cart_id); $i++) {
                $query = $this->connect()->prepare("SELECT menu_id, quantity FROM cart where cart_id = :cart_id");
                $result = $query->execute([":cart_id" => $cart_id[$i]]);
                if ($query->rowCount() > 0) {
                    $fetch = $query->fetch(PDO::FETCH_ASSOC);
                    $fetch_menu_id = $fetch['menu_id'];
                    $fetch_quantity = $fetch['quantity'];

                    $query = $this->connect()->prepare("SELECT order_id FROM orders WHERE user_id = :user_id ORDER BY order_id DESC LIMIT 1");
                    $result = $query->execute(["user_id" => $user_id]);
                    $fetch = $query->fetch(PDO::FETCH_ASSOC);
                    $fetch_order_id = $fetch['order_id'];

                    $query = $this->connect()->prepare("INSERT INTO orderlist (order_id, menu_id, quantity) VALUES( :order_id, :menu_id, :quantity)");
                    $result = $query->execute([":order_id" => $fetch_order_id, ":menu_id" => $fetch_menu_id, ":quantity" => $fetch_quantity]);
                }

                $query = $this->connect()->prepare("DELETE FROM cart where cart_id = :cart_id");
                $result = $query->execute([":cart_id" => $cart_id[$i]]);
            }

            $notification = new Notification();
            $status = "Placed";
            $message = "Your order is now confirmed and now processing";
            $notification->insert_notif($user_id, $fetch_order_id, $status, $message);
            $user_type = $_SESSION['user_type'];
            if ($user_type != "admin" && $user_type != "staff") {
                $staff_message = "An order has been placed.";
                $notification->insert_notif(0, $fetch_order_id, $status, $staff_message);
            }
            $output['success'] = 'Order Successfully Placed';
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }

    /* gets and display all the ordered items of the logged-in customer */
    public function display_order($column_identifier, $category)
    {

        /* determines whether the item to be displayed will come from the order table  or transaction table (where the picked-up order is saved) */
        if ($category != "Completed") {
            $sql = "SELECT o.user_id, u.firstname, u.lastname, o.order_id, o.date, o.time, o.qr_image,o.status,m.menu_id AS menu_id_list, m.name AS menu_name_list , GROUP_CONCAT(m.price -(m.price * (m.discount/100)) SEPARATOR '') AS price_list, o.total_price AS total_price, SUM((m.price -(m.price * (m.discount/100)))) AS discounted_price,GROUP_CONCAT(l.quantity SEPARATOR '') AS quantity_list, SUM(l.quantity) AS total_quantity, m.category AS category_list,  m.description, m.discount AS discount_list, m.image AS image_list, l.orderlist_id FROM user u INNER JOIN orders o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id INNER JOIN menu m ON l.menu_id = m.menu_id ";

            if ($category == "details") {

                $query = $this->connect()->prepare("SELECT o.user_id, u.firstname, u.lastname, o.order_id, o.date, o.time, o.qr_image,o.status,m.menu_id AS menu_id_list, m.name AS menu_name_list , l.quantity AS quantity_list, o.total_price AS total_price, (m.price -(m.price * (m.discount/100))) AS discounted_price, m.category AS category_list,  m.description, m.price AS price_list, m.discount AS discount_list, m.image AS image_list, l.orderlist_id FROM user u INNER JOIN orders o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id INNER JOIN menu m ON l.menu_id = m.menu_id WHERE o.order_id = :column_identifier");

                $query->execute([":column_identifier" => $column_identifier]);
            } else if ($category == "All") {

                $sql .= " WHERE o.user_id = :column_identifier GROUP BY l.order_id ORDER BY o.order_id DESC";
                $query = $this->connect()->prepare($sql);
                $query->execute([":column_identifier" => $column_identifier]);
            } else if ($category == "Pending") {

                $sql .= "WHERE u.user_id = :column_identifier AND (o.status = :c_status OR o.status = :p_status) GROUP BY l.order_id ORDER BY o.order_id DESC";
                $query = $this->connect()->prepare($sql);
                $query->execute([":column_identifier" => $column_identifier, ":c_status" => 'Confirmed', ":p_status" => 'Placed']);
            } else {
                $sql .= "WHERE u.user_id = :column_identifier AND o.status = :status GROUP BY l.order_id ORDER BY o.order_id DESC";
                $query = $this->connect()->prepare($sql);
                $query->execute([":column_identifier" => $column_identifier, ":status" => $category]);
            }
        } else  if ($category == "Completed" && $category != "details-completed") {
            $query = $this->connect()->prepare("SELECT o.total_price AS total_price, SUM((m.price -(m.price * (m.discount/100)))) AS discounted_price, o.user_id AS total_quantity, o.user_id, u.firstname, u.lastname, o.order_id, o.date,m.menu_id AS menu_id_list, m.name AS menu_name_list , l.quantity AS quantity_list, m.category AS category_list, m.price AS price_list, m.discount AS discount_list, m.image AS image_list FROM user u INNER JOIN transaction o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id INNER JOIN menu m ON l.menu_id = m.menu_id WHERE u.user_id = :user_id  GROUP BY l.order_id ORDER BY o.order_id DESC");
            $query->execute(["user_id" => $column_identifier]);
        }

        if ($category == "details-completed") {
            $query = $this->connect()->prepare("SELECT ((m.price -(m.price * (m.discount/100)))) AS discounted_price, o.total_price AS total_price, o.user_id AS total_quantity, o.user_id, u.firstname, u.lastname, o.order_id, o.date,m.menu_id AS menu_id_list, m.name AS menu_name_list , l.quantity AS quantity_list, m.category AS category_list, m.price AS price_list, m.discount AS discount_list, m.image AS image_list FROM user u INNER JOIN transaction o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id INNER JOIN menu m ON l.menu_id = m.menu_id WHERE o.order_id = :order_id ");
            $query->execute([":order_id" => $column_identifier]);
        }
        $result = $query->fetchAll();
        if ($query->rowCount() > 0) {
            $data = array();

            foreach ($result as $row) {
                $sub_array = array();
                $sub_array['user_id'] = $row['user_id'];
                $sub_array['firstname'] = $row['firstname'];
                $sub_array['lastname'] = $row['lastname'];
                $sub_array['order_id'] = $row['order_id'];
                $sub_array['date'] = $row['date'];
                $sub_array['menu_id_list'] = $row['menu_id_list'];
                $sub_array['menu_name_list'] = $row['menu_name_list'];
                $sub_array['quantity_list'] = $row['quantity_list'];
                $sub_array['category_list'] = $row['category_list'];
                $sub_array['price_list'] = $row['price_list'];
                $sub_array['image_list'] = $row['image_list'];
                $sub_array['discounted_price'] = $row['discounted_price'];
                $sub_array['total_price'] = $row['total_price'];

                if ($category == "Completed" || $category != "details") {
                    $sub_array['total_quantity'] = $row['total_quantity'];
                }

                if ($category != "Completed" && $category != "details-completed") {
                    $sub_array['orderlist_id'] = $row['orderlist_id'];
                    $sub_array['time'] = $row['time'];
                    $sub_array['qr_image'] = $row['qr_image'];
                    $sub_array['description'] = $row['description'];
                    $sub_array['status'] = $row['status'];
                }
                $data[] = $sub_array;
            }
            $output = array("data" => $data);
        } else {
            $output['error'] = 'No orders yet';
        }
        echo json_encode($output);
    }

    /* invoked when the customer cancelled its order, only items with 'placed' status can be cancelled */
    public function delete_order($order_id, $user_id)
    {
        if ($this->cancel_order($order_id)) {
            $output['success'] = 'Order has been cancelled';
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }



    /* -------------------- STAFF --------------------*/
    /* -------------------- manage-order.php */
    public function admin_edit_order($order_id,  $date, $time, $status)
    {
        if ($_POST['action_order'] == 'Update') {
            $query = $this->connect()->prepare("UPDATE orders SET date = :date, time = :time, status = :status WHERE order_id = :order_id");
            $result = $query->execute([':date' => $date, ':time' => $time, ':status' => $status, ':order_id' => $order_id]);
            if ($result) {
                $output['success'] = 'Item Updated Successfully';
            } else {
                $output['error'] = 'Something went wrong! Please try again later.';
            }

            /* sends custom notification to the customer depending on its order status */
            $message = "";


            if ($status == "Placed") {
                /* $notif_type = "Placed"; */
                $message = "Your order is now confirmed and now processing";
                /*      $message = "Your order " . str_pad($order_id, 10, "0", STR_PAD_LEFT) . " is now confirmed and now processing"; */
            } else if ($status == "Preparing") {
                /* $notif_type = "Order on Process"; */
                $message = "They’re getting your food ready. You will recieve another notification if its ready.";
            } else if ($status == "Confirmed") {
                /* $notif_type = "Order Confirmed "; */
                $message = "Your order is now confirmed and will be processed in a few minutes.";
            } else if ($status == "Ready") {
                /* $notif_type = "Order Ready for Pickup!"; */
                $message = "Your order is now ready for pick-up. Grab it now while it's hot!";
            }

            $fetch_user_id = $this->get_customer_id($order_id);
            $notification = new Notification();
            $notification->insert_notif($fetch_user_id, $order_id, $status, $message);

            echo json_encode($output);
        }
    }

    /* invoked when changes have been made in date, time, or status */
    public function fetch_selected_order($order_id)
    {
        $result = $query = $this->connect()->prepare("SELECT m.price AS price, u.contact, m.discount AS discount, l.quantity AS quantity, u.user_id, o.order_id, CONCAT(u.firstname,' ', u.lastname) AS customer_name, GROUP_CONCAT(m.name SEPARATOR ', ') AS menu_name, GROUP_CONCAT(m.price SEPARATOR ', ') AS price_list, GROUP_CONCAT(l.quantity SEPARATOR ', ') AS quantity_list, o.date, o.time, o.status FROM user u INNER JOIN orders o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id  INNER JOIN menu m ON l.menu_id = m.menu_id WHERE o.order_id = :order_id GROUP BY l.order_id");
        $query->execute(["order_id" => $order_id]);
        $data = array();
        foreach ($result as $row) {

            $data['order_id'] = $row['order_id'];
            $data['date'] = $row['date'];
            $data['time'] = $row['time'];
            $data['status'] = $row['status'];
        }
        echo json_encode($data);
    }

    public function admin_delete_order($order_id, $user_id, $del_notif)
    {
        if ($this->cancel_order($order_id)) {
            $output['success'] = 'Order has been cancelled';
        } else {
            $output['error'] = 'Something went wrong! Please try again later.';
        }

        $status = "Cancelled";
        /* $notif_type = "Order Cancelled"; */

        /* reason */
        $message = $del_notif;
        $notification = new Notification();
        $fetch_user_id = $this->get_customer_id($order_id);

        $notification->insert_notif($fetch_user_id, $order_id, $status, $message);

        echo json_encode($output);
    }

    public function get_customer_id($order_id)
    {
        $query = $this->connect()->prepare("SELECT user_id FROM orders WHERE order_id = :order_id");
        $result = $query->execute([':order_id' => $order_id]);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        return $fetch['user_id'];
    }

    /*  transfer claimed order from the orders table to the transaction table */
    public function claim_order($identifier, $type)
    {
        try {

            $query = $this->connect()->prepare("SELECT m.price AS price, o.total_price AS total_price, m.discount AS discount, l.quantity AS quantity, u.user_id, o.order_id, CONCAT(u.firstname,' ', u.lastname) AS customer_name, GROUP_CONCAT(m.name SEPARATOR ', ') AS menu_name, GROUP_CONCAT(m.price -(m.price * (m.discount/100))*l.quantity SEPARATOR ', ') AS price_list, GROUP_CONCAT(l.quantity SEPARATOR ', ') AS quantity_list, o.date, o.time, o.status FROM user u INNER JOIN orders o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id  INNER JOIN menu m ON l.menu_id = m.menu_id WHERE o.order_id = :identifier  GROUP BY l.order_id ORDER BY order_id DESC");
            $query->execute(["identifier" => $identifier]);

            if ($query->rowCount() > 0) {
                $fetch = $query->fetch(PDO::FETCH_ASSOC);
                $fetch_user_id =   $fetch['user_id'];
                $fetch_order_id = $fetch['order_id'];
                $fetch_total__price = $fetch['total_price'];

                date_default_timezone_set('Asia/Manila');
                $date = date('Y-m-d H:i:s');
                $query = $this->connect()->prepare("INSERT INTO transaction (order_id, user_id, date, total_price) VALUES( :order_id, :user_id, :date, :total_price)");
                $query->execute([":order_id" => $fetch_order_id, ":user_id" => $fetch_user_id, ":date" => $date, ":total_price" => $fetch_total__price]);
                $output['success'] = 'Order has been claimed';

                $query = $this->connect()->prepare("DELETE FROM orders where order_id = :order_id");
                $query->execute([":order_id" => $fetch_order_id]);

                $type = "Completed";

                $notification = new Notification();

                /*   $notif_type = "Thank You for Ordering "; */
                $status = "Completed";
                $message = "Thanks for your order. It’s always a pleasure to serve you. Enjoy your snack!";
                $notification->insert_notif($fetch_user_id, $fetch_order_id, $status, $message);
            } else {
                $output['error'] = 'Something went wrong! Please try again later.';
            }
        } catch (Exception $e) {
            $output['error'] = 'Something went wrong! Please try again later.';
        }
        echo json_encode($output);
    }


    /* invoke when the claim button or QR Image is scanned,
    it checks if the user_id or qr code is associated with an order, if true it will display the order */
    public function order_fetch_info($identifier, $type)
    {
        $column_identifier = "";
        if ($type == "qr") {
            $column_identifier = "o.qr_code";
        } else {
            $column_identifier = "o.order_id";
        }
        $query = $this->connect()->prepare("SELECT o.total_price AS total_price, o.user_id,o.qr_image, u.firstname, u.lastname,CONCAT(u.firstname,' ', u.lastname) AS name, o.order_id, o.date, o.time, o.qr_code,o.status,GROUP_CONCAT(m.menu_id SEPARATOR ', ') AS menu_id_list, GROUP_CONCAT(m.name SEPARATOR ', ') AS menu_name_list, GROUP_CONCAT(l.quantity SEPARATOR ', ') AS quantity_list, GROUP_CONCAT(m.category SEPARATOR ', ') AS category_list, GROUP_CONCAT(m.price -(m.price * (m.discount/100))*l.quantity SEPARATOR ', ') AS price_list,GROUP_CONCAT(m.discount SEPARATOR ', ') AS discount_list,GROUP_CONCAT(m.image SEPARATOR ', ') AS image_list FROM user u INNER JOIN orders o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id  INNER JOIN menu m ON l.menu_id = m.menu_id WHERE " . $column_identifier . " = :identifier GROUP BY l.order_id");

        $query->execute(["identifier" => $identifier]);
        if ($query->rowCount() > 0) {
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $fetch_status = $fetch['status'];
            /* determines if an order is ready to be claimed or not, if false a message showing that the order is not ready yet will appear */
            if ($fetch_status == "Ready" || $type == "delete") {
                $data = array();
                $sub_array = array();
                $sub_array['user_id'] = $fetch['user_id'];
                $sub_array['firstname'] = $fetch['firstname'];
                $sub_array['lastname'] = $fetch['lastname'];
                $sub_array['order_id'] = $fetch['order_id'];
                $sub_array['date'] = $fetch['date']; 
                $sub_array['time'] = $fetch['time'];
                $sub_array['qr_image'] = $fetch['qr_image'];
                $sub_array['status'] = $fetch['status'];
                $sub_array['menu_id_list'] = $fetch['menu_id_list'];
                $sub_array['menu_name_list'] = $fetch['menu_name_list'];
                $sub_array['discount_list'] = $fetch['discount_list'];
                $sub_array['quantity_list'] = $fetch['quantity_list'];
                $sub_array['category_list'] = $fetch['category_list'];
                $sub_array['price_list'] = $fetch['price_list'];
                $sub_array['image_list'] = $fetch['image_list'];
                $sub_array['total_price'] = $fetch['total_price'];

                $data[] = $sub_array;

                $output = array("data" => $data);
            } else {
                if($fetch_status == "Cancelled") {
                $output['error'] = 'Order has been cancelled';
                } else {
                    $output['error'] = 'Order is not ready yet';
                }
            }
        } else {
            $output['error'] = 'Could not find order';
        }
        echo json_encode($output);
    }

    /* fetch 5 orders, these will be the default items to be shown in the table */
    public function fetch_five()
    {
        $status = 'Cancelled';
        $result = $query = $this->connect()->prepare("SELECT m.price AS price, u.contact,  m.discount AS discount, l.quantity AS quantity, u.user_id, o.order_id, CONCAT(u.firstname,' ', u.lastname) AS customer_name,  GROUP_CONCAT(CONCAT(m.name, ' (x',l.quantity,')') SEPARATOR ', ') AS menu_name, GROUP_CONCAT(m.price -(m.price * (m.discount/100))*l.quantity SEPARATOR ', ') AS price_list, GROUP_CONCAT(l.quantity SEPARATOR ', ') AS quantity_list, o.date, o.time, o.status FROM user u INNER JOIN orders o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id  INNER JOIN menu m ON l.menu_id = m.menu_id WHERE o.status != :status GROUP BY l.order_id ORDER BY date ASC 
        LIMIT 5");
        $query->execute([":status" => $status]);
        $output = '';
        foreach ($result as $row) {
            $placed = "";
            $preparing = "";
            $ready = "";
            $confirmed = "";
            if ($row["status"] == "Placed") {
                $placed = "selected";
            } else if ($row["status"] == "Preparing") {
                $preparing = "selected";
            } else if ($row["status"] == "Ready") {
                $ready = "selected";
            } else if ($row["status"] == "Confirmed") {
                $confirmed = "selected";
            }
            date_default_timezone_set('Asia/Manila');
            $output .= '
           
		<tr>
            <td>' . $row["order_id"] . '</td>
            <td>' . $row["customer_name"] . '</td>
            <td>' . $row["contact"]  . '</td>
            <td>' . $row["menu_name"] . '</td>
        
            <td> <input min="' . date('Y-m-d') . '" type="date" class="form-control table-date" name="date" id="' . $row["order_id"] . 'new-date" value="' . $row["date"] . '" onchange="new Order().fetch_selected_order(' . $row["order_id"] . ',`new`)"/></td>
            <td> <input type="time" class="form-control table-time" name="time" id="' . $row["order_id"] . 'new-time" value="' . $row["time"] . '" onchange="new Order().fetch_selected_order(' . $row["order_id"] . ',`new`)"/></td>
            <td>
                <select name="status" id="' . $row["order_id"] . 'new-status" class="form-select" onchange="new Order().fetch_selected_order(' . $row["order_id"] . ',`new`)" onload="console.log(`1`)">
                    <option value="Placed" ' . $placed . '>Placed</option>
                    <option value="Confirmed" ' . $confirmed . '>Confirmed</option>
                    <option value="Preparing" ' . $preparing . '>Preparing</option>
                    <option value="Ready" ' . $ready . '>Ready</option>
                </select>
            </td>
            <td>
                <button type="button" onclick="new Order().del_notif(' . $row["order_id"] . ', ' . $row["user_id"] . ')" class="btn btn-delete btn-danger text-light"><i class="fa-solid fa-trash "></i></button>&nbsp;
                <button type="button" onclick="new Order().order_fetch_info(' . $row["order_id"] . ', `manual`)" class="btn btn-claim btn-success text-light">Claim</button>
            </td>
		</tr>
		';
        }
        return $output;
    }

    /* used to set pagination */
    public function count_all_data()
    {
        $status = 'Cancelled';
        $query = "SELECT o.order_id, CONCAT(u.firstname,' ', u.lastname) AS customer_name, GROUP_CONCAT(m.name SEPARATOR ', ') AS menu_name, GROUP_CONCAT(m.price SEPARATOR ', ') AS price_list, GROUP_CONCAT(l.quantity SEPARATOR ', ') AS quantity_list, o.date, o.time, o.status FROM user u INNER JOIN orders o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id  INNER JOIN menu m ON l.menu_id = m.menu_id WHERE o.status != :status GROUP BY l.order_id";
        $query = $this->connect()->prepare($query);
        $query->execute([":status" => $status]);
        return $query->rowCount();
    }

    /* filters the items in the table depending on the character entered by the staff in the search field */
    public function filter()
    {
        $startGET = filter_input(INPUT_GET, "start", FILTER_SANITIZE_NUMBER_INT);
        $start = $startGET ? intval($startGET) : 0;
        $lengthGET = filter_input(INPUT_GET, "length", FILTER_SANITIZE_NUMBER_INT);
        $length = $lengthGET ? intval($lengthGET) : 10;
        $searchQuery = filter_input(INPUT_GET, "searchQuery", FILTER_SANITIZE_STRING);
        $search = empty($searchQuery) || $searchQuery === "null" ? "" : $searchQuery;
        $sortColumnIndex = filter_input(INPUT_GET, "sortColumn", FILTER_SANITIZE_NUMBER_INT);
        $sortDirection = filter_input(INPUT_GET, "sortDirection", FILTER_SANITIZE_STRING);

        $column = array("o.order_id", "customer_name", "u.contact", "menu_name", "o.date", "o.time", "o.status", "");
        $sql = "SELECT m.price AS price, u.contact,  m.discount AS discount, l.quantity AS quantity, u.user_id, o.order_id, CONCAT(u.firstname,' ', u.lastname) AS customer_name,  GROUP_CONCAT(CONCAT(m.name, ' (x',l.quantity,')') SEPARATOR ', ') AS menu_name, GROUP_CONCAT(m.price -(m.price * (m.discount/100))*l.quantity SEPARATOR ', ') AS price_list, GROUP_CONCAT(l.quantity SEPARATOR ', ') AS quantity_list, o.date, o.time, o.status FROM user u INNER JOIN orders o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id  INNER JOIN menu m ON l.menu_id = m.menu_id";
        $status = 'Cancelled';

        $search =  substr($search, 1);
        $sql .= '
        WHERE o.status != :status AND (o.order_id LIKE "%' . $search . '%" 
        OR u.firstname LIKE "%' . $search . '%" 

        OR u.contact LIKE "%' . $search . '%"
        OR o.date LIKE "%' . $search . '%" 
        OR o.time LIKE "%' . $search . '%" 
        OR o.status LIKE "%' . $search . '%") 
            ';
        $sql .= ' GROUP BY l.order_id ';

        if ($sortColumnIndex != '') {
            $sql .= 'ORDER BY ' . $column[$sortColumnIndex] . ' ' . $sortDirection . ' ';
        } else {
            $sql .= 'ORDER BY date ASC ';
        }
        $sql1 = '';
        if ($length != -1) {
            $sql1 = 'LIMIT ' . $start . ', ' . $length;
        }

        $query = $this->connect()->prepare($sql);
        $query->execute([":status" => $status]);
        $number_filter_row = $query->rowCount();
        $result = $this->connect()->prepare($sql . $sql1);
        $result->execute([":status" => $status]);
        $data = array();
        foreach ($result as $row) {
            $placed = "";
            $preparing = "";
            $ready = "";
            $confirmed = "";
            if ($row["status"] == "Placed") {
                $placed = "selected";
            } else if ($row["status"] == "Preparing") {
                $preparing = "selected";
            } else if ($row["status"] == "Ready") {
                $ready = "selected";
            } else if ($row["status"] == "Confirmed") {
                $confirmed = "selected";
            }
            date_default_timezone_set('Asia/Manila');
            $sub_array = array();
            $sub_array[] = $row['order_id'];
            $sub_array[] = $row['customer_name'];
            $sub_array[] = $row['contact'];
            $sub_array[] = $row['menu_name'];
            $sub_array[] = ' <td>  <input min="' . date('Y-m-d') . '" type="date" class="form-control table-date" name="date" id="' . $row['order_id'] . 'filter-new-date" value="' . $row["date"] . '" onchange="new Order().fetch_selected_order(' . $row["order_id"] . ',`fetch-new`)"/></td>';
            $sub_array[] = ' <td> <input type="time" class="form-control table-time" name="time" id="' . $row['order_id'] . 'filter-new-time" value="' . $row["time"] . '" onchange="new Order().fetch_selected_order(' . $row["order_id"] . ',`fetch-new`)"/></td>';
            $sub_array[] = '  
            <td>
                <select value="' . $row["status"] . '" name="status" id="' . $row["order_id"] . 'filter-new-status" class="form-select" onchange="new Order().fetch_selected_order(' . $row["order_id"] . ',`fetch-new`)">
                    <option value="Placed" ' . $placed . '>Placed</option>
                    <option value="Confirmed" ' . $confirmed . '>Confirmed</option>
                    <option value="Preparing" ' . $preparing . '>Preparing</option>
                    <option value="Ready" ' . $ready . '>Ready</option>
                </select>
            </td>
            
           ';
            $sub_array[] = '
            <button type="button" onclick="new Order().del_notif(' . $row["order_id"] . ', ' . $row["user_id"] . ')" class="btn btn-danger text-light btn-delete"><i class="fa-solid fa-trash"></i></button>&nbsp;
            <button type="button" onclick="new Order().order_fetch_info(' . $row["order_id"] . ', `manual`)" class="btn btn-success text-light btn-claim">Claim</button>';
            $data[] = $sub_array;
        }
        $output = array("recordsTotal" => $this->count_all_data(), "recordsFiltered" => $number_filter_row, "data" => $data);
        echo json_encode($output);
    }


    /* order information */
    public function total_order_count()
    {
        $sub_array = array();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $total_completed_count = $this->connect()->prepare('SELECT order_id FROM transaction WHERE date = :date');
        $total_completed_count->execute([":date" => $date]);
        $sub_array['total_completed_count'] =    $total_completed_count->rowCount();

        $query = "SELECT o.order_id FROM user u INNER JOIN orders o ON u.user_id = o.user_id INNER JOIN orderlist l ON o.order_id = l.order_id  INNER JOIN menu m ON l.menu_id = m.menu_id";

        $total_cancelled_count = $this->connect()->prepare($query . ' WHERE o.status= :status AND o.date = :date GROUP BY l.order_id');
        $total_cancelled_count->execute([":status" => 'Cancelled', ":date" => $date]);
        $sub_array['total_cancelled_count'] =    $total_cancelled_count->rowCount();

        $total_unclaimed_count = $this->connect()->prepare($query . ' WHERE o.status = :status AND o.date = :date GROUP BY l.order_id');
        $total_unclaimed_count->execute([ ":status" => 'Ready', ":date" => $date]);
        $sub_array['total_unclaimed_count'] =    $total_unclaimed_count->rowCount();

        $total_preparing_count = $this->connect()->prepare($query . ' WHERE o.status = :status  AND o.date = :date GROUP BY l.order_id');
        $total_preparing_count->execute([":status" => 'Preparing', ":date" => $date]);
        $sub_array['total_preparing_count'] =    $total_preparing_count->rowCount();

        $total_placed_count = $this->connect()->prepare($query . ' WHERE o.status= :status AND o.date = :date GROUP BY l.order_id');
        $total_placed_count->execute([":status" => 'Placed', ":date" => $date]);
        $sub_array['total_placed_count'] =   $total_placed_count->rowCount();

        $total_order_count = $this->connect()->prepare($query . ' WHERE o.status != :status AND o.date = :date GROUP BY l.order_id');
        $total_order_count->execute([":status" => 'Cancelled', ":date" => $date]);
        $sub_array['total_order_count'] =    $total_order_count->rowCount();


        $data[] = $sub_array;

        $output = array("data" => $data);
        echo json_encode($output);
    }

    /* -------------------- */
    /* generates qr verification code */
    public function generate_qr_code()
    {
        $qr_code = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1, 6))), 1, 16);
        /* check if verification code already exist, if true it will regenerate again */
        $query = $this->connect()->prepare("SELECT * FROM orders WHERE qr_code = :qr_code");
        $query->execute([':qr_code' => $qr_code]);

        if ($query->rowCount() > 0) {
            $qr_code = $this->generate_qr_code();
        } else {
            return $qr_code;
        }
    }

    /* changes order status to Cancelled */
    public function cancel_order($order_id)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $status = "Cancelled";
        $notification = new Notification();
        $message = "An order has been cancelled";
        $notification->insert_notif(0, $order_id, $status, $message);
       
        $query = $this->connect()->prepare("UPDATE orders SET status = :status, date = :date WHERE order_id = :order_id");
        $result = $query->execute([":status" => $status, ":date" => $date, ":order_id" => $order_id]);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public function display_completed_order($filter)
    {
        // $query = 'SELECT * FROM transaction';
        $currentDate = date("Y-m-d");
        // $query = 'SELECT * FROM transaction WHERE DAY(date) = "'.$currentDate.'"';
       
        // -- ALL--
        $_SESSION['report_filter'] = $filter;

        if($filter == "alltime") {
            $query = 'SELECT transaction_id, CONCAT(user.firstname, " ", user.lastname) AS fullname, order_id, date, total_price 
            FROM transaction 
            INNER JOIN user ON user.user_id = transaction.user_id
            ORDER BY transaction_id DESC';
        }
        if($filter == "thisweek") {
            $query = 'SELECT transaction_id, CONCAT(user.firstname, " ", user.lastname) AS fullname, order_id, date, total_price 
            FROM transaction 
            INNER JOIN user ON user.user_id = transaction.user_id 
            WHERE WEEK(date) = WEEK("'.$currentDate.'") AND YEAR(date) = YEAR("'.$currentDate.'")
            ORDER BY transaction_id DESC';
        }
        if($filter == "thismonth") {
            $query = 'SELECT transaction_id, CONCAT(user.firstname, " ", user.lastname) AS fullname, order_id, date, total_price 
            FROM transaction 
            INNER JOIN user ON user.user_id = transaction.user_id 
            WHERE MONTH(date) = MONTH("'.$currentDate.'") AND YEAR(date) = YEAR("'.$currentDate.'")
            ORDER BY transaction_id DESC';
        }
        if($filter == "thisyear") {
            $query = 'SELECT transaction_id, CONCAT(user.firstname, " ", user.lastname) AS fullname, order_id, date, total_price 
            FROM transaction 
            INNER JOIN user ON user.user_id = transaction.user_id 
            WHERE YEAR(date) = YEAR("'.$currentDate.'")
            ORDER BY transaction_id DESC';
        }


        $stmt = $this->connect()->prepare($query);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($result);
    }


}
