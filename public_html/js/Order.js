class Order {
    table;
    add_button;
    constructor(table) {
        this.qr_code_id = "";
        this.table = table;
    }


    display_order() {
        let order_form_data = new FormData();
        order_form_data.append('display_order', 'display_order');
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: order_form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            let order_list = "";
            let total_discounted_price = 0;
            console.log(response_data);
            if (response_data.error) {
                document.getElementById("order_list").innerHTML = response_data.error;
            } else {
               
                    let current_order_id = 0;
                response_data.data.map(function (order) {
                    /* checks if the customer has multiple order */
                    if(order.order_id != current_order_id ) {
                    /* display delete and download QR button only once */
                    
                    order_list += `<hr>`;
                    current_order_id = order.order_id; 
                    if(order.status == "Placed") {
                        order_list += `<button type="button" class="" name='delete_order'  onclick="new Order().delete_order(${order.order_id});">Delete</button>`;
                    }  else {
                        order_list += `<button type="button" class="" name='delete_order'  onclick="new Order().delete_order(${order.order_id});" disabled>Delete</button>`;
                    }
                    
                    order_list += `<a href='https://res.cloudinary.com/dhzn9musm/image/upload/${order.qr_image}' target="_blank" width='40px' height='40px'>
                  Download QR
                    </a>`;
                 
                    } 
                    order_list += `
            <div class="text">
            
            <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${order.image_list}' width='40px' height='40px'></img>
                <div>${order.order_id}</div>
                <div>${order.menu_name_list}</div>
                <div>${order.quantity_list}</div>
                <div>${order.category_list}</div>
                <div>${order.price_list}</div>
            </div>  
            `;
      
                    total_discounted_price = total_discounted_price + parseFloat(order.total_discounted_price);
                });
             
                order_list += `
                <div>${total_discounted_price}</div>
                `;
            }
            
            document.getElementById("order_list").innerHTML = order_list;

            /* lightGallery(document.getElementById('order_list'), {
                animateThumb: false,
                zoomFromOrigin: false,
                allowMediaOverlap: true,
                toggleThumb: false,
                hideControlOnEnd : true,
                
            }); */
        });

     
    }

    display_completed_order() {
        let order_form_data = new FormData();
        order_form_data.append('display_completed_order', 'display_completed_order');
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: order_form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            let order_list = "";
            let total_discounted_price = 0;
            console.log(response_data);
            if (response_data.error) {
                document.getElementById("order_list").innerHTML = response_data.error;
            } else {
                console.log(response_data.data[0].order_id);
                
                response_data.data.map(function (order) {
                    let current_order_id = 0;
                    if(order.order_id != current_order_id ) {
                        /* display delete and download QR button only once */
                        
                        current_order_id = order.order_id; 
                     
                        order_list += `<hr>`;
                        order_list += ` <div>${order.date}</div>`;
                     
                        } 
                    order_list += `
            <div class="text">
            <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${order.image_list}' width='40px' height='40px'></img>
                <div>${order.order_id}</div>
                <div>${order.menu_name_list}</div>
                <div>${order.quantity_list}</div>
                <div>${order.category_list}</div>
                <div>${order.price_list}</div>
            </div>
            `;
                    total_discounted_price = total_discounted_price + parseFloat(order.total_discounted_price);
                });
                order_list += `
                <div>${total_discounted_price}</div>
                `;
            }
            document.getElementById("order_list").innerHTML = order_list;
        });
    }

    delete_order(order_id) {
        let delete_order_data = new FormData();
        delete_order_data.append('delete_order', 'delete_order');
        delete_order_data.append('order_id', order_id);
        fetch('php/controller/c_order.php', {
            method: "POST",
            body: delete_order_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            new Order().display_order();
        });
    }



/* -------------------- */
qr_claim_order() {
    let form_data = new FormData();
    form_data.append('qr_claim_order', 'qr_claim_order');
    form_data.append('qr_code_id', this.qr_code_id);

    fetch('php/controller/c_order.php', {
        method: "POST",
        body: form_data
    }).then(function (response) {
        return response.json();
    }).then(function (response_data) {
        console.log(response_data);
        new Order().qr_close_modal();
    });
}

