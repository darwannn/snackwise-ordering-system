<?php
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';
require_once dirname(__FILE__) . '/php/classes/Closed_Date.php';

$validate = new Validate();
$closed_date = new Closed_Date();

$closed_date->delete_past_closed_date();
$db = new DbConnection();
$conn = $db->connect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Snackwise</title>

    <!-- PAGE ICON -->
    <link rel="icon" href="img/penguin.png" type="image/icon type">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FONTAWESOME -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <!-- MY CSS -->
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/notification.css">

    <style>
        input[type="radio"] {

            display: none;
        }

        .item-quantity {
            border: none;
        }

        input[type="number"]:focus {
            border: none;
            outline: none;
        }
        .checkout-input-date, .checkout-input-time {

            background-color: rgb(242, 241, 249);
            outline: 0px;
            border: 0px;
            border-radius: 5px;

        }
        .checkout-input-date:focus, .checkout-input-time:focus {
            box-shadow: none;
            border: 1px solid black;
            background-color: rgb(242, 241, 249);
        }

    </style>
</head>

<body>



    <!-- SIDEBAR -->
    <div class="sidecart  flex-column h-100 top-0 " id="sidecart">

        <div class="mx-3 mt-3">
            <p class="cart-label bold mb-0"> SHOPPING CART <i class=" sidecart-close fa-solid fa-xmark float-end" onclick="new Cart().close_cart();"></i></p>
            <hr class="w-100 my-2">
        </div>
        <div class="text-end mt-2" id="empty_cart"><button class="text-end mx-3 btn p-0" style="font-size:12px;" onclick="new Cart().delete_cart('','empty');">Empty Cart</button></div>
        <!-- customers added to cart items will be appended here -->
        <div class="cart_list cart_list flex-grow-1 mx-3" id="cart_list" style="margin-top: -5px;">

        </div>

        <div class="cart_price_information  flex-column mx-3 mb-3" id="cart_summary">
            <hr class="w-100 my-2">
            <div class=" bold">SUBTOTAL:</div>
            <div class="text-end bolder" id="cart_total_price">164.00 ₱</div>

            <button type="button" class="btn btn-checkout w-100 my-2" id="verify_order">CHECKOUT</button>

        </div>
    </div>

    <!-- SIDEBAR -->

    <div class="parent-container">
        <nav class="navbar navbar-light bg-light navbar-expand-md">
            <div class="container">
                <a href="index.php" class="navbar-brand">
                    <!-- <img src="./img/penguin.png" alt="Penguin Logo" height="58" width="52"> -->
                    <span class="red">SNACK</span><span class="yellow">WISE</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto nav-list">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="menu.php" class="nav-link" id="active">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a href="contactus.php" class="nav-link">Contact Us</a>
                        </li>
                    </ul>
                    <?php
                    if ($validate->is_logged_in("customer")) {
                    ?>
                        <form action="#" class="form-inline sign-btns">
                            <a name="log-in-btn" class="btn" href="account/login.php">Login</a>
                            <a name="sign-up-btn" id="" class="btn btn-primary" href="account/register.php" role="button">Sign
                                Up</a>
                        </form>
                    <?php
                    } else {
                        /* dito lalagay yung logout*/
                    ?>

                        <div class="user-notifications-container">
                            <button class="notification-button">
                                <i class="fa-solid fa-bell"></i>
                                <!-- dito lalabas yung  unread notifcount -->
                                <div class="notification_count" id="notification_count"></div>
                            </button>

                            <div class="notifications-panel">
                                <div class="panel-header-container">
                                    <span class="panel-header">Notifications</span>
                                </div>


                                <div class="notifications-container" id="notification_list"></div>
                            </div>
                        </div>

                        <div class="user-dropdown-container">
                            <button class="user-button">
                                <i class="fa-solid fa-circle-user"></i>
                            </button>
                            <div class="drop-menu">

                                <div class="user-header" onclick="window.location.href = 'profile.php'">
                                    <div>
                                        <img src="https://res.cloudinary.com/dhzn9musm/image/upload/<?php echo $_SESSION['current_image'] ?>" alt="">
                                    </div>
                                    <div class="name-container">
                                        <span class="full-name"><?php echo $_SESSION['current_firstname'] . " " . $_SESSION['current_lastname']; ?></span>
                                    </div>
                                </div>
                                <div class="user-menu-container">
                                    <ul class="user-menu-list">
                                        <li class="user-menu-item">
                                            <a href="order.php"><i class="fa-solid fa-receipt"></i> My Orders</a>
                                        </li>
                                        <li class="user-menu-item">
                                            <a href="change-password.php"><i class="fa-solid fa-key"></i> Change Password</a>
                                        </li>

                                        <?php
                                        /* lalabas sa staff at admin */
                                        if (!$validate->is_logged_in("staff")) {
                                        ?>
                                            <li class="user-menu-item">
                                                <a href="edit-order.php" class=""><i class="fa-solid fa-pen-to-square"></i> Edit Order</a>
                                            </li>
                                        <?php
                                        }
                                        /* pang admin lang */
                                        if (!$validate->is_logged_in("admin")) {
                                        ?>
                                            <li class="user-menu-item">
                                                <a href="dashboard.php" class=""><i class="fa-solid fa-gear"></i> SW Dashboard</a>
                                            </li>
                                        <?php
                                        }
                                        ?>

                                    </ul>
                                </div>
                                <div class="logout-container">
                                    <a href="account/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                                </div>

                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </nav>

       <!--  <div class="modal-backdrop fade show" id="modal_backdrop"></div> -->


        <section class="top-header">
            <div class="container">
                <h1 class="text-center">MENU</h1>
            </div>
        </section>


        <section class="sorting">
            <div class="container">
                <div class="sort-btn-container">
                    <ul class="sorter-list">
                        <!-- display the items from the category table as radio button -->
                        <?php
                        $query  = $conn->prepare("SELECT * FROM category");
                        $result  =  $query->execute();
                        if ($query->rowCount() > 0) {
                            while ($row = $query->fetch(PDO::FETCH_BOTH)) {
                        ?>
                                <li class="sort-item">
                                    <label>
                                        <input type="radio" name="category" value="<?php echo $row['category_id'] ?>"><?php echo $row['name'] ?>
                                    </label>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="cart">
                    <!-- customers cart items count be appended here -->
                    <button type="button" class="btn" onclick="new Cart().open_cart();">View Cart<i class="fa-solid fa-cart-shopping"></i><span class="cart-count" id="cart_count"></span></button>
                </div>
            </div>
        </section>

        <section class="menu">
            <div class="container">
                <!-- items from the menu table will be appended here -->
                <div class="row menu-collection" id="menu_list">

                </div>
            </div>
        </section>

        <section class="how-to-container">
            <div class="container">
                <div class="row">
                    <div class="col how-to-header">
                        <h2 class="text-center">How It Works?</h2>
                    </div>
                </div>
                <div class="row instructions-container">
                    <div class="col col-md-3 instruction">
                        <div class="instruction-illustration-container">
                            <object data="img/instruction-icons/create-account-icon.svg"></object>
                        </div>
                        <div class="instruction-caption">
                            <span class="instruction-name">Create
                                Account</span>
                            <span class="instruction-details">Before you can order,
                                you must create an
                                account first.</span>
                        </div>
                    </div>

                    <div class="col col-md-3 instruction">
                        <div class="instruction-illustration-container">
                            <object data="img/instruction-icons/order-icon.svg"></object>
                        </div>
                        <div class="instruction-caption">
                            <span class="instruction-name">Order</span>
                            <span class="instruction-details">
                                Browse through our menu, and place your order
                            </span>
                        </div>
                    </div>

                    <div class="col col-md-3 instruction">
                        <div class="instruction-illustration-container">
                            <object data="img/instruction-icons/meal-preparation-icon.svg"></object>
                        </div>
                        <div class="instruction-caption">
                            <span class="instruction-name">Meal Preparation</span>
                            <span class="instruction-details">
                                It may took a while when we prepare your order. Chill out it will be worth it.
                            </span>
                        </div>
                    </div>

                    <div class="col col-md-3 instruction">
                        <div class="instruction-illustration-container">
                            <object data="img/instruction-icons/pick-up-icon.svg"></object>
                        </div>
                        <div class="instruction-caption">
                            <span class="instruction-name">Pick Up</span>
                            <span class="instruction-details">
                                You will get notified through call when your order is ready for pick-up.
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <footer>
            <div class=footer-header>
                <div class="left-line line">
                    <hr>
                </div>
                <div class="snack-logo-container">
                    <img src="img/penguin.png" alt="penguin.png" width="116px" height="104px">
                </div>
                <div class="right-line line">
                    <hr>
                </div>
            </div>
            <div class="container">
                <div class="row footer-details">
                    <div class="col-12 col-md-3 address-col">
                        <span class="detail-title">
                            ADDRESS
                        </span>
                        <span class="details">
                            Zone 3, Stall 1 Sto. Rosario Hagonoy Bulacan
                        </span>
                    </div>

                    <div class="col-12 col-md-3 contact-col">
                        <span class="detail-title">
                            CALL US
                        </span>
                        <span class="details">
                            0970 860 1556
                        </span>
                    </div>

                    <div class="col-12 col-md-3 hours-col">
                        <span class="detail-title">
                            OPENING HOURS
                        </span>
                        <span class="details">
                            Mon-Saturday: 8:00AM - 6:00PM <br>
                            Sunday: 10AM - 4PM
                        </span>
                    </div>

                    <div class="col-12 col-md-3 newsletter-col">
                        <span class="detail-title">
                            NEWSLETTER
                        </span>
                        <span class="details">
                            Subscribe to our daily newsletter for all latest updates.
                        </span>

                        <form action="#" class="newsletter-form" id="newsletter_form">
                        <input type="text" name="email" id="newsletter_email" placeholder="Email Address">
                        <button type="button" id="newsletter" onclick="new Notification().newsletter()">SUBSCRIBE</button>
                        </form>
                        <span id="newsletter_email_error"></span>

                    </div>

                </div>

            </div>

            <div class="lower-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-6 soc-med">
                            <span>Like us on: </span>
                            <span>
                                <a href="https://www.facebook.com/SnackWisePriceForEveryJuan" class="social-media-icon">
                                    <i class="fa-brands fa-square-facebook"></i>
                                </a>
                            </span>
                        </div>
                        <div class="col-6">
                            <span class="right">Copyright © 2022 Snackwise. All Rights Reserved.</span>
                        </div>
                    </div>
                </div>
            </div>

        </footer>

    </div>


    <!-- order modal -->
    <div class="details-modal" id="order-details-modal">
     
     </div>
     <input type="text" id="cartlist" name="cartlist" placeholder="cartlist">
    

    <!-- toast_notif notification will be appended here -->
    <div class="toast_notif" id="toast_notif"></div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="js/Menu.js"></script>
    <script src="js/Notification.js"></script>
    <script src="js/Cart.js"></script>

    <script>
        new Notification().notification();
        /* DROPDOWN */

        const dropMenu = document.querySelector('.drop-menu');
        const dropBtn = document.querySelector('.user-button');
        let dropOpen = false;

        if (dropBtn) {
            dropBtn.addEventListener("click", () => {
                if (!dropOpen) {
                    dropMenu.style.display = "block";
                    dropOpen = true;
                } else {
                    dropOpen = false;
                    dropMenu.style.display = "none";

                }

            })
        }
     
        /* END OF DROPDOWN */
        new Menu().menu();
        /* --------------------cart */
        <?php if (!($validate->is_logged_in("customer"))) {
        ?>
            new Cart().cart();
        <?php
        } ?>

        <?php
        /* adds selected bestseller item to cart */
        if (isset($_GET['b'])) {
        ?>
            new Cart().add_to_cart(<?php echo $_GET['b'] ?>);
            /* removes the URL parameter after the item was added to the cart */
            let url = document.location.href;
            window.history.pushState({}, "", url.split("?")[0]);

        <?php
        }
        ?>

        /* displays newsletter subscription success message */
        <?php
        if (isset($_SESSION['activate_success'])) {
        ?>
            new Notification().create_notification('<?php echo $_SESSION['activate_success']; ?>', "success");
        <?php
            unset($_SESSION["activate_success"]);
        } ?>
    </script>
</body>

</html>