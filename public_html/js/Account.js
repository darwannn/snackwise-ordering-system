class Account {

    fetch_image;
    constructor() {
        /* fetch_image = ""; */
    }
    /* toggles input field type attribute value to text or password */
    toggle_password(passwordToggler, passwordField) {
        document.getElementById(passwordField).setAttribute('type', (document.getElementById(passwordField).getAttribute('type') === 'password') ? 'text' : 'password');
        document.getElementById(passwordToggler).classList.toggle('fa-eye');
        document.getElementById(passwordToggler).classList.toggle('fa-eye-slash');
    }

    /* display a checkmark if the specific password requirement has been met, otherwise it will display an x */
    verify_password(password) {
        let caseRequirments = /^(?=.*[a-z])(?=.*[A-Z])/;
        let specialRequirments = /(?=.*[@$!%*?&])/;
        let numberRequirments = /(?=.*\d)/;
        let lengthRequirments = 9;
        (password.length > lengthRequirments) ? document.getElementById("length").innerHTML = "&#x2714": document.getElementById("length").innerHTML = "&#x2716";
        (password.match(caseRequirments)) ? document.getElementById("case").innerHTML = "&#x2714": document.getElementById("case").innerHTML = "&#x2716";
        (password.match(specialRequirments)) ? document.getElementById("special").innerHTML = "&#x2714": document.getElementById("special").innerHTML = "&#x2716";
        (password.match(numberRequirments)) ? document.getElementById("number").innerHTML = "&#x2714": document.getElementById("number").innerHTML = "&#x2716";
    }

    /* login */
    login() {
        /* disables the button and changes its content to a loading animation so the user can not click while the server is processing */

        document.getElementById('login').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById('login').disabled = true;
        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('login', 'login');
        fetch('../php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            document.getElementById('login').innerHTML = "login";
            document.getElementById('login').disabled = false;
            /* displays the message returned */
            if (response_data.success) {
                console.log("response_data");
                document.getElementById('success_message').innerHTML = response_data.success;
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().show_error(response_data.user_identifier_error, 'user_identifier_error');
                new Account().show_error(response_data.password_error, 'password_error');
            }
        });
    }

    /* register */
    register() {
        document.getElementById('register').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById('register').disabled = true;
        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('register', 'register');
        fetch('../php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
  
            document.getElementById('register').innerHTML = "Register";
            document.getElementById('register').disabled = false;
            if (response_data.success) {
                console.log("response_data");
                document.getElementById('success_message').innerHTML = response_data.success;
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().show_error(response_data.firstname_error, 'firstname_error');
                new Account().show_error(response_data.lastname_error, 'lastname_error');
                new Account().show_error(response_data.username_error, 'username_error');
                new Account().show_error(response_data.email_error, 'email_error');
                new Account().show_error(response_data.contact_error, 'contact_error');
                new Account().show_error(response_data.region_error, 'region_error');
                new Account().show_error(response_data.province_error, 'province_error');
                new Account().show_error(response_data.municipality_error, 'municipality_error');
                new Account().show_error(response_data.barangay_error, 'barangay_error');
                new Account().show_error(response_data.street_error, 'street_error');
                new Account().show_error(response_data.password_error, 'password_error');
                new Account().show_error(response_data.retype_password_error, 'retype_password_error');
            }
        });
    }

    /* forgot password */
    forgot_password() {
        document.getElementById('forgot_password').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById('forgot_password').disabled = true;
        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('forgot_password', 'forgot_password');
        fetch('../php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            document.getElementById('forgot_password').innerHTML = "Register";
            document.getElementById('forgot_password').disabled = false;
            if (response_data.success) {
                console.log("response_data");
                document.getElementById('success_message').innerHTML = response_data.success;
                document.getElementById('user_identifier_error').innerHTML = "";
                /* window.location.href = "error.php" */
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            } else {
                new Account().show_error(response_data.user_identifier_error, 'user_identifier_error');
            }
        });
    }

    /* new-password */
    new_password(url_code) {
        document.getElementById('new_password').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById('new_password').disabled = true;

        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('new_password', 'new_password');
        fetch(`../php/controller/c_account.php?code=${url_code}`, {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            document.getElementById('new_password').innerHTML = "Register";
            document.getElementById('new_password').disabled = false;
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


    /* -------------------- update user profile */
    update(user_id) {
        console.log("Dsadasd");
        document.getElementById('update').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById('update').disabled = true;

        var form_data = new FormData(document.getElementById('account_form'));
        form_data.append('user_id', user_id);
        form_data.append('update', 'update');

        fetch('php/controller/c_account.php', {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            document.getElementById('update').innerHTML = "update";
            document.getElementById('update').disabled = false;
            if (response_data.success) {
                console.log("response_data");
                document.getElementById('success_message').innerHTML = response_data.success;
            /*     document.getElementById('image').value = "";
                new Account().document.getElementById('lastname').innerHTML = "";
                new Account().document.getElementById('username').innerHTML = "";
                new Account().document.getElementById('email').innerHTML = "";
                new Account().document.getElementById('contact').innerHTML = "";
                new Account().document.getElementById('password').innerHTML = "";
                new Account().document.getElementById('retype_password').innerHTML = "";
                new Account().document.getElementById('region').innerHTML = "";
                new Account().document.getElementById('province').value = "";
                new Account().document.getElementById('municipality').value = "";
                new Account().document.getElementById('barangay').value = "";
                new Account().document.getElementById('street').innerHTML = ""; */
            } else if (response_data.error) {
                document.getElementById('error_message').innerHTML = response_data.error;
            } 

                new Account().show_error(response_data.firstname_error, 'firstname_error');
                new Account().show_error(response_data.lastname_error, 'lastname_error');
                new Account().show_error(response_data.username_error, 'username_error');
                new Account().show_error(response_data.email_error, 'email_error');
                new Account().show_error(response_data.contact_error, 'contact_error');
                new Account().show_error(response_data.password_error, 'password_error');
                new Account().show_error(response_data.retype_password_error, 'retype_password_error');
                new Account().show_error(response_data.region_error, 'region_error');
                new Account().show_error(response_data.province_error, 'province_error');
                new Account().show_error(response_data.municipality_error, 'municipality_error');
                new Account().show_error(response_data.barangay_error, 'barangay_error');
                new Account().show_error(response_data.street_error, 'street_error');
            
        });
    }

    /* fetch user information */
    fetch(user_id) {
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


            this.fetch_image = profile_picture;
            return profile_picture;
        });
    }

    /*  */
    password_requirment() {
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

    delete_account(user_id) {
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

    change_password(user_id) {
        document.getElementById('change_password').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        document.getElementById('change_password').disabled = true;

        var form_data = new FormData(document.getElementById('new_password_form'));
        form_data.append('change_password', 'change_password');
        form_data.append('user_id', user_id);
        fetch(`php/controller/c_account.php`, {
            method: "POST",
            body: form_data
        }).then(function (response) {
            return response.json();
        }).then(function (response_data) {
            console.log(response_data);
            document.getElementById('change_password').innerHTML = "change password";
            document.getElementById('change_password').disabled = false;
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



    match_password(user_id, type) {
        if (type == 'change') {
            document.getElementById('match_password').innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            document.getElementById('match_password').disabled = true;
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
                document.getElementById('match_password').innerHTML = "Continue";
                document.getElementById('match_password').disabled = false;
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

    get_image() {
        return this.fetch_image;
    }

    show_error(error, element) {
        error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';
    }

}