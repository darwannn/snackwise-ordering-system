<?php $user_id = 1?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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

</body>

<script>
    document.getElementById('add_to_cart').onclick = function () {
        var form_data = new FormData(document.getElementById('menu_form'));
        form_data.append('add_to_cart', <?php echo $user_id?> );

        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();

        }).then(function (response_data) {
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
        }).then(function (response) {

            return response.json();

        }).then(function (response_data) {

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
    }).then(function (response) {

        return response.json();

    }).then(function (response_data) {


        let menu_list = "";
        let name = document.querySelector(".menu_list");

        response_data.data.map(function (menu) {
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

        document.querySelectorAll("#temp_add_to_cart").forEach(function (button) {
            button.onclick = function (e) {

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