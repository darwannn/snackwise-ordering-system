class Account {

    /* fetch_image; */
 /*    button_text = ""; */
    constructor() {
        /* fetch_image = ""; */
        this.button_text = "";
    }
    /* toggles input field type attribute value to text or password */
    toggle_password(passwordToggler, passwordField) {
        document.getElementById(passwordField).setAttribute('type', (document.getElementById(passwordField).getAttribute('type') === 'password') ? 'text' : 'password');
        document.getElementById(passwordToggler).classList.toggle('fa-eye');
        document.getElementById(passwordToggler).classList.toggle('fa-eye-slash');
    }

    /* display a checkmark if the specific password requirement has been met, otherwise it will display an x */
    verify_password (password) {
        document.querySelector(".length").style.opacity = 1;
        document.querySelector(".case").style.opacity = 1;
        document.querySelector(".special").style.opacity = 1;
        document.querySelector(".number").style.opacity = 1;
        let caseRequirments = /^(?=.*[a-z])(?=.*[A-Z])/;
        let specialRequirments = /(?=.*[!@#$%^&,*.])/;
       /*  let specialRequirments = /(?=.*[@$!%*?&])/; */
        let numberRequirments = /(?=.*\d)/;
        (password.length >= 8 && password.length <= 16) ? document.getElementById("length").innerHTML = "&#x2714": document.getElementById("length").innerHTML = "&#x2716";
       
        (password.match(caseRequirments)) ? document.getElementById("case").innerHTML = "&#x2714": document.getElementById("case").innerHTML = "&#x2716";
        (password.match(specialRequirments)) ? document.getElementById("special").innerHTML = "&#x2714": document.getElementById("special").innerHTML = "&#x2716";
        (password.match(numberRequirments)) ? document.getElementById("number").innerHTML = "&#x2714": document.getElementById("number").innerHTML = "&#x2716";
    }

    /* login */
    login () {
       
        let button_value = new Account().get_button_value("login");
        new Account().button_loading("login", "loading","");
      
     
        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('login', 'login');
        fetch('../php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
    
            console.log(response_data);
            new Account().button_loading("login", "",button_value);
          
            /* displays the message returned */
            if (response_data.success) {

                document.getElementById('success_message').innerHTML = "";
window.location.href = "../index.php";
            } else if (response_data.validate) {
                document.getElementById('success_message').innerHTML = "";
                document.getElementById('error_message').innerHTML = response_data.validate;
            }else if (response_data.error) {
                document.getElementById('success_message').innerHTML = "";
                document.getElementById('error_message').innerHTML = "";
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }
            new Account().show_error(response_data.user_identifier_error, 'user_identifier_error');
            new Account().show_error(response_data.password_error, 'password_error');
        });
    }

    /* register */
    register () {
    
        let button_value = new Account().get_button_value("register");
        new Account().button_loading("register", "loading","");

        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('register', 'register');
        fetch('../php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
  
  
            new Account().button_loading("register", "",button_value);

            if (response_data.success) {
                
                document.getElementById('firstname').value = "";
                document.getElementById('lastname').value = "";
                document.getElementById('username').value = "";
                document.getElementById('email').value = "";
                document.getElementById('contact').value = "";
                /*  document.getElementById('region').value = "";
                document.getElementById('province').value = "";
                document.getElementById('municipality').value = "";
                document.getElementById('barangay').value = "";
                document.getElementById('street').value = ""; */
                document.getElementById('password').value = "";
                document.getElementById('retype_password').value = "";
                document.getElementById('success_message').innerHTML = response_data.success;
                console.log(response_data);

                
                new Account().scroll_to("top");
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
                new Account().scroll_to("top");
            } else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }
                new Account().show_error(response_data.firstname_error, 'firstname_error');
                new Account().show_error(response_data.lastname_error, 'lastname_error');
                new Account().show_error(response_data.username_error, 'username_error');
                new Account().show_error(response_data.email_error, 'email_error');
                new Account().show_error(response_data.contact_error, 'contact_error');
               /*  new Account().show_error(response_data.region_error, 'region_error');
                new Account().show_error(response_data.province_error, 'province_error');
                new Account().show_error(response_data.municipality_error, 'municipality_error');
                new Account().show_error(response_data.barangay_error, 'barangay_error');
                new Account().show_error(response_data.street_error, 'street_error'); */
                new Account().show_error(response_data.password_error, 'password_error');
                new Account().show_error(response_data.retype_password_error, 'retype_password_error');

        
        });
    }

    /* forgot password */
    forgot_password () {

        let button_value = new Account().get_button_value("forgot_password");
        new Account().button_loading("forgot_password", "loading","");

        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('forgot_password', 'forgot_password');
        fetch('../php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            new Account().button_loading("forgot_password", "",button_value);
            if (response_data.success) {
                console.log("response_data");
                document.getElementById('success_message').innerHTML = response_data.success;
                document.getElementById('user_identifier').value = "";
                /* window.location.href = "error.php" */
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }
            new Account().show_error(response_data.user_identifier_error, 'user_identifier_error');
        });
    }

    /* new-password */
    new_password (url_code) {
           let button_value = new Account().get_button_value("new_password");
        new Account().button_loading("new_password", "loading","");


        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('new_password', 'new_password');
        fetch(`../php/controller/c_account.php?code=${url_code}`, {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            new Account().button_loading("new_password", "",button_value);
            if (response_data.success) {
  
                /* document.getElementById('success_message').innerHTML = response_data.success; */
                window.location.href = "login.php";
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }
            new Account().show_error(response_data.password_error, 'password_error');
            new Account().show_error(response_data.retype_password_error, 'retype_password_error');
        });
    }


    /* -------------------- update user profile */
    update (user_id)  {


        let button_value = new Account().get_button_value("update");
        new Account().button_loading("update", "loading","");

        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('user_id', user_id);
        form_data.append('update', 'update');

        fetch('php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
       

            new Account().button_loading("update", "",button_value);

            if (response_data.success) {
                console.log("response_data");
                document.getElementById('success_message').innerHTML = response_data.success;

            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            }  else {
                new Account().scroll_to(Object.keys(response_data)[0]);
            }

                new Account().show_error(response_data.firstname_error, 'firstname_error');
                new Account().show_error(response_data.lastname_error, 'lastname_error');
                new Account().show_error(response_data.username_error, 'username_error');
                new Account().show_error(response_data.email_error, 'email_error');
                new Account().show_error(response_data.contact_error, 'contact_error');
                new Account().show_error(response_data.password_error, 'password_error');
                new Account().show_error(response_data.retype_password_error, 'retype_password_error');
      /*           new Account().show_error(response_data.region_error, 'region_error');
                new Account().show_error(response_data.province_error, 'province_error');
                new Account().show_error(response_data.municipality_error, 'municipality_error');
                new Account().show_error(response_data.barangay_error, 'barangay_error');
                new Account().show_error(response_data.street_error, 'street_error'); */
            
        });
    }

    /* fetch user information */
    fetch  (user_id)  {
        var fetch_account_data = new FormData();
        fetch_account_data.append('fetch_account', 'fetch_account');
        fetch_account_data.append('user_id', user_id);
        return fetch('php/controller/c_account.php', {
            method: "POST",
            body: fetch_account_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            let user = response_data.data[0];
            console.log(user);
            document.getElementById("firstname").value = `${user.firstname}`;
            document.getElementById("lastname").value = `${user.lastname}`;
            document.getElementById("email").value = `${user.email}`;
            document.getElementById("contact").value = `${user.contact}`;

            let profile_picture = user.image;


           /*  this.fetch_image = profile_picture; */
            return profile_picture;
        });
    }

    /*  */
    password_requirment  () {
        var form_data = new FormData(document.getElementById('new_password_form'));
        form_data.append('password_requirment', 'password_requirment');

        fetch(`php/controller/c_account.php`, {
            method: "POST",
            body: form_data
        }).then(function (response) {

            return response.json();

        }).then(function (response_data) {

            console.log(response_data);

            if (response_data.success) {
                document.getElementById("modal").style.display = "block";
            } else if (response_data.error) {
                new Account().show_error(response_data.password_error, 'password_error');
                /*  new Account().show_error(response_data.current_password_error, 'current_password_error'); */
                new Account().show_error(response_data.retype_password_error, 'retype_password_error');
            }
            /* window.location.href = "account/login.php" */
        });
    }

    delete_account  (user_id) {
        var form_data = new FormData();
        form_data.append('delete_account', 'delete_account');
        form_data.append('user_id', user_id);

        fetch(`php/controller/c_account.php`, {
            method: "POST",
            body: form_data
        }).then(function (response) {

            return response.json();

        }).then(function (response_data) {
            console.log(response_data);
            /* window.location.href = "account/login.php" */
        });
    }

    change_password  (user_id) {

        let button_value = new Account().get_button_value("change_password");
        new Account().button_loading("change_password", "loading","");

        var form_data = new FormData(document.getElementById('new_password_form'));
        form_data.append('change_password', 'change_password');
        form_data.append('user_id', user_id);
        fetch(`php/controller/c_account.php`, {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
        
            new Account().button_loading("change_password", "",button_value);
            if (response_data.success) {
                console.log("response_data");
                document.getElementById('success_message').innerHTML = response_data.success;
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().show_error(response_data.password_error, 'password_error');
                new Account().show_error(response_data.retype_password_error, 'retype_password_error');
            }
        });

    }



    match_password (user_id, type) {
        if (type == 'change') {
            
            let button_value = new Account().get_button_value("match_password");
            new Account().button_loading("match_password", "loading","");
    
        }
        var form_data = new FormData(document.getElementById('match_password_form'));
        form_data.append('match_password', 'match_password');
        form_data.append('type', type);
        form_data.append('user_id', user_id);
        fetch(`php/controller/c_account.php`, {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            console.log(type);
            if (type == 'change') {
             
                new Account().button_loading("match_password", "",button_value);
            }
            if (response_data.error) {
                if (type == 'change') {
                    new Account().show_error(response_data.current_password_error, 'current_password_error');
                } else if (type == 'delete') {
                    document.getElementById('success_message').innerHTML = response_data.success;
                }
            } else if (response_data.success) {
                if (type == 'change') {
                    new Account().change_password(user_id);
                } else if (type == 'delete') {
                    new Account().delete_account(user_id);
                }
            }
        });

    }

    /* get_image() {
        return this.fetch_image;
    } */

    show_error(error, element) {
        console.log(element.replace('_error',''));
        error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';
        error ? document.getElementById(element.replace('_error','')).style.border = "red solid 1px" : document.getElementById(element.replace('_error','')).style.border = "none";
    
    }

     /* disables the button and changes its content to a loading animation so the user can not click while the server is processing */
    button_loading(element, type,text) {
        if(type == "loading") {
        document.getElementById(element).innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById(element).disabled = true;
        } else {
            
            document.getElementById(element).innerHTML =  text;
            document.getElementById(element).disabled = false;
        }
    }

    
    /* gets button text */
    get_button_value(element) {
        return document.getElementById(element).innerHTML;
    }

    /* scroll to the position of the input field with an error */
    scroll_to(element) {
        if(element == "top") {
        window.scrollTo({
            top:0,
            left:0,
            behavior:"smooth"
        });
    } else {
        window.scrollTo({
            top:(document.getElementById(element).offsetTop)-250,
            left:0,
            behavior:"smooth"
        });
    }
    }

}