class Cart {

    /* -------------------- cart */
    constructor() {
        document.getElementById('cartlist').style.display = "none";
    }

    cart() {
        new Cart().cart_count();
      
        new Cart().display_cart();
        new Cart().close_add_order();


        /* redisplay the customers selected item for them to be able to verify their orders */
        document.getElementById('verify_order').onclick = function () {
            new Cart().open_add_order();
            let verify_list = "";

            let cart_id_list = (document.getElementById("cartlist").value).split(",");
           
                verify_list += `
                
                <div class="content-container">
                <div class="closing-bar">
                    <button class="close-btn"  onclick="new Cart().close_add_order();">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="mod-top">
                
                    <div class="header-col with-details w-100">
                        <span class="order-number-label">Checkout</span>
                        <form id="order_form" method="POST" class="mb-3">
                            
                            <label class="h6">When do you want to pick up your order?</label>
                            <div class="input-group">

                                <input type="date" class="form-control me-1 checkout-input-date" id="date" name="date">
                                <input type="text" class="form-control ms-1 checkout-input-time" id="time" name="time">
                            </div>

                        </form>
                    </div>
                    
                </div>
                <div class="items-list" style="min-height:215px;max-height:215px;">`;
                for (let i = 0; i < cart_id_list.length; i++) {
                    let selected_cart_image = document.getElementById(`cart-image${cart_id_list[i]}`).src;
                    let selected_cart_name = document.getElementById(`cart-name${cart_id_list[i]}`).innerHTML;
                    let selected_cart_quantity = document.getElementById(`cart-quantity${cart_id_list[i]}`).value;
                    let selected_cart_price = document.getElementById(`cart-price${cart_id_list[i]}`).innerHTML;
                    
                    console.log(cart_id_list[i]);
                verify_list += `    <div class="item">
                        <div class="item-img-container">
                            <img src="${selected_cart_image}" alt="${selected_cart_name}">
                        </div>
                        <div class="item-details">
                            <div class="quantity-con">
                                <span><span class="modal-quantity">${selected_cart_quantity}</span>x</span>
                            </div>
                            <div class="item-name-con">
                                <span class="item-namee">${selected_cart_name}</span>
                            </div>
                            <div class="item-price-con">
                                <span class="item-pricee">${selected_cart_price}</span>
                            </div>
                        </div>
                    </div>`;
                }
                    verify_list += `   </div>
              
                <div class="mod-footer">
                    <div class="footer-col">
                        <span>Subtotal: </span>
                    </div>
                    <div class="footer-col">
                        <span class="sub-total">${document.getElementById("cart_total_price").innerHTML}</span>
                    </div>
                </div>
                <div class="cancel-bar">
                  
                    <button class="btn btn-success cancel-btn" type="button" name="add_to_order" id="add_to_order" onclick="new Cart().add_order();" style="width:130px;">Checkout</button>
                </div>
            </div>
                    `;
                    new Cart().fetch_closed_date();
            document.getElementById("order-details-modal").innerHTML = verify_list;
            // document.getElementById("verify_price").innerHTML = document.getElementById("cart_total_price").innerHTML;
        }
      
    }

