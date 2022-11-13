class Notification {

  notification() {
    new Notification().notification_count();
    new Notification().display_notification();
    new Notification().display_toast_notif();
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
    });
  }

/* displays a real time toast_notif notification on customers screen */
  display_toast_notif() {
    let pusher = new Pusher('56c2bebb33825a275ca8', {
      cluster: 'ap1'
    });

    let channel = pusher.subscribe('snackwise');
    channel.bind('notif', function (data) {
      let user_id = data['notification']['user_id'];
      let message = data['notification']['message'];
      console.log(user_id);
      console.log(message);
      new Audio('sound/ting.mp3').play();
      new Notification().notification_count();
      new Notification().display_notification();
      new Notification().create_notification("response_data.error", "neutral");
    });
  }

  /*  count all the unread notification of a customer */
  notification_count() {
    document.getElementById("notification_list").style.display = "none";

    let form_data = new FormData();
    form_data.append('notification_count', 'notification_count');
    fetch('php/controller/c_notification.php', {
      method: "POST",
      body: form_data
    }).then(function (response) {
      return response.json();
    }).then(function (response_data) {
      console.log(response_data);
      document.getElementById("notification_count").innerHTML = response_data.notification_count;
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
      console.log(response_data);
      if (response_data.data) {
        response_data.data.map(function (notif) {
          notification_list += `
              <div>
              <div class="${notif.status}">${notif.message}</div>
              </div>
              `;
        });
      }
      document.getElementById("notification_list").innerHTML = notification_list;
    });
  }


  /* create  and display a notification */
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

    create_toast_notif_dialog.onclick = function (e) {
      e.target.parentElement.remove();
    }
    toast_notif_close.onclick = function (e) {
      e.target.parentElement.parentElement.remove();
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


  send_email_message() {
    document.getElementById('submit').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    document.getElementById('submit').disabled = true;
    var fetch_account_data = new FormData(document.getElementById('contact_form'));
    fetch_account_data.append('send_email_message', 'send_email_message');
    return fetch('php/controller/c_notification.php', {
        method: "POST",
        body: fetch_account_data
    }).then(function (response) {
        return response.json();
    }).then(function (response_data) {
      console.log(response_data);
      document.getElementById('submit').innerHTML = 'Submit';
      document.getElementById('submit').disabled = false;
       if(response_data.success){
        new Notification().create_notification(response_data.success, "success");
    
       }  else if(response_data.error){
        new Notification().create_notification(response_data.error, "error");
       } 
      
     
      new Notification().show_error(response_data.name_error, 'name_error');
      new Notification().show_error(response_data.email_error, 'email_error');
      new Notification().show_error(response_data.subject_error, 'subject_error');
      new Notification().show_error(response_data.message_error, 'message_error');
  
    });
}
show_error(error, element) {
  error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';
}

}