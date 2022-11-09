<?php $user_id = 1 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Snackwise</title>

    <!-- PAGE ICON -->
    <link rel="icon" href="img/penguin.png" type="image/icon type">


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
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidecart  flex-column h-100 top-0  " id="sidecart">

        <div class="mx-3 mt-3">
            <p class="cart-label bold mb-0"> SHOPPING CART <i class=" sidecart-close fa-solid fa-xmark float-end" onclick="close_cart();"></i></p>
            <hr class="w-100 my-2">
        </div>

        <div class="cart_list flex-grow-1 mx-3">


            <div class="cart_item d-flex align-items-center my-3 mx-1 p-1 ">
                <i class="item-remove fa-solid fa-xmark"></i>
                <img class=" cart-image mx-2 " src="img/menu-imgs/A.jpg" alt="">
                <div class="d-flex flex-column">
                    <div class="item-name">Combo A</div>
                    <div class=""><span class="item-quantity">1x</span><span class="ms-3 bolder item-price">75.00 ₱</span></div>
                </div>
            </div>


            <div class="cart_item d-flex align-items-center my-3 mx-1 p-1 ">
                <i class="item-remove fa-solid fa-xmark"></i>
                <img class=" cart-image mx-2 " src="img/menu-imgs/B.jpg" alt="Combo B">
                <div class="d-flex flex-column">
                    <div class="item-name">Combo B</div>
                    <div class=""><span class="item-quantity">1x</span><span class="ms-3 bolder item-price">89.00 ₱</span></div>
                </div>
            </div>





        </div>

        <div class="cart_price_information d-flex flex-column mx-3 mb-3">
            <hr class="w-100 my-2">
            <div class=" bold">SUBTOTAL:</div>
            <div class="text-end bolder">164.00 ₱</div>

            <button type="button" class="btn btn-checkout w-100 my-2">CHECKOUT</button>
            <div type="button" class="btn btn-clear w-100">Clear Cart</div>
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
                            <a href="aboutus.php" class="nav-link">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="contactus.php" class="nav-link">Contact Us</a>
                        </li>
                    </ul>
                    <form action="#" class="form-inline sign-btns">
                        <!-- 
                            NOTE: IF THE USER IS SIGNED IN, The sign-up button should be replaced by profile btn.
                        -->
                        <!-- TODO: Insert user profile and cart button here.  -->
                        <a name="log-in-btn" class="btn" href="account/login.php">Login</a>
                        <a name="sign-up-btn" id="" class="btn btn-primary" href="./account/register.php" role="button">Sign Up</a>
                    </form>
                </div>
            </div>
        </nav>

        <section class="top-header">
            <div class="container">
                <h1 class="text-center">MENU</h1>
            </div>
        </section>

        <section class="sorting">
            <div class="container">
                <div class="sort-btn-container">
                    <ul class="sorter-list">
                        <li class="sort-item" id="active-sort">
                            <a href="#" target="_blank" rel="noopener noreferrer">
                                Combo
                            </a>
                        </li>
                        <li class="sort-item">
                            <a href="#" target="_blank" rel="noopener noreferrer">
                                Burger
                            </a>
                        </li>
                        <li class="sort-item">
                            <a href="#" target="_blank" rel="noopener noreferrer">
                                Fries
                            </a>
                        </li>
                        <li class="sort-item">
                            <a href="#" target="_blank" rel="noopener noreferrer">
                                Drinks
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="cart">
                    <button type="button" class="btn" onclick="open_cart();">View Cart<i class="fa-solid fa-cart-shopping"></i><span class="cart-count">(02)</span></button>
                </div>
            </div>
        </section>

        <section class="menu">
            <div class="container">
                <div class="row menu-collection">

                    <!-- MENU ITEM START HERE -->

                    <div class="col-12 col-md-6">
                        <div class="menu-item">
                            <div class="product-img">
                                <img src="img/menu-imgs/A.jpg" alt="food-img" srcset="">
                            </div>
                            <div class="product-details-wrapper">
                                <div class="product-details">
                                    <span class="product-title">Combo A</span>
                                    <span class="product-description">Includes: Regular Burger, Regular Fries, Blue Lemonade</span>
                                    <span class="product-price">55.00PHP</span>
                                </div>
                                <div class="interact">
                                    <button class="btn" onclick="open_cart();">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="menu-item">
                            <div class="product-img">
                                <img src="img/menu-imgs/B.jpg" alt="food-img" srcset="">
                            </div>
                            <div class="product-details-wrapper">
                                <div class="product-details">
                                    <span class="product-title">Combo B</span>
                                    <span class="product-description">Includes: Regular Burger, Carbonara, Blue Lemonade</span>
                                    <span class="product-price">89.00PHP</span>
                                </div>
                                <div class="interact">
                                    <button class="btn" onclick="open_cart();">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="menu-item">
                            <div class="product-img">
                                <img src="img/menu-imgs/C.jpg" alt="food-img" srcset="">
                            </div>
                            <div class="product-details-wrapper">
                                <div class="product-details">
                                    <span class="product-title">Combo C</span>
                                    <span class="product-description">Includes: Regular Hotdog, Regular Fries, Blue Lemonade</span>
                                    <span class="product-price">80.00PHP</span>
                                </div>
                                <div class="interact">
                                    <button class="btn" onclick="open_cart();">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="menu-item">
                            <div class="product-img">
                                <img src="img/menu-imgs/D.jpg" alt="food-img" srcset="">
                            </div>
                            <div class="product-details-wrapper">
                                <div class="product-details">
                                    <span class="product-title">Combo D</span>
                                    <span class="product-description">Includes: Regular Fries, Carbonara, Blue Lemonade</span>
                                    <span class="product-price">85.00PHP</span>
                                </div>
                                <div class="interact">
                                    <button class="btn" onclick="open_cart();">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="menu-item">
                            <div class="product-img">
                                <img src="img/menu-imgs/E.jpg" alt="food-img" srcset="">
                            </div>
                            <div class="product-details-wrapper">
                                <div class="product-details">
                                    <span class="product-title">Combo E</span>
                                    <span class="product-description">Includes: Regular Burger, Regular Fries, Spaghetti, Blue Lemonade</span>
                                    <span class="product-price">55.00PHP</span>
                                </div>
                                <div class="interact">
                                    <button class="btn" onclick="open_cart();">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="menu-item">
                            <div class="product-img">
                                <img src="img/menu-imgs/Barkada Meal.jpg" alt="food-img" srcset="">
                            </div>
                            <div class="product-details-wrapper">
                                <div class="product-details">
                                    <span class="product-title">Barkada Meal</span>
                                    <span class="product-description">Good for 4 People. Includes: 4 Regular Fries, 4 Regular Burger, 4 Blue Lemonade</span>
                                    <span class="product-price">55.00PHP</span>
                                </div>
                                <div class="interact">
                                    <button class="btn" onclick="open_cart();">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MENU ITEM END HERE -->

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
            <div class="container">
                <div class="row">
                    <div class="col-12 footer-header">
                        <img src="img/penguin.png" alt="penguin.png" width="116px" height="104px">
                    </div>
                </div>
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
                            0977 283 6086
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

                        <div class="input-container">
                            <form action="#" class="newsletter-form">
                                <input type="text" name="email" id="newsletter-input" placeholder="Email Address">
                                <button type="submit">SUBSCRIBE</button>
                            </form>
                        </div>

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





    <div class="temporary_hide">
        <!-- dito lalabas kung ilan yung nasa cart ng user -->
        <div> cart count <span id="cart_count"></span> </div>

        <!-- Modal - lalabas lang pag naclick na yung add to cart -->
        <form id="menu_form" method="POST">

            <input type="hidden" name="cart_menu_id" id="cart_menu_id">
            <input type="text" name="user_id" id="user_id" value="<?php echo $user_id ?>">

            <div>
                <button type="button" id="increase" onclick="quantity(this.id);">+</button>
                <input type="text" name="quantity" id="quantity" value="1" disabled>
                <button type="button" id="decrease" onclick="quantity(this.id);">-</button>

            </div>

            <button type="button" name="add_to_cart" id="add_to_cart">ADDTo catr</button>
            <button type="button" name="cancel_cart" id="cancel_cart" onclick="cancel_cart();">Cancel</button>
        </form>



        <div class="menu_list" id="menu_list">

        </div>

    </div>



    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        function open_cart() {
            document.getElementById('sidecart').style.display = "flex";
            document.getElementById('sidecart').style.animationName = "open_cart";

        }

        function close_cart() {
            document.getElementById('sidecart').style.animationName = "close_cart";
        }
    </script>

