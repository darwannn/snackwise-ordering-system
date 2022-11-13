<?php 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SL Visuals</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
</head>

<body>

    <form id="account_form" method="POST">
 
            <span id="success_message"></span>
        <span id="error_message"></span>


            <div class="">
            <label for="user_identifier">user_identifier Address</label>
            <input type="email" class="user_identifier" name="user_identifier" id="user_identifier" placeholder="user_identifier " value=""
                autocomplete="off">
            <span class="" id="user_identifier_error"></span>
        </div>
        <button type="button" id="forgot_password" class=""> Forgot Password</button>
    </form>

       
   <script src="../js/Account.js" ></script>

   <script>
let account = new Account();

    document.getElementById("forgot_password").onclick = function () {
         
            account.forgot_password();
        }






    </script>
</body>

</html>