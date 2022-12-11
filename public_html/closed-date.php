<?php

require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';

$validate = new Validate();
if ($validate->is_logged_in("staff")) {
    header('Location: error.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- FONT AWESOME CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- FONT AWESOME JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <!-- DATE PICKER -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">


    </script>
    <link href="css/notification.css" rel="stylesheet">
    <link rel="stylesheet" href="css/close-date.css">
</head>

<body>
    <div class="toast_notif" id="toast_notif"></div>
    <!-- <form id="closed_date_form" method="POST">
        <div class="form-group mt-2">
            <label class="form-label" for="date">Date</label>
            <input type="date" class="form-control" name="date" id="date" />
            <span class="input_error" id="date_error"></span>
        </div>
        <button type="button" name="closed_date" id="closed_date" onclick="new Closed_Date().add_closed_date()">Add Date</button>
    </form> -->

    <!-- <div class="container my-5">
        <div class="card">
            <div class="card-header ">
                <a href="dashboard.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
                <h3 class="text-center">Order</h3>
            </div>
            <div class="card-body">
                <table>
                    <tr>
                        <td>Closed Date</td>
                    </tr>
                    <tbody class="closed_date_list" id="closed_date_list">
                    </tbody>

                </table>
            </div>
        </div>
    </div> -->

    <div class="parent-container">

        <div class="wrapper">
            
            <div class="close-date-header">
                <div class="back-link">
                    <a href="dashboard.php"><i class="fa-solid fa-arrow-left"></i> Go back to dashboard</a>
                </div>
                <div class="page-title">
                    <span>Closed Dates</span>
                </div>
            </div>
            <form class="close-date-form" id="closed_date_form" method="POST">
                <div class="form-group mt-2 .">
                    <!-- <label class="form-label" for="date">Date</label> -->
                    <input type="date" class="form-control" name="date" id="date" />
                    <span class="input_error" id="date_error"></span>
                </div>

                    <button type="button" name="closed_date" class="btn btn-success" id="closed_date" onclick="new Closed_Date().add_closed_date()">Add Date</button>
            </form>

            <div class="close-date-list">
                <div class="date-row">
                    <div class="date-container">
                        <span class="date">December 11, 2022</span>
                    </div>
                    <div class="del-btn">
                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                <div class="date-row">
                    <div class="date-container">
                        <span class="date">December 11, 2022</span>
                    </div>
                    <div class="del-btn">
                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                <div class="date-row">
                    <div class="date-container">
                        <span class="date">December 11, 2022</span>
                    </div>
                    <div class="del-btn">
                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                <div class="date-row">
                    <div class="date-container">
                        <span class="date">December 11, 2022</span>
                    </div>
                    <div class="del-btn">
                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                <div class="date-row">
                    <div class="date-container">
                        <span class="date">December 11, 2022</span>
                    </div>
                    <div class="del-btn">
                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            </div>

        </div>

    </div>




</body>
<script src="js/Notification.js"></script>
<script src="js/Closed_Date.js"></script>
<script>
    new Closed_Date().display_closed_date();
</script>

</html>