</body>

<script>
    document.getElementById('add_to_cart').onclick = function() {
        var form_data = new FormData(document.getElementById('menu_form'));
        form_data.append('add_to_cart', <?php echo $user_id ?>);

        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function(response) {
            return response.json();

        }).then(function(response_data) {
            cart_count();
            console.log(response_data);
        });

    }

    function quantity(element) {

        let quantity = parseInt(document.getElementById('quantity').value);
        if (element == "increase") {

            quantity = quantity + 1;
        } else {
            quantity = quantity - 1;
        }

        if (element == "increase") {
            if ((parseInt(document.getElementById('quantity').value) < 10)) {
                document.getElementById('quantity').value = parseInt(document.getElementById('quantity').value) + 1;
                document.getElementById('decrease').disabled = false;
                document.getElementById('increase').disabled = false;
            } else {
                document.getElementById('increase').disabled = true;
            }
        } else {
            if ((parseInt(document.getElementById('quantity').value) > 1)) {
                document.getElementById('quantity').value = parseInt(document.getElementById('quantity').value) - 1;
                document.getElementById('decrease').disabled = false;
                document.getElementById('increase').disabled = false;
            } else {
                document.getElementById('decrease').disabled = true;
            }
        }
    }

    cart_count();

    function cart_count() {
        var cart_form_data = new FormData(document.getElementById('menu_form'));

        cart_form_data.append('add_to_cart_count', 'add_to_cart_count');
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: cart_form_data
        }).then(function(response) {

            return response.json();

        }).then(function(response_data) {

            console.log(response_data.cart_count);
            document.getElementById('cart_count').innerHTML = `${response_data.cart_count}`;

        });

    }

    /* Retrieve data from menu table */
    var form_data = new FormData();
    form_data.append('display_menu', 'display_menu');
    fetch('php/controller/c_menu.php', {

        method: "POST",
        body: form_data
    }).then(function(response) {

        return response.json();

    }).then(function(response_data) {


        let menu_list = "";
        let name = document.querySelector(".menu_list");

        response_data.data.map(function(menu) {
            /* dito ilalagay yung css design */
            menu_list += `
            <div class="text"><br>
            <button type="button" name='${menu.menu_id}' id="temp_add_to_cart"> Add To cart </button>
            <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${menu.image}' width="100px" height="100px">
            <div>${menu.name}</div>
            <div>${menu.description}</div>
            <div>${menu.category}</div>
            <div>${menu.discount}</div>
            <div>${menu.price}</div>
            <div>${menu.date}</div>
            <div>${menu.availability}</div>
         
            </div>
            `;
        });
        document.getElementById("menu_list").innerHTML = menu_list;

        function cancel_cart() {
            document.getElementById("cart_menu_id").value = "";
            document.getElementById("quantity").value = 1;
        }

        document.querySelectorAll("#temp_add_to_cart").forEach(function(button) {
            button.onclick = function(e) {

                document.getElementById("cart_menu_id").value = e.target.name;

            }
        });
        /*   if (response_data.success) {
             

          } else if (response_data.error) {
              console.log('err');
              window.location.href = "error.php";
          } */
    });
</script>

</html>