<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Snackwise</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
    <style>
        .address_option {
            display: none;
            opacity: 0;
        }
    </style>
</head>

<body>

<!-- 
Pwede mo tanggalin yung mga tabel na tags.
 -->
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
                        <a name="sign-up-btn" id="" class="btn btn-primary" href="register.php" role="button">Sign
                            Up</a>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container bg-light p-5 form-container">
            <form id="account_form" method="POST">
                <div class="row">
                    <div class="col">
                        <h3>Sign Up</h3>
                    </div>
                </div>
                <div class="">
                    <span id="success_message"></span>
                    <span id="error_message"></span>
                </div>
                <div class="row">
                    <span>Personal Information</span>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12 form-group">

                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control m-2" name="firstname" id="firstname"
                            placeholder="First Name" value="" autocomplete="off">
                        <span class="" id="firstname_error"></span>


                    </div>
                    <div class="col-md-6 col-12 form-group">
                        <label for="lastname">Last Name </label>
                        <input type="text" class="form-control m-2" name="lastname" id="lastname"
                            placeholder="Last Name" value="" autocomplete="off">
                        <span class="" id="lastname_error"></span>

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="contact">Contact Number</label>
                        <input type="text" class="form-control m-2" name="contact" id="contact"
                            placeholder="contact Number" value="" autocomplete="off">
                        <span class="" id="contact_error"></span>
                    </div>
                </div>

                <div class="row">
                    <span>Address Information</span>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="street" for="">Street</label>
                        <input type="text" class="form-control m-2" name="street" id="street"
                            placeholder="House Number / Street / Building No.">
                        <span class="" id="street_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-6">

                        <label for="">Region</label>
                        <select name="region" class="form-select form-select-md m-2" id="region">
                            <option class="address_option" value="none">Select an Option</option>
                        </select>
                        <span class="" id="region_error"></span>

                    </div>
                    <div class="col-md-4 col-6">
                        <label for="">Province</label>
                        <select name="province" class="form-select form-select-md m-2" id="province">
                            <option class="address_option" value="none">Select an Option</option>
                        </select>
                        <span class="" id="province_error"></span>
                    </div>
                    <div class="col-md-4 col-6">
                        <label for="">Municipality</label>
                        <select name="municipality" class="form-select form-select-md m-2" id="municipality">
                            <option class="address_option" value="none">Select an Option</option>
                        </select>
                        <span class="" id="municipality_error"></span>

                    </div>
                    <div class="col-md-12 col-6">

                        <label for="">Barangay</label>
                        <select name="barangay" class="form-select form-select-md m-2" id="barangay">
                            <option class="address_option" value="none">Select an Option</option>
                        </select>
                        <span class="" id="barangay_error"></span>
                    </div>
                </div>
                <div class="row">
                    <span>Account Information</span>
                </div>

                <div class="row">
                    <div class="col form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control m-2" name="username" id="username"
                            placeholder="Username " value="" autocomplete="off">
                        <span class="" id="username_error"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col form-group">
                        <label for="email">Email Address</label>
                        <input type="text" class="form-control m-2" name="email" id="email" placeholder="Email Address"
                            value="" autocomplete="off">
                        <span class="" id="email_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control m-2" name="password" id="password"
                            placeholder="Password" value="" onkeyup="new Account().verify_password(this.value);"
                            autocomplete="off">
                        <i class="fa-solid fa-eye-slash" id="password_toggler" for="password"
                            onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                        <span class="" id="password_error"></span>
                        <div class="password_requirements">
                            <h6><span class="length " id="length">&#x2716;</span>Length</h6>
                            <h6><span class="case " id="case">&#x2716;</span>Uppercase</h6>
                            <h6><span class="number " id="number">&#x2716;</span>number</h6>
                            <h6><span class="special " id="special">&#x2716;</span>special</h6>
                        </div>

                    </div>
                    <div class="col-12 col-md-6 form-group">
                        <label for="retype_password">Retype Password</label>
                        <input type="password" class="form-control m-2" name="retype_password" id="retype_password"
                            placeholder="Retype Password" value="" autocomplete="off">

                        <i class="fa-solid fa-eye-slash" id="retype_password_toggler" for="retype_password"
                            onclick="new Account().toggle_password(this.id, this.getAttribute('for'))"></i>
                        <span class="" id="retype_password_error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="text-end">Already have an account? <a href="../login.php">Sign In</a></p>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-md-2 col-3">
                        <a href="index.html">Cancel</a>
                    </div>
                    <div class="col-md-2 col-3">

                        <button type="button" id="register" class="btn btn-primary"> Register</button>
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
<script src="../js/Address.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        let account = new Account();

        document.getElementById("register").onclick = function () {

            account.register();
        }


        new Address().addressSelector("region", "province", "municipality", "barangay");

    });
</script>
</body>

</html>