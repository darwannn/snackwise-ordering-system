<?php
session_start();

require_once dirname(__FILE__) . "/DbConnection.php";
require_once dirname(__FILE__) .'/../../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

/* $error = array(); */

$email = "";
$code = "";
$username = "";



class Menu extends DbConnection
{
	public $output = array();


	public function Image($image, $name) {
		Configuration::instance([
            'cloud' => [
                'cloud_name' => 'dhzn9musm',
                'api_key' => '364195656183668',
                'api_secret' => 'djFdPLL9D2O2lxNxApJNBxVY1iY'
            ],

            'url' => [
                'secure' => true
            ]
        ]);

       return $data =  (new UploadApi())->upload(
            $image,
            [
                'folder' => 'SL Visuals/',
                'public_id' => $name,
                'overwrite' => true,
            ],
        );
	}
	public function add($menu_id, $name, $description, $category, $discount, $price, $date, $availability, $image)
	{


		$data = $this->Image($image, $name);
        $image_link = "v" . $data['version'] . "/" . $data['public_id'];
        

		$statement = $this->connect()->prepare("
        INSERT INTO menu 
        (name, description, category, discount, price, date, availability, image) 
        VALUES (:name, :description, :category, :discount, :price, :date, :availability, :image)");
		$result = $statement->execute([
			':name' => $name,
			':description' => $description,
			':category' => $category,
			':discount' => $discount,
			':price' => $price,
			':date' => $date,
			':availability' => $availability,
			':image' => $image_link
		]);
		if ($result) {
			$output['success'] = '<div class="alert alert-success">New Data Added</div>';

			echo json_encode($output);
		}
	}
	public function edit($menu_id, $name, $description, $category, $discount, $price, $date, $availability, $image)
	{

		if ($_POST['action_menu'] == 'Update') {
			$statement = $this->connect()->prepare("UPDATE menu 
            SET name = :name, description = :description, category = :category, discount = :discount, price = :price, date = :date, availability = :availability, image = :image WHERE menu_id = :menu_id
            ");
			$result = $statement->execute([
				':name' => $name,
				':description' => $description,
				':category' => $category,
				':discount' => $discount,
				':price' => $price,
				':date' => $date,
				':availability' => $availability,
				':image' => $image,
				':menu_id' => $menu_id
			]);
			if ($result)
				if ($result) {
					$output['success'] = '<div class="alert alert-success">' . $menu_id . 'Data Updated</div>';
				}
			echo json_encode($output);
		}
	}
	public function delete($id)
	{

		if ($this->connect()->query("
		DELETE FROM menu 
		WHERE menu_id = '" . $id . "'
		")) {
			$output['success'] = '<div class="alert alert-success">Data Deleted</div>';

			echo json_encode($output);
		}
	}

	public function fetch()
	{
		$query = "
		SELECT * FROM menu 
		WHERE menu_id = '" . $_POST["id"] . "'
		";

		$result = $this->connect()->query($query);

		$data = array();

		foreach ($result as $row) {


			$data['menu_id'] = $row['menu_id'];
			$data['name'] = $row['name'];
			$data['description'] = $row['description'];
			$data['category'] = $row['category'];
			$data['discount'] = $row['discount'];
			$data['price'] = $row['price'];
			$data['date'] = $row['date'];
			$data['availability'] = $row['availability'];
			$data['image'] = $row['image'];
		}

		echo json_encode($data);
	}


	public function fetch_top_five_data()
	{
		$query = "
	SELECT * FROM menu 
	ORDER BY menu_id DESC 
	LIMIT 5";

		$result = $this->connect()->query($query);

		$output = '';
	/* 	<td>' . $row["image"] . '</td> */
		foreach ($result as $row) {
			$output .= '
		
		<tr>

		<td>' . $row["menu_id"] . '</td>
		<td>' . $row["name"] . '</td>
		<td>' . $row["description"] . '</td>
		<td>' . $row["category"] . '</td>
		<td>' . $row["price"] . '</td>
		<td>' . $row["date"] . '</td>
		<td>' . $row["availability"] . '</td>
	
		<td> <img src= "https://res.cloudinary.com/dhzn9musm/image/upload/'. $row["image"] .'" width="100px" height="100px"></td>
			<td><button type="button" onclick="fetch_data(' . $row["menu_id"] . ')" class="">Edit</button>&nbsp;<button type="button" class="" onclick="delete_data(' . $row["menu_id"] . ')">Delete</button></td>
		</tr>
		';
		}
		return $output;
	}

	public function count_all_data()
	{
		$query = "SELECT * FROM menu";

		$statement = $this->connect()->prepare($query);

		$statement->execute();

		return $statement->rowCount();
	}

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



		$column = array("menu_id", "name", "description", "category", "price", "date", "availability", "image");

		$query = "SELECT * FROM menu ";

		$query .= '
	WHERE menu_id LIKE "%' . $search . '%" 
	OR name LIKE "%' . $search . '%" 
	OR description LIKE "%' . $search . '%" 
	OR category LIKE "%' . $search . '%" 
	OR price LIKE "%' . $search . '%" 
	OR date LIKE "%' . $search . '%" 
	OR availability LIKE "%' . $search . '%" 
	OR image LIKE "%' . $search . '%" 
		';


		if ($sortColumnIndex != '') {
			$query .= 'ORDER BY ' . $column[$sortColumnIndex] . ' ' . $sortDirection . ' ';
		} else {
			$query .= 'ORDER BY menu_id DESC ';
		}

		$query1 = '';

		if ($length != -1) {
			$query1 = 'LIMIT ' . $start . ', ' . $length;
		}

		$statement = $this->connect()->prepare($query);

		$statement->execute();

		$number_filter_row = $statement->rowCount();

		$result = $this->connect()->query($query . $query1);

		$data = array();

		foreach ($result as $row) {
			$sub_array = array();

			$sub_array[] = $row['menu_id'];
			$sub_array[] = $row['name'];
			$sub_array[] = $row['description'];
			$sub_array[] = $row['category'];
			$sub_array[] = $row['price'];
			$sub_array[] = $row['date'];
			$sub_array[] = $row['availability'];
			$sub_array[] = '<td> <img src= "https://res.cloudinary.com/dhzn9musm/image/upload/'. $row["image"] .'" width="100px" height="100px"></td>';
			$sub_array[] = '<button type="button" onclick="fetch_data(' . $row["menu_id"] . ')" class="">Edit</button>&nbsp;<button type="button" class="" onclick="delete_data(' . $row["menu_id"] . ')">Delete</button>';
			$data[] = $sub_array;
		}



		$output = array(
			"recordsTotal"		=>	$this->count_all_data(),
			"recordsFiltered"	=>	$number_filter_row,
			"data"				=>	$data
		);

		echo json_encode($output);
	}


	public function disply_menuuuuu()
	{

		$output = array();
		/* $output['success'] = 'success';    
	echo json_encode($output); */

		$query  = $this->connect()->prepare("SELECT menu_id, name, description,category,discount,price, date, availability,image FROM menu ");

		$query->execute();
		if ($query->rowCount() > 0) {
			$fetch = $query->fetch(PDO::FETCH_ASSOC);
			/* $fetch_menu_id = $fetch['menu_id'];
			$fetch_name = $fetch['name'];
			$fetch_description = $fetch['description'];
			$fetch_category = $fetch['category'];
			$fetch_discount = $fetch['discount'];
			$fetch_price = $fetch['price'];
			$fetch_date = $fetch['date'];
			$fetch_availability = $fetch['availability'];
			$fetch_image = $fetch['image']; */
			   
			$output['menu_id'] = $fetch['menu_id'];
			$output['name'] = $fetch['name'];
			$output['description'] = $fetch['description'];
			$output['category'] = $fetch['category'];
			$output['discount'] = $fetch['discount'];
			$output['price'] = $fetch['price'];
			$output['date'] = $fetch['date'];
			$output['availability'] = $fetch['availability'];
			$output['image'] = $fetch['image'];

			$output['success'] = 'success';
			echo json_encode($output);
		} else {
			$output['error'] = 'Failed';    
            echo json_encode($output);
		}
	}

	public function display_menu () {
	/* 	$startGET = filter_input(INPUT_GET, "start", FILTER_SANITIZE_NUMBER_INT);
		$start = $startGET ? intval($startGET) : 0;
		$lengthGET = filter_input(INPUT_GET, "length", FILTER_SANITIZE_NUMBER_INT);
		$length = $lengthGET ? intval($lengthGET) : 10;
		$searchQuery = filter_input(INPUT_GET, "searchQuery", FILTER_SANITIZE_STRING);
		$search = empty($searchQuery) || $searchQuery === "null" ? "" : $searchQuery;
		$sortColumnIndex = filter_input(INPUT_GET, "sortColumn", FILTER_SANITIZE_NUMBER_INT);
		$sortDirection = filter_input(INPUT_GET, "sortDirection", FILTER_SANITIZE_STRING); */



		$column = array("menu_id", "name", "description", "category", "price", "date", "availability", "image");

		$query = "SELECT * FROM menu ";
/* 
		$query .= '
	WHERE menu_id LIKE "%' . $search . '%" 
	OR name LIKE "%' . $search . '%" 
	OR description LIKE "%' . $search . '%" 
	OR category LIKE "%' . $search . '%" 
	OR price LIKE "%' . $search . '%" 
	OR date LIKE "%' . $search . '%" 
	OR availability LIKE "%' . $search . '%" 
	OR image LIKE "%' . $search . '%" 
		';


		if ($sortColumnIndex != '') {
			$query .= 'ORDER BY ' . $column[$sortColumnIndex] . ' ' . $sortDirection . ' ';
		} else {
			$query .= 'ORDER BY menu_id DESC ';
		} */

		$query1 = '';
/* 
		if ($length != -1) {
			$query1 = 'LIMIT ' . $start . ', ' . $length;
		}
 */
		$statement = $this->connect()->prepare($query);

		$statement->execute();

		$number_filter_row = $statement->rowCount();

		$result = $this->connect()->query($query . $query1);

		$data = array();

		foreach ($result as $row) {
			$sub_array = array();

			$sub_array['menu_id'] = $row['menu_id'];
			$sub_array['name'] = $row['name'];
			$sub_array['description'] = $row['description'];
			$sub_array['category'] = $row['category'];
			$sub_array['price'] = $row['price'];
			$sub_array['date'] = $row['date'];
			$sub_array['availability'] = $row['availability'];
			$sub_array['image'] = $row['image'];
			$data[] = $sub_array;
		}



		$output = array(
			
			"data"				=>	$data
		);
		/* $output['success'] = 'dsdasd'; */

		echo json_encode($output);
	}
}