    /* gets and displays customers added to cart items */
    display_cart() {
        let form_data = new FormData();
        form_data.append('display_cart', 'display_cart');
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            let cart_list = "";

            if (response_data.error) {
                document.getElementById("cart_list").innerHTML = response_data.error;
            } else {
                response_data.data.map(function (cart) {

                    cart_list += `
            <div class="cart_item d-flex align-items-center my-3 mx-1 p-2 position-relative">`
                    if (cart.availability == "Available") {
                        cart_list += `<input type="checkbox" class="" name='on_cart' value="${cart.cart_id}" data-price="${cart.total_discounted_price}" id="cart_${cart.cart_id}"/>`
                    }
                    cart_list += `   
            <div class="d-flex col">
            <img class=" cart-image mx-2 " id="cart-image${cart.cart_id}" src='https://res.cloudinary.com/dhzn9musm/image/upload/${cart.image}' alt="">
                <div class="d-flex flex-column">
                    <div class="item-name" id="cart-name${cart.cart_id}">${cart.name}</div>`
                    if (cart.availability == "Available") {
                        if (cart.discount != 0) {
                            cart_list += `  <div class="">x<input id="cart-quantity${cart.cart_id}"  style="width:40px;" class="item-quantity" type="number" name="quantity_change" value="${cart.quantity}" data-cart-id="${cart.cart_id}"/><span  id="cart-price${cart.cart_id}"  class=" ms-3 bolder item-price position-absolute" style="right:20px;">PHP ${(cart.discounted_price).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace(".00", "")}</span></div>`;
                        } else {
                            cart_list += `  <div class="" >x<input id="cart-quantity${cart.cart_id}"  style="width:40px;" class="item-quantity" type="number" name="quantity_change" value="${cart.quantity}" data-cart-id="${cart.cart_id}" /><span  id="cart-price${cart.cart_id}" class="ms-3 bolder item-price position-absolute" style="right:20px;">PHP ${cart.price}</span></div>`;
                        }
                    } else {
                        cart_list += `  <span class="ms-3 bolder item-price" style="margin-left:8px!important;">UNAVAILABLE</span>`;
                    }
                    cart_list += `      </div>
                </div>
              <i class="item-remove fa-solid fa-xmark ms-1 position-absolute" name='delete_cart'  onclick="new Cart().delete_cart(${cart.cart_id},'delete');" style="top:5px;right:5px;"></i>
            </div>
        `;
                });
            }
            document.getElementById("cart_list").innerHTML = cart_list;
            get_checkbox_status();

            /* keeps checkbox state */
            if (document.getElementById("cartlist").value != "") {
                let cart_id_list = (document.getElementById("cartlist").value).split(",");
                for (let i = 0; i < cart_id_list.length; i++) {
                    document.getElementById(`cart_${cart_id_list[i]}`).checked = true;

                }
            }

            /* determines if the quantity has been changed,
            changes made will automatically be saved */
            document.querySelectorAll('input[name=quantity_change]').forEach(function (checkbox) {
                checkbox.onchange = function (e) {

                    /*  sets minimum and maximum values of the quantity */
                    if (checkbox.value > 99) {
                        checkbox.value = 99;
                    }
                    if (checkbox.value < 1) {
                        checkbox.value = 1;
                    }
                    let form_data = new FormData();
                    form_data.append('update_quantity', 'update_quantity');
                    form_data.append('cart_id', e.target.getAttribute('data-cart-id'));
                    form_data.append('quantity', e.target.value);
                    fetch('php/controller/c_cart.php', {
                        method: "POST",
                        body: form_data
                    }).then(function (response) {
                        return response.json();
                    }).then(function (response_data) {
                        console.log(response_data);
                        new Cart().get_price();
                    });
                }
            });
        });

        /* determines if at least one item is selected, if true it will show the order button as well as the total price of all the selected item */
        function get_checkbox_status() {
            document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
                checkbox.onchange = function (e) {
                    document.getElementById("cartlist").value = get_checked(checkbox.name, "value");
                    new Cart().get_price();
                    var len = document.querySelectorAll('input[type="checkbox"]:checked').length
                    if (len <= 0) {
                        document.getElementById('cart_summary').style.display = "none";
                        document.getElementById("cartlist").value = "";
                    } else {
                        document.getElementById('cart_summary').style.display = "flex";
                    }
                }
            });
        }

        /* gets the data-price attribute of the selected item */
        function get_checked(name, attribute) {
            let values = [];
            document.querySelectorAll('input[name="' + name + '"]:checked').forEach(function (checked) {
                if (attribute == "value") {
                    values.push(checked.value);
                } else {
                    values.push(checked.getAttribute("data-price"));
                }
            });
            return values;
        }
    }

    /* calculate the total price of all the selected item */
    get_price() {
        let form_data = new FormData();
        form_data.append('get_price', 'get_price');
        form_data.append('cartlist', document.getElementById("cartlist").value);
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log("response_data");
            console.log(response_data);
            let total_discounted_price = 0;
            response_data.data.map(function (price) {
                total_discounted_price = total_discounted_price + parseFloat(price.total_discounted_price);
                console.log(total_discounted_price);
            });

            document.getElementById("cart_total_price").innerHTML = `PHP ${total_discounted_price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        });
    }

    delete_cart(cart_id, type) {
        if (type == "empty") {
            if (confirm("Are you sure you want to delete all items in cart?")) {
                new Cart().continue_delete(cart_id, type);
            }
        } else {
            new Cart().continue_delete(cart_id, type);
        }
    }

    continue_delete(cart_id, type) {
        let form_data = new FormData();
        form_data.append('delete_cart', 'delete_cart');
        form_data.append('cart_id', cart_id);
        form_data.append('type', type);
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (response_data.success) {
                /* removes the deleted item to the cartlist*/
                if ((document.getElementById("cartlist").value).includes(`,${cart_id}`)) {
                    document.getElementById("cartlist").value = (document.getElementById("cartlist").value).replace(`,${cart_id}`, "");

                } else if ((document.getElementById("cartlist").value).includes(`${cart_id}`)) {
                    document.getElementById("cartlist").value = (document.getElementById("cartlist").value).replace(`${cart_id}`, "");
                }
                new Cart().display_cart();
                new Cart().cart_count();
                new Cart().get_price();
                if (type == "empty") {
                    document.getElementById('empty_cart').style.display = "none";
                    document.getElementById("cartlist").value = "";
                }

                if (document.querySelectorAll('input[type="checkbox"]:checked').length == 1) {
                    document.getElementById('cart_summary').style.display = "none";
                }


            } else {
                new Notification().create_notification(response_data.error, "error");
            }
        });
    }

    /* add an item to the cart table */
    add_to_cart(menu_id) {
        let form_data = new FormData();
        form_data.append('add_to_cart', 'add_to_cart');
        form_data.append('menu_id', menu_id);
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            if (response_data.success) {
                new Cart().display_cart();
                /*  new Notification().create_notification(response_data.success, "success"); */
                new Cart().cart_count();
                /*         new Cart().cancel_cart(); */
                new Cart().open_cart();
                document.getElementById('empty_cart').style.display = "block";
            } else if (response_data.error) {
                new Notification().create_notification(response_data.error, "error");
            }
        });

    }

    /* gets customers cart items count */
    cart_count() {
        let form_data = new FormData();
        form_data.append('add_to_cart_count', 'add_to_cart_count');
        fetch('php/controller/c_cart.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            if (response_data.cart_count == null) {
                document.getElementById('cart_count').innerHTML = "(0)";
                document.getElementById('empty_cart').style.display = "none";
                document.getElementById('cart_summary').style.display = "none";
            } else {
                document.getElementById('cart_count').innerHTML = `(${response_data.cart_count})`;
                document.getElementById('empty_cart').style.display = "block";
            }
        });
    }

    open_cart() {
        document.getElementById('sidecart').style.display = "flex";
        document.getElementById('sidecart').style.animationName = "open_cart";
    }

    close_cart() {
        document.getElementById('sidecart').style.animationName = "close_cart";
    }





    /* transfers selected cart items to the order table */
    add_order() {
        document.getElementById('add_to_order').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById('add_to_order').disabled = true;

        let form_data = new FormData(document.getElementById('order_form'));
        form_data.append('add_order', 'add_order');
        form_data.append('cartlist', document.getElementById("cartlist").value);
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            document.getElementById('add_to_order').innerHTML = "Checkout";
            document.getElementById('add_to_order').disabled = false;
            document.getElementById("cartlist").value = "";

            new Cart().display_cart();
            if (response_data.success) {
                new Notification().create_notification(response_data.success, "success");
                new Cart().close_add_order();
                window.location.href = "order.php?order=1"
            } else {
                new Notification().create_notification(response_data.error, "error");
            }
        });
    }

    /* fetches dates where the business is closed and removes it from the date picker */
    fetch_closed_date() {

        let form_data = new FormData();
        form_data.append('display_closed_date', 'display_closed_date');

        fetch('php/controller/c_closed_date.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();

        }).then(function (response_data) {
            let closed_date_list = [];
            /* gets the current date and time and displays it to the date and time picker with a format of YYYY-MM-DD for date and HH: MM for time*/
            let date = new Date();
            let day = date.getDate(),
                month = date.getMonth() + 1,
                year = date.getFullYear(),
                hour = date.getHours(),
                min = date.getMinutes();
            let check_day = 0;

            if (hour > 20) {
                check_day = day + 1;
            } else {
                check_day = day;
            }
            month = (month < 10 ? "0" : "") + month;
            day = (day < 10 ? "0" : "") + day;
            hour = (hour < 10 ? "0" : "") + hour;
            min = (min < 10 ? "0" : "") + min;

            response_data.data.map(function (closed_date) {
                closed_date_list.push(closed_date.filter_date);
            });

            document.getElementById('date').flatpickr({
                "disable": closed_date_list,
                minDate: "today",
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                defaultDate: `${year}-${month}-${check_day}`
            });
            /* determines if the current time is not within the business open hours */
            let default_date = "";
            let today = new Date().getHours();
            if (today < 10) {
                default_date = `08:00`;
            } else if (today > 20) {
                default_date = `20:00`;
            } else {
                default_date = `${hour}:${min}`;
            }

            document.getElementById('time').flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",
                defaultDate: default_date,
                maxTime: "20:00",
                minTime: "8:00",
                minuteIncrement: 15,
            });

        });
    }

    open_add_order() {
        document.getElementById("order-details-modal").style.display = "block";
        document.querySelector('body').style.overflow = 'hidden';

    }

    close_add_order() {
     
        document.getElementById("order-details-modal").style.display = "none";
        document.querySelector('body').style.overflow = 'visible';

    }
}