/* gets and displays the order information scanned */
qr_fetch_info(content) {
    this.qr_code_id = content;
    new Audio('sound/beep.mp3').play();;
    let form_data = new FormData();
    form_data.append('qr_code_id', this.qr_code_id);
    form_data.append('qr_fetch_info', 'qr_fetch_info');
    fetch('php/controller/c_order.php', {
        method: "POST",
        body: form_data
    }).then(function (response) {
        return response.json();
    }).then(function (response_data) {
        console.log(response_data);
        if(response_data.error) {
            new Notification().create_notification(response_data.error, "error");
        } else {
        let qr_to_claim_info = "";
        let qr_to_claim_order = "";
        let order = response_data.data[0];
        let images = (order.image_list).split(',');
        let orders = (order.menu_name_list).split(',');
        let prices = (order.price_list).split(',');
        let quantity = (order.quantity_list).split(',');
        let discount = (order.discount_list).split(',');
        let total_price=0;
        qr_to_claim_info += `
      
        <div>${order.firstname} ${order.lastname}</div>
        <div>${order.date}</div>
        <div>pp${order.price_list}</div>
        <div>${order.status}</div>`

        
        ;
        for (let i = 0; i < prices.length; i++) {
              total_price += (parseFloat(prices[i]) - (parseFloat(prices[i]) * (parseFloat(discount[i])/ 100))) * parseFloat(quantity[i]); 
            qr_to_claim_order += `
    
          <img src='https://res.cloudinary.com/dhzn9musm/image/upload/${images[i]}' width='40px' height='40px'></img>
          <div>${prices[i]}</div>
          <div>${orders[i]}</div>
          <div>${quantity[i]}</div>
      `;
        };
        qr_to_claim_order += `
          <div>Total Price: ${total_price}</div>
      `;
        document.getElementById("qr_to_claim_order").style.display = "block";
        document.getElementById("qr_to_claim_order").style.display = "block";
        document.getElementById('qr_to_claim_info').innerHTML = qr_to_claim_info;
        document.getElementById('qr_to_claim_order').innerHTML = qr_to_claim_order;
        document.getElementById("qr_modal").style.display = "block";
    }
    });


}

qr_close_modal() {
    this.qr_code_id = "";
    document.getElementById("qr_modal").style.display = "none";
    document.getElementById("qr_to_claim_order").style.display = "none";
    document.getElementById("qr_to_claim_order").style.display = "none";
}

claim_order(order_id,user_id) {
    if(confirm("Are you sure you want to claim order# " + order_id)) {
    let form_data = new FormData();
    form_data.append('claim_order', 'claim_order');
        form_data.append('order_id', order_id);
        form_data.append('user_id', user_id);
    console.log(form_data);
    fetch('php/controller/c_order.php', {
        method: "POST",
        body: form_data
    }).then(function (response) {
        return response.json();
    }).then(function (response_data) {
        console.log(response_data);
        new Order().qr_close_modal();
    });

}
}


del_notif(order_id, user_id) {
    document.getElementById("del_notif_modal").style.display = "block";

    document.getElementById("del_notif_order_id").value = order_id;
    document.getElementById("del_notif_user_id").value = user_id;
}
close_del_notif() {
    document.getElementById("del_notif_modal").style.display = "none";
    document.getElementById("del_notif_order_id").style.display = "none";
    document.getElementById("del_notif_order_id").value = "";

    document.getElementById("del_notif_user_id").style.display = "none";
    document.getElementById("del_notif_user_id").value = "";
    document.getElementById("del_notif").selectedIndex = 0;
}













