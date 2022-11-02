<?php
require_once dirname(__FILE__) . "/../php/classes/Account.php";
require_once dirname(__FILE__) . "/../php/classes/Validate.php";

$account = new Account();
$validate = new Validate();
if (!$validate->validate_code()) {
    header('error.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
</head>

<body>

    <form id="account_form" method="POST">

        <span id="success_message"></span>
        <span id="error_message"></span>


        <div class="">
            <label for="password">Password</label>
            <input type="password" class="password" name="password" id="password" placeholder="Password" value="" onkeyup="new Account().verify_password(this.value);" autocomplete="off">
            <i class="fa-solid fa-eye-slash" id="password_toggler" for="password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
            <span class="" id="password_error"></span>

            <div class="password_requirements">
                <h6><span class="length " id="length">&#x2716;</span>Length</h6>
                <h6><span class="case" id="case">&#x2716;</span>Uppercase</h6>
                <h6><span class="number" id="number">&#x2716;</span>number</h6>
                <h6><span class="special" id="special">&#x2716;</span>special</h6>
            </div>

        </div>

        <div class="">
            <label for="retype_password">Retype Password</label>
            <input type="password" class="retype_password" name="retype_password" id="retype_password" placeholder="Retype Password" value="" autocomplete="off">
            <i class="fa-solid fa-eye-slash" id="retype_password_toggler" for="retype_password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
            <span class="" id="retype_password_error"></span>
        </div>


        <button type="button" id="new_password" class=""> new_password</button>


    </form>
    <script src="../js/Account.js"></script>
    <script>
        let account = new Account();

        let url_code = '<?php echo $_GET['code '] ?>';
        document.getElementById("new_password").onclick = function() {
            console.log(url_code);
            account.new_password(url_code);
        }
    </script>
</body>

</html>