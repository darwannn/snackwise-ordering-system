<?php


require_once dirname(__FILE__) . '/php/controller/c_order.php';
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';

$validate = new Validate();
if ($validate->is_logged_in("staff")) {
    header('Location: error.php');
}
$db = new DbConnection();
$conn = $db->connect();
$order = new Order();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Snackwise</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- PAGE ICON -->
    <link rel="icon" href="img/penguin.png" type="image/icon type">

    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>


    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="css/order.css">
    <link rel="stylesheet" href="css/notification.css">



    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery-bundle.css'>

    <link rel="stylesheet" type="text/css" href="css/table.css" />
    <script src="js/Table.js" type="text/javascript"></script>

    <!-- DATE PICKER -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        body {
            background-image: url(img/Background-Pattern-BW.jpg);
        }

        .card-header {
            position: relative;
        }

        .card-header .back-btn {
            position: absolute;
            float: left;
            height: 100%;
            margin-top: 10px;
            font-size: 16px;
            text-decoration: none;
            color: #595959;
            transition: all .1s ease;
        }

        .card-header .back-btn:hover {
            color: #2f2f2f;
        }

        td:nth-child(4) {
            max-width: 200px !important;
            white-space: normal !important;
        }

        td:nth-child(2) {
            white-space: normal !important;
            width: 150px !important;
        }

        td:nth-child(7) {
            white-space: normal !important;
            width: 150px !important;
        }

        td:nth-child(5) {
            white-space: normal !important;
            width: 120px !important;
        }

        td:nth-child(6) {
            white-space: normal !important;
            width: 150px !important;
        }

        .dt-table th.dt-sorter::before,
        .dt-table th.dt-sorter::after {
            content: "";
            height: 0;
            width: 0;
            position: absolute;
            right: 5px;
            margin-top: 5px;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            opacity: 0.3;
        }

        .dt-table th:nth-child(1).dt-sorter::before,
        .dt-table th:nth-child(1).dt-sorter::after {
            right: 10px;
        }

        .dt-table th:nth-child(2).dt-sorter::before,
        .dt-table th:nth-child(2).dt-sorter::after {
            right: 9px;
        }

        /*  .dt-table th:nth-child(3).dt-sorter::before,
        .dt-table th:nth-child(3).dt-sorter::after {
            right: 20px;
        } */
        .dt-table th:nth-child(5).dt-sorter::before,
        .dt-table th:nth-child(5).dt-sorter::after {
            right: 40px;
        }

        .dt-table th:nth-child(6).dt-sorter::before,
        .dt-table th:nth-child(6).dt-sorter::after {
            right: 20px;
        }

        .dt-table th:nth-child(7).dt-sorter::before,
        .dt-table th:nth-child(7).dt-sorter::after {
            right: 21px;
        }

        .dt-table th:nth-child(3).dt-sorter::before,
        .dt-table th:nth-child(3).dt-sorter::after,
        .dt-table th:nth-child(4).dt-sorter::before,
        .dt-table th:nth-child(4).dt-sorter::after,

        .dt-table th:nth-child(8).dt-sorter::before,
        .dt-table th:nth-child(8).dt-sorter::after {
            display: none;
        }

        th:nth-child(4),
        th:nth-child(3),

        th:nth-child(8) {
            pointer-events: none;
        }

        .input_error {
            position: relative;
            /*             top: -3px; */
            font-size: 14px;
            color: red;
        }

        table {
            font-size: 1.6em;
        }

        .input-reason {
            margin-top: 2px;
            background-color: rgb(242, 241, 249);
            outline: 0px;
            border: 0px;

        }

        .input-reason:focus {
            box-shadow: none;
            border: 1px solid black;
            background-color: rgb(242, 241, 249);
        }

        .dt-info,
        .dt-pagination a,
        .dt-selector,
        .dt-input {
            font-size: 1.4em;
        }

        .btn-claim {
            background-color: #198754 !important;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545 !important;
            color: white;
        }
    </style>
    <link rel="stylesheet" href="css/notification.css">
    <link rel="stylesheet" href="css/manage-order.css">
</head>

<body>

    <!-- toast_notif notification will be appended here -->
    <div class="toast_notif" id="toast_notif"></div>

    <!-- modal to claim order -->
    <div class="details-modal" id="claim-details-modal">
    </div>

    <input type="hidden" value="" id="to_claim_order_id">
    <input type="hidden" value="" id="to_claim_type">



    <div class="container my-5">
        <div class="counter-cards">
            <div class="row">
                <div class="col-md-4">
                    <div class="counter-con">
                        <span class="counter-label">Total Order:</span>
                        <div class="counter" id="total_order_count">#</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-con">
                        <span class="counter-label">Completed :</span>
                        <div class="counter" id="total_completed_count">#</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-con">
                        <span class="counter-label">Cancelled:</span>
                        <div class="counter" id="total_cancelled_count">#</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="counter-con">
                        <span class="counter-label">Unclaimed (to pickup):</span>
                        <div class="counter" id="total_unclaimed_count">#</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-con">
                        <span class="counter-label">Preparing:</span>
                        <div class="counter" id="total_preparing_count">#</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-con">
                        <span class="counter-label">Placed:</span>
                        <div class="counter" id="total_placed_count">#</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <a href="dashboard.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
                <h4 class="text-center">Manage Order</h4>
            </div>
            <div class="card-body">

                <!-- QR scanner -->
                <button id="toggle_camera" onclick="new Order().toggle_camera();" class="btn btn-toggle btn-success w-100"><i class="fa-solid fa-camera"></i></button>
                <video class="w-100" src="" id="preview"></video>

                <table id="order_table" class="table table-sm ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Contact No.</th>
                            <th>Order</th>
                            <!--  <th>Price</th>
                            <th>Quantity</th> -->
                            <th>Pickup Date</th>
                            <th>Pickup Time</th>
                            <th>Order Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $order->fetch_five(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- modal to edit an order -->
    <div id="order_modal">
        <form method="post" id="order_form">
            <input type="hidden" name="order_id" id="order_id" />
            <input type="date" class="form-control" name="date" id="date" />
            <input type="time" class="form-control" name="time" id="time" />

            <select name="status" id="status" class="form-select">
                <option value="Placed">Placed</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Preparing">Preparing</option>
                <option value="Ready">Ready</option>
            </select>
        </form>
    </div>

    <!-- modal to delete an order -->

    <div class="details-modal" id="delete-details-modal">


    </div>
    <input type="text" name="order_id" id="del_notif_order_id" />
    <input type="text" name="user_id" id="del_notif_user_id" />
    <!--     <div class="modal-backdrop fade show" id="modal_backdrop"></div> -->



    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script type="text/javascript" src="js/instascan.min.js"></script>
    <script type="text/javascript" src="js/Order.js"></script>
    <script src="js/Notification.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


    <script>
        /* instantiate JSTable class */
        let table = new JSTable("#order_table", {
            serverSide: true,
            deferLoading: <?php echo $order->count_all_data(); ?>,
            ajax: "php/controller/f_order.php"
        });

        order = new Order(table);
        order.staff_order();
        order.total_order_count();

        <?php

        /* open the details of selected notification */
        if (isset($_GET['o'])) {
        ?>
            new Order().order_fetch_info(`<?php echo $_GET['o'] ?>, 'manual'`);
            let url = document.location.href;
            window.history.pushState({}, "", url.split("?")[0]);
        <?php
        }
        ?>
    </script>
</body>

</html>