action_order_button() {

    document.getElementById('action_order_button').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    document.getElementById('action_order_button').disabled = true;

    let form_data = new FormData(document.getElementById('order_form'));
    console.log(form_data);
    fetch('php/controller/c_order.php', {

        method: "POST",
        body: form_data

    }).then(function (response) {

        return response.json();

    }).then(function (response_data) {

        console.log(response_data);
        if (response_data.success) {
            document.getElementById('success_message').innerHTML = response_data.success;
            new Order().close_modal();
            table.update();
            let action_order_button = document.getElementById('action_order_button').value;
            console.log(action_order_button);
            if (action_order_button != "Edit") {
                dataAdded();
                console.log("1");
                document.getElementById('action_order_button').innerHTML = "Add";

            } else {
                console.log("2");
                document.getElementById('action_order_button').innerHTML = "Edit"

            }
            document.getElementById('action_order_button').disabled = false;
        } else {
            new Order().show_error(response_data.customer_name_error, 'customer_name_error');
            new Order().show_error(response_data.order_name_error, 'order_name_error');
            new Order().show_error(response_data.price_error, 'pric_errore');
            new Order().show_error(response_data.quantity_error, 'quantity_error');
            new Order().show_error(response_data.total_price_error, 'total_price_error');
            new Order().show_error(response_data.date_error, 'date_error');
            new Order().show_error(response_data.time_error, 'time_error');
            new Order().show_error(response_data.status_error, 'status_error');










        }
    });
}

fetch_data(id) {
    new Order().reset_error();
    let form_data = new FormData();
    form_data.append('id', id);
    form_data.append('action_order', 'fetch');

    fetch('php/controller/c_order.php', {
        method: "POST",
        body: form_data
    }).then(function (response) {
        return response.json();

    }).then(function (response_data) {
        console.log(response_data);


        document.getElementById('customer_name').disabled = "true";
        document.getElementById('order_name').disabled = "true";
        document.getElementById('price').disabled = "true";
        document.getElementById('quantity').disabled = "true";
        document.getElementById('total_price').disabled = "true";



        document.getElementById('order_id').value = response_data.order_id;
        document.getElementById('customer_name').value = response_data.customer_name;
        document.getElementById('order_name').value = response_data.order_name;
        document.getElementById('price').value = response_data.price;
        document.getElementById('quantity').value = response_data.quantity;
        document.getElementById('total_price').value = response_data.total_price;
        document.getElementById('date').value = response_data.date;
        document.getElementById('time').value = response_data.time;
        document.getElementById('status').value = response_data.status;



        document.getElementById('action_order').value = 'Update';
        document.getElementById('modal_title').innerHTML = 'Edit Data';
        document.getElementById('action_order_button').innerHTML = 'Edit';
        document.getElementById('action_order_button').value = "Edit"
        new Order().open_modal();

    });
}

delete_data() {
    let form_data = new FormData(document.getElementById('del_notif_form'));
    form_data.append('action_order', 'delete');
    fetch('php/controller/c_order.php', {
        method: "POST",
        body: form_data
    }).then(function (response) {
        return response.json();
    }).then(function (response_data) {
        console.log(response_data);
        document.getElementById('success_message').innerHTML = response_data.success;
        dataRemoved();
        table.update();
        new Order().close_del_notif();
    });
}

open_modal() {
    
    document.getElementById('modal_backdrop').style.display = 'block';
    document.getElementById('order_modal').style.display = 'block';
    document.getElementById('order_modal').classList.add('show');

}

close_modal() {
    document.getElementById('modal_backdrop').style.display = 'none';
    document.getElementById('order_modal').style.display = 'none';
    document.getElementById('order_modal').classList.remove('show');
}

reset_input() {
    document.getElementById('order_form').reset();
    document.getElementById('action_order').value = 'Add';
    document.getElementById('modal_title').innerHTML = 'Add Data';
    document.getElementById('action_order_button').innerHTML = 'Add';
    document.getElementById('show_order_image').src = "";

    new Order().reset_error();
}

reset_error() {

    document.getElementById('customer_name_error').innerHTML = '';
    document.getElementById('order_name_error').innerHTML = '';
    document.getElementById('price_error').innerHTML = '';
    document.getElementById('quantity_error').innerHTML = '';
    document.getElementById('total_price_error').innerHTML = '';
    document.getElementById('date_error').innerHTML = '';
    document.getElementById('time_error').innerHTML = '';
    document.getElementById('status_error').innerHTML = '';
}

show_error(error, element) {
    if (error) {
        document.getElementById(element).innerHTML = error;
    } else {
        document.getElementById(element).innerHTML = '';
    }
}
}