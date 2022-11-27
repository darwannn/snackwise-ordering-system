class Notification {

  notification() {
    new Notification().notification_count();
    new Notification().display_notification();

    const notificationBtn = document.querySelector('.notification-button');
    const notificationPanel = document.querySelector('.notifications-panel')
    let notifOpen = false;

    if (notificationBtn) {
      notificationBtn.addEventListener("click", () => {
        if (!notifOpen) {
          notificationPanel.style.display = "flex";
          notifOpen = true;
        } else {
          notificationPanel.style.display = "none";
          notifOpen = false;
          new Notification().update_notification();
          document.getElementById('notification_count').style.display = "none";
        }
      })
    }
  }

  /* hides or shows notifications */
  toggle_notification() {
    if (document.getElementById("notification_list").style.display == "none") {
      new Notification().display_notification();
      document.getElementById("notification_list").style.display = "block";
      console.log("block");
    } else {
      new Notification().update_notification();
      document.getElementById("notification_list").style.display = "none";
      console.log("none");
    }
  }

  /* changes the status of notification from unread to read  */
  update_notification() {
    let form_data = new FormData();
    form_data.append('update_notification', 'update_notification');
    fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
    }).then(function (response) {
      return response.json();
    }).then(function (response_data) {
      new Notification().notification_count();
      new Notification().display_notification();
    });
  }

  /*  count all the unread notification of a customer */
  notification_count() {
    /* document.getElementById("notification_list").style.display = "none"; */
    let form_data = new FormData();
    form_data.append('notification_count', 'notification_count');
    fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
    }).then(function (response) {
      return response.json();
    }).then(function (response_data) {
      console.log(response_data);
      if ((response_data.notification_count) >= 1) {
        document.getElementById("notification_count").innerHTML = response_data.notification_count;
      } else if ((response_data.notification_count) <= 0) {
        document.getElementById("notification_count").innerHTML = "0";
        document.getElementById('notification_count').style.display = "none";
      }
    });
  }

  /*  display all the notifications intended for the customer */
  display_notification() {
    let form_data = new FormData();
    form_data.append('display_notification', 'display_notification');
    fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
    }).then(function (response) {
      return response.json();
    }).then(function (response_data) {
      console.log(response_data);
      let notification_list = "";
      let notif_date = "";
      let show_date = "";
      const month_name = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
      console.log(response_data);
      if ((response_data.data).length == 0) {
        notification_list += ` <div class="empty-notification">
          <span class="empty-message"> 
              Looks like you doesn't have notifications yet. 
          </span>
          </div>`;
      } else {
        response_data.data.map(function (notif) {
          




  let fetch_month = (notif.date).substr(5,2);
          let today = new Date();
          let fetch_date = new Date(notif.date.substr(0,10));
  
          let fetch_time = new Date(notif.date).toLocaleTimeString('en-US', {hour12:true,hour:'numeric',minute:'numeric'});
          
          const yesterday = new Date(); yesterday.setDate(today.getDate() - 1);

          if(fetch_date.toLocaleDateString() == today.toLocaleDateString()){
            show_date =  'Today'
          }else if (fetch_date.toLocaleDateString() == yesterday.toLocaleDateString()) {
            show_date =  'Yesterday'
          }else {
            show_date = `${month_name[fetch_month-1]} ${(notif.date).substr(8,2)}, ${(notif.date).substr(0,4)}`;
          }

          if (notif.type == "Cancelled") {

            notification_list += `<div class="notification" id="notif-cancelled">
          <div class="notification-header-container">
              <div class="header-info">
                  <span class="order-number" style="font-size: 1.3em;">#${(notif.order_id).toString().padStart(10, '0')}</span>
                  <span class="notification-header">Order Cancelled ❌</span>
              </div>
              <span class="notification-time" style="white-space: nowrap; text-align:right;">${show_date}<br>${fetch_time}</span>
          </div>
          <div class="notification-body-container">
              <span class="notification-body ${notif.status}-notification">
                  Your order has been rejected and cancelled.
              </span>
          </div>
          <span class="additional-message">
              Reason: ${notif.message}
          </span>
          </div>`;

          } else {
            if (notif.type == "Completed" || notif.type == "Ready") {
              notification_list += ` <div class="notification" id="notif-success">`;
            } else if (notif.type == "Placed" || notif.type == "Confirmed" || notif.type == "Preparing") {
              notification_list += ` <div class="notification" id="">`;
            }

            notification_list += `  <div class="notification-header-container">
              <div class="header-info">
                  <span class="order-number" style="font-size: 1.3em;">#${(notif.order_id).toString().padStart(10, '0')}</span>`;
            if (notif.type == "Completed") {
              notification_list += ` <span class="notification-header ${notif.status}-notification">Thank You for Ordering 💖</span>`;

            } else if (notif.type == "Ready") {
              notification_list += ` <span class="notification-header ${notif.status}-notification">Order Ready for Pickup! 😋</span>`;

            } else if (notif.type == "Placed") {
              notification_list += ` <span class="notification-header ${notif.status}-notification">Order Placed ✔</span>`;

            } else if (notif.type == "Confirmed") {
              notification_list += ` <span class="notification-header ${notif.status}-notification">Order Confirmed ✨</span>`;

            } else if (notif.type == "Preparing") {
              notification_list += ` <span class="notification-header ${notif.status}-notification">Order on Process 🍳</span>`;
            }

            notification_list += `      </div>
              <span class="notification-time" style="white-space: nowrap; text-align:right;">${show_date}<br>${fetch_time}</span>
            </div>
            <div class="notification-body-container">
            <span class="notification-body">
            ${notif.message}
            </span>
            </div>
            <span class="additional-message"></span>
          </div>`;
          }

        });
      }

      document.getElementById("notification_list").innerHTML = notification_list;

    });
  }

  /* creates  and display a notification */
  create_notification(message, type) {
    let create_toast_notif_dialog = document.createElement("div");
    /* adds an id to the element which will be used to automatically remove it to the DOM after a specific time */
    let id = Math.random().toString(36).substr(2, 10);
    create_toast_notif_dialog.setAttribute("id", id);
    create_toast_notif_dialog.classList.add("toast_notif_dialog", type);
    create_toast_notif_dialog.innerText = message;
    document.getElementById("toast_notif").appendChild(create_toast_notif_dialog);

    let toast_notif_dialog = document.querySelector(".toast_notif").getElementsByClassName("toast_notif_dialog");
    let toast_notif_close = document.createElement("div");
    toast_notif_close.classList.add("toast_notif_close");
    toast_notif_close.innerHTML = '<i class="fas fa-times"></i>';
    create_toast_notif_dialog.appendChild(toast_notif_close);

    toast_notif_close.onclick = function (e) {
      create_toast_notif_dialog.remove();

    }
    setTimeout(() => {
      for (let i = 0; i < toast_notif_dialog.length; i++) {
        if (toast_notif_dialog[i].getAttribute("id") == id) {
          toast_notif_dialog[i].remove();
          break;
        }
      }
    }, 5000);
  }

  /* -------------------- newsletter */
  newsletter() {
    let form_data = new FormData(document.getElementById('newsletter_form'));
    form_data.append('newsletter', 'newsletter');
    return fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
    }).then(function (response) {
      return response.json();
    }).then(function (response_data) {
      console.log(response_data);
      if (response_data.success) {
        new Notification().create_notification(response_data.success, "success");
        document.getElementById('newsletter_email').value = "";
      } else if (response_data.newsletter_email_error) {
        new Notification().create_notification(response_data.newsletter_email_error, "error");
        document.getElementById("newsletter_email").focus();
      } else if (response_data.error) {
        new Notification().create_notification(response_data.error, 'error');
      }
    });
  }

  /* -------------------- contact-us.php */
  send_email_message() {
    document.getElementById('submit').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    document.getElementById('submit').disabled = true;
    var form_data = new FormData(document.getElementById('contact_form'));
    form_data.append('send_email_message', 'send_email_message');
    return fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
    }).then(function (response) {
      return response.json();
    }).then(function (response_data) {
      console.log(response_data);
      document.getElementById('submit').innerHTML = 'Submit';
      document.getElementById('submit').disabled = false;
      if (response_data.success) {
        new Notification().create_notification(response_data.success, "success");
        document.getElementById('name').value = "";
        document.getElementById('email').value = "";
        document.getElementById('subject').value = "";
        document.getElementById('message').value = "";
      } else if (response_data.error) {
        new Notification().create_notification(response_data.error, "error");
      }
      new Notification().show_error(response_data.name_error, 'name_error');
      new Notification().show_error(response_data.email_error, 'email_error');
      new Notification().show_error(response_data.subject_error, 'subject_error');
      new Notification().show_error(response_data.message_error, 'message_error');

    });
  }

  show_error(error, element) {
    console.log(element.replace('_error', ''));
    error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';
    error ? document.getElementById(element.replace('_error', '')).style.border = "red solid 1px" : document.getElementById(element.replace('_error', '')).style.border = "none";

  }
}