<?php

require_once dirname(__FILE__) . '/php/classes/Account.php';
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';

$validate = new Validate();

$validate = new Validate();
if ($validate->is_logged_in("admin")) {
    header('Location: error.php');
}

$account = new Account();
/* deletes expired verification code */
$account->delete_code();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff | Snackwise</title>

    <!-- PAGE ICON -->
    <link rel="icon" href="img/penguin.png" type="image/icon type">

    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- BOOTSTRAP JS  -->


    <!-- FONT AWESOME -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <link rel="stylesheet" href="css/edit-user.css">
    <link rel="stylesheet" href="css/notification.css">

    <style>

        
        
    </style>


</head>

<body>


    <div class="parent-container">

        <div class="container p-3">

            <div class="row row-1">
                <div class="col d-flex user-table-header">
                        <a href="manage-order.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to Manage Orders</a>
                        <span class="page-title">Transaction History</span>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-2">
                <div class="filter-buttons-container">
                    <button type="button" class="btn btn-primary" onclick="new Order().display_completed_orders('alltime')">All</button>
                    <button type="button" class="btn btn-primary" onclick="new Order().display_completed_orders('thisweek')">This week</button>
                    <button type="button" class="btn btn-primary" onclick="new Order().display_completed_orders('thismonth')">This month</button>
                    <button type="button" class="btn btn-primary" onclick="new Order().display_completed_orders('thisyear')">This year</button>
                </div>
                <div class="">
                    <div class="sales-container">
                        <span>Total Sales: </span>
                        <span class="total-sales text-success" id="total_sales">000</span>
                    </div>
                    <div class="order-count">
                        <span>Total Transactions: </span>
                        <span id="total-transactions"></span>
                    </div>
                </div>
            </div>
            <div class="row row-3">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <span class="filter-txt">Filtered by: <span id="filtered-by">this week</span></span>
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Costumer Name</th>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Date of Order</th>
                                    <th scope="col">Total Paid</th>
                                </tr>
                            </thead>

                            <tbody id="table-body">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>


    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/Notification.js"></script>
    <script src="js/Order.js"></script>

    <script>
        new Order().display_completed_orders("thisweek");
    </script>

</body>

</html>