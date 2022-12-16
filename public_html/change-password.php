<?php
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';

$validate = new Validate();
if ($validate->is_logged_in("customer")) {
    header('Location: account/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery-bundle.css'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>



    <!-- FONT LINKS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Poppins:ital,wght@0,300;0,600;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- FONTAWESOME -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <link rel="stylesheet" href="css/change-password.css">

    <title>Change Password | Snackwise</title>
    <link rel="stylesheet" href="css/notification.css">
</head>
<!-- palipat nalang nito -->
<style>
    /* hides ms-edge password toggler */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }

    .input_error {

        position: relative;
        top: 3px;

        font-size: 14px !important;
        color: red;
    }

    .password_requirements {
        max-height: 0;
        transition: max-height .6s ease-out;
        overflow: hidden;
        margin-left: 30px;

    }

    .password_requirements h6 {
        margin-top: -6px !important;
        font-size: 14px !important;
    }

    .password_requirements span {
        font-size: 14px !important;
    }

    .password_requirements #length_con {
        margin-top: 8px !important;
    }

    .password_requirment_active {
        max-height: 300px;
        transition: max-height .6s ease-in;
    }
</style>

<body>


    <div class="parent-container">
        <div class="form-window">
            <a href="index.php" class="snackwise-label text-decoration-none">
                <div class="brand-icon">
                    <img src="img/penguin.png" class="snackwise-icon" alt="Snackwise Logo">
                </div>
                <div class="brand-name">
                    <span class="red">SNACK<span class="yellow">WISE</span></span>
                </div>
            </a>
            <div class="back-container">
                <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Back to Home</a>
            </div>
            <div class="form-header">
                <h1>Change Password</h1>
            </div>
            <form action="POST" id="account_form">

                <div class="input-container">
                    <input type="password" class="current_password" name="current_password" id="current_password" placeholder="Retype Password" value="" autocomplete="off">
                    <i class="fa-solid fa-eye-slash toggler" id="current_password_toggler" for="current_password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                    <span class="input_error" id="current_password_error" class="text-danger"></span>
                </div>

                <span class="group-txt">Set New Password:</span>
                <div class="input-container">
                    <input type="password" class="password" name="password" id="password" placeholder="New Password" value="" onkeyup="new Account().verify_password(this.value);" autocomplete="off">
                    <i class="fa-solid fa-eye-slash toggler" id="password_toggler" for="password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                    <span class="input_error" id="password_error" class="text-danger"></span>

                    <div class="password_requirements">
                        <h6 id="length_con"><span class="length me-1" id="length">&#x2716;</span> be at least 8 characters but not more than 20</h6>
                        <h6 id="case_con"><span class="case me-1" id="case">&#x2716;</span> contain at least one uppercase and lowercase letter</h6>
                        <h6 id="number_con"><span class="number me-1" id="number">&#x2716;</span> contain at least one number</h6>
                        <h6 id="special_con"><span class="special me-1" id="special">&#x2716;</span> contain one of the following characters: @ . # $ % ^ & , *</h6>
                    </div>
                </div>

                <div class="input-container">
                    <input type="password" class="retype_password" name="retype_password" id="retype_password" placeholder="Retype New Password" value="" autocomplete="off">
                    <i class="fa-solid fa-eye-slash toggler" id="retype_password_toggler" for="retype_password" onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                    <span class="input_error" id="retype_password_error" class="text-danger"></span>
                </div>
                <button type="button" id="change_password" class="btn btn-outline-danger update-btn" onclick="new Account().change_password();"> Change Password</button>


            </form>
        </div>
    </div>


    <!-- toast_notif notification will be appended here -->
    <div class="toast_notif" id="toast_notif"></div>

    <script src="js/Notification.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/lightgallery.umd.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/thumbnail/lg-thumbnail.umd.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/zoom/lg-zoom.umd.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/video/lg-video.umd.js'></script>


    <script src="js/Account.js"></script>

</body>

<script>
    /* displays a message after an information has been successfully updated */
    <?php
    if (isset($_SESSION['activate_success'])) {
    ?>
        new Notification().create_notification("Your email address has been updated", "success");
    <?php
        unset($_SESSION["activate_success"]);
    }
    ?>
</script>

</html>