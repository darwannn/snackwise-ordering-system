<?php 
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';

$_SESSION['password'] = 1;
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/notification.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   
</head>

<body>

  <!-- bestseller items will be appended here -->
    <div class="bestseller_list" id="bestseller_list"></div>

    



  
</body>



<script src="js/Menu.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        let menu = new Menu();
        menu.display_bestseller();
    });
</script>

</html>