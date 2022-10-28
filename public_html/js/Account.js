

class Account {


    toggle_password(passwordToggler, passwordField) {
        document.getElementById(passwordField).setAttribute('type', (document.getElementById(passwordField).getAttribute('type') === 'password') ? 'text' : 'password');
        document.getElementById(passwordToggler).classList.toggle('fa-eye');
        document.getElementById(passwordToggler).classList.toggle('fa-eye-slash');
    }


    verify_password(password) {
        let caseRequirments = /^(?=.*[a-z])(?=.*[A-Z])/;
        let specialRequirments = /(?=.*[@$!%*?&])/;
        let numberRequirments = /(?=.*\d)/;
        let lengthRequirments = 9;
 /*  document.querySelectorAll(".passwordRequirements span").forEach( function (item){
          item.style.opacity= 1;
      }); */
      /* (password.length > lengthRequirments) ? console.log("length1"): console.log("length2");
      (password.match(caseRequirments)) ? console.log("case1"): console.log("case2");
      (password.match(specialRequirments)) ? console.log("special1"): console.log("special2");
      (password.match(numberRequirments)) ? console.log("number1"): console.log("number2"); */
      (password.length > lengthRequirments) ? document.getElementById("length").innerHTML = "&#x2714": document.getElementById("length").innerHTML = "&#x2716";
      (password.match(caseRequirments)) ? document.getElementById("case").innerHTML = "&#x2714": document.getElementById("case").innerHTML = "&#x2716";
      (password.match(specialRequirments)) ? document.getElementById("special").innerHTML = "&#x2714": document.getElementById("special").innerHTML = "&#x2716";
      (password.match(numberRequirments)) ? document.getElementById("number").innerHTML = "&#x2714": document.getElementById("number").innerHTML = "&#x2716";
      /* registerButtonState(password); */

    }

login() {

        function show_error(error, element) {
            error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';

        }

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

            if (response_data.success) {

                console.log("response_data");
                document.getElementById('success_message').innerHTML = response_data.success;

            } else if (response_data.error) {

                document.getElementById('error_message').innerHTML = response_data.error;
            } else {

                show_error(response_data.user_identifier_error, 'user_identifier_error');
               
                show_error(response_data.password_error, 'password_error');
               

            }
        });
    }
    register() {

        function show_error(error, element) {
            error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';

        }

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

                show_error(response_data.firstname_error, 'firstname_error');
                show_error(response_data.lastname_error, 'lastname_error');
                show_error(response_data.username_error, 'username_error');
                show_error(response_data.email_error, 'email_error');
                show_error(response_data.contact_error, 'contact_error');
                show_error(response_data.password_error, 'password_error');
                show_error(response_data.retype_password_error, 'retype_password_error');
                show_error(response_data.region_error, 'region_error');
                show_error(response_data.province_error, 'province_error');
                show_error(response_data.municipality_error, 'municipality_error');
                show_error(response_data.barangay_error, 'barangay_error');
                show_error(response_data.street_error, 'street_error');

            }
        });
    }

    forgot_password() {
        function show_error(error, element) {
            error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';

        }

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

                show_error(response_data.user_identifier_error, 'user_identifier_error');
              

            }
        });
    }

    new_password(url_code) {

        function show_error(error, element) {
            error ? document.getElementById(element).innerHTML = error : document.getElementById(element).innerHTML = '';

        }

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
                /* header('Location: login'); */
            } else if (response_data.error) {

                document.getElementById('error_message').innerHTML = response_data.error;
            } else {

               
                show_error(response_data.password_error, 'password_error');
                show_error(response_data.retype_password_error, 'retype_password_error');
                
            }
        });
    }

    

}