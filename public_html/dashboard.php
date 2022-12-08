<?php

require_once dirname(__FILE__) . '/php/classes/Account.php';
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';

$validate = new Validate();

$validate = new Validate();
if ($validate->is_logged_in("staff")) {
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
    <title>Dashboard | Snackwise</title>

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

    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/notification.css">
</head>

<body>

    <div class="back-pattern"></div>

    <div class="wrapper">
        <div class="side-bar">
            <div class="brand-title-container">
                <a href="index.php" class="brand-title">
                    <span class="red">SNACK</span><span class="yellow">WISE</span>
                </a>
            </div>
            <div class="user-profile-container">
                <div class="user-image">
                    <img src="https://res.cloudinary.com/dhzn9musm/image/upload/<?php echo $_SESSION['current_image'] ?>" alt="">
                </div>
                <div class="user-info">
                    <a href="profile.php"><span class="welcome-txt">Welcome,<br><span class="first-name"><?php echo $_SESSION['current_firstname'] ?></span></span></a>
                </div>
            </div>
            <div class="navigation-container">
                <ul class="navigation">
                    <li class="nav-item" id="active-nav">
                        <a href="dashboard.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="edit-order.php"><i class="fa-solid fa-receipt"></i> Edit Orders</a>
                    </li>
                    <li class="nav-item">
                        <a href="edit-menu.php"><i class="fa-solid fa-burger"></i> Edit Menu</a>
                    </li>
                    <!-- DI PA SURE TO -->
                    <!-- <li class="nav-item">
                            <a href="edit-users.php"><i class="fa-solid fa-user"></i> Edit Users</a>
                        </li> -->
                </ul>
            </div>
            <div class="bottom-btn">
                <a href="account/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
        </div>
        <div class="content">
            <div class="content-header">
                <h1>Dashboard</h1>
            </div>
            <div class="cards-row">
                <div class="dashb-card">
                    <div class="card-info">
                        <div class="main"> 
                            <span class="card-title">Completed Orders:</span>
                            <span class="total-number text-success" id="total-orders">00</span>
                        </div>
                        <span class="additional-note">Cancelled order not included</span>
                    </div>
                    <div class="bottom-line line-green"></div>
                </div>

                <div class="dashb-card">
                    <div class="card-info">
                        <div class="main"> 
                            <span class="card-title">Pending Orders:</span>
                            <span class="total-number text-warning" id="total-pending">00</span>
                        </div>
                        <div class="additional-notes"></div>
                    </div>
                    <div class="bottom-line line-yellow"></div>
                </div>       

                <div class="dashb-card">
                    <div class="card-info">
                        <div class="main"> 
                            <span class="card-title">Cancelled Orders:</span>
                            <span class="total-number text-danger" id="total-cancelled">00</span>
                        </div>
                        <div class="additional-notes"></div>
                    </div>
                    <div class="bottom-line line-red"></div>
                </div>
                
            </div>
           
            <span class="row-header">Users:</span>
            <div class="cards-row">
                <div class="dashb-card">
                    <div class="card-info">
                        <div class="main"> 
                            <span class="card-title">Registered Users</span>
                            <span class="sub-number" id="total-users">00</span>
                        </div>
                        <span class="additional-note"></span>
                    </div>
                </div>

                <div class="dashb-card">
                    <div class="card-info">
                        <div class="main"> 
                            <span class="card-title">Staffs:</span>
                            <span class="sub-number" id="total-staffs">00</span>
                        </div>
                        <div class="additional-notes"></div>
                    </div>
                </div>       
            </div>

            <span class="row-header">Menu:</span>
            <div class="cards-row">
                <div class="dashb-card">
                    <div class="card-info">
                        <div class="main"> 
                            <span class="card-title">Menu Items:</span>
                            <span class="sub-number" id="total-items">00</span>
                        </div>
                        <span class="additional-note"></span>
                    </div>
                </div>

                <div class="dashb-card">
                    <div class="card-info">
                        <div class="main"> 
                            <span class="card-title">Available Items:</span>
                            <span class="sub-number" id="total-available">00</span>
                        </div>
                        <div class="additional-notes"></div>
                    </div>
                </div>       
            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>