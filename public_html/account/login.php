<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Snackwise</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/login.css">

</head>

<body>

    <div class="parent-container">

        <nav class="navbar navbar-light navbar-expand-md bg-light">
            <div class="container">
                <a href="../index.php" class="navbar-brand">
                    <img src="../img/penguin.png" alt="Penguin Logo" height="58" width="52">
                    SNACKWISE
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link active">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="../menu.php" class="nav-link">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a href="../aboutus.php" class="nav-link">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="../contactus.php" class="nav-link">Contact Us</a>
                        </li>
                    </ul>
                    <form action="#" class="form-inline">
                        <!-- 
                            NOTE: IF THE USER IS SIGNED IN, The sign-up button should be replaced by profile btn.
                        -->
                        <!-- TODO: Insert user profile button here.  -->
                        <a name="sign-up-btn" id="" class="btn btn-primary" href="../register.php" role="button">Sign
                            Up</a>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container bg-light form-container">
            <form id="account_form" method="POST">
                <div class="row">
                    <h3>Sign In</h3>
                    <span>Enter your account details to continue</span>
                </div>
                <div class="">
                    <span id="success_message">
                        <?php 
                    if(isset($_SESSION['activate_success'])){
                echo $_SESSION['activate_success']; 
                    unset($_SESSION["activate_success"]);
                    }?>
                    </span>

                    <span id="error_message"></span>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="user_identifier">Username / Email Address / Phone Number</label>
                        <input type="text" class="form-control m-2" name="user_identifier" id="user_identifier"
                            placeholder="Username / Email Address / Phone Number" value="" autocomplete="off">
                        <span class="" id="user_identifier_error"></span>

                    </div>
                    <div class="col-12">
                        <label for="password">Password</label>
                        <input type="password" class="form-control m-2" name="password" id="password"
                            placeholder="Password" value="" onkeydown="/* verifyPassword(this.value) */"
                            autocomplete="off">
                        <i class="fa-solid fa-eye-slash" id="password_toggler" for="password"
                            onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                        <span class="" id="password_error"></span>

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="#" class="">Forgot Password?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="d-grid gap-2">
                        <button type="button" id="login" class="btn btn-primary"> Sign In</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="d-grid gap-2">
                            <button type="button" name="" id="" class="btn btn-warning">Create an Account</button>

                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>


    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="../js/Account.js"></script>

    <script>
        let account = new Account();
        document.getElementById("login").onclick = function () {

            account.login();
        }
    </script>

</body>

</html>