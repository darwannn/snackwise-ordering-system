<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Snackwise</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/register.css">

</head>

<body>

    <div class="parent-container">

        <nav class="navbar navbar-light navbar-expand-md bg-light">
            <div class="container">
                <a href="index.php" class="navbar-brand">
                    <img src="./img/penguin.png" alt="Penguin Logo" height="58" width="52">
                    SNACKWISE
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link active">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="menu.php" class="nav-link">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a href="aboutus.php" class="nav-link">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="contactus.php" class="nav-link">Contact Us</a>
                        </li>
                    </ul>
                    <form action="#" class="form-inline">
                        <!-- 
                            NOTE: IF THE USER IS SIGNED IN, The sign-up button should be replaced by profile btn.
                        -->
                        <!-- TODO: Insert user profile button here.  -->
                        <a name="sign-up-btn" id="" class="btn btn-primary" href="register.php" role="button">Sign Up</a>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container bg-light p-5 form-container">
            <form action="">
                <div class="row">
                    <div class="col">
                        <h3>Sign Up</h3>
                    </div>
                </div>
                <div class="row">
                        <span>Personal Information</span>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12 form-group">
                        <input type="text" class="form-control m-2" name="firstName" id="" placeholder="First Name">
                    </div>
                    <div class="col-md-6 col-12 form-group">
                        <input type="text" class="form-control m-2" name="lastName" id="" placeholder="Last Name">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="number" class="form-control m-2" name="contactNumber" id="" placeholder="Contact Number">
                    </div>
                </div>
                <div class="row">
                    <span>Address Information</span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control m-2" name="street" id="" placeholder="House Number / Street / Building No.">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-6">
                        <select class="form-select form-select-md m-2" name="" id="">
                            <option selected>Region</option>
                            <option value="">I</option>
                            <option value="">II</option>
                            <option value="">III</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-6">
                        <select class="form-select form-select-md m-2" name="" id="">
                            <option selected>Province</option>
                            <option value="">Bulacan</option>
                            <option value="">Cavite</option>
                            <option value="">Pampanga</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-6">
                        <select class="form-select form-select-md m-2" name="" id="">
                            <option selected>City</option>
                            <option value="">Malolos</option>
                            <option value="">Guiguinto</option>
                            <option value="">Balagtas</option>
                        </select>
                    </div>
                    <div class="col-md-12 col-6">
                        <select class="form-select form-select-md m-2" name="" id="">
                            <option selected>Barangay</option>
                            <option value="">Barangay 1</option>
                            <option value="">Barangay 2</option>
                            <option value="">Barangay 3</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <span>Account Information</span>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <input type="email" class="form-control m-2" id="" placeholder="Email">
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 form-group">
                        <input type="password" class="form-control m-2" name="password" id="" placeholder="Password">
                    </div>
                    <div class="col-12 col-md-6 form-group">
                        <input type="password" name="confirm_password" id="" class="form-control m-2" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="text-end">Already have an account? <a href="login.php">Sign In</a></p>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-md-2 col-3">
                        <a href="index.html">Cancel</a>
                    </div>
                    <div class="col-md-2 col-3">
                       <button type="button" class="btn btn-primary">Register</button> 
                    </div>

                </div>
            </form>

        </div>

    </div>


    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>