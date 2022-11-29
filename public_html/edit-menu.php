<?php
require_once dirname(__FILE__) . '/php/controller/c_menu.php';
require_once dirname(__FILE__) . '/php/classes/DbConnection.php';
require_once dirname(__FILE__) . '/php/classes/Validate.php';

$validate = new Validate();
if ($validate->is_logged_in("admin")) {
    header('Location: error.php');
}
$db = new DbConnection();
$conn = $db->connect();
$menu = new Menu();

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="css/table.css" />
    <link rel="stylesheet" type="text/css" href="css/notification.css" />


    <script src="js/Table.js" type="text/javascript"></script>

    <!-- FONT AWESOME CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- FONT AWESOME JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>

    <!-- DATE PICKER -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- BOOTSTRAP CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
        td:nth-child(2) {
            white-space: normal !important;
            width: 100px !important;
        }

        td:nth-child(3) {
            white-space: normal !important;
            width: 200px !important;
        }

        .dt-table th.dt-sorter::before,
        .dt-table th.dt-sorter::after {
            content: "";
            height: 0;
            width: 0;
            position: absolute;
            right: 5px;
            margin-top: 5px;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            opacity: 0.3;
        }

        
        .dt-table th:nth-child(1).dt-sorter::before,
        .dt-table th:nth-child(1).dt-sorter::after {
            right: 15px;
        }

        
        .dt-table th:nth-child(2).dt-sorter::before,
        .dt-table th:nth-child(2).dt-sorter::after {
            right: 22px;
        }

        
        .dt-table th:nth-child(3).dt-sorter::before,
        .dt-table th:nth-child(3).dt-sorter::after {
            right: 54px;
        }

        
        .dt-table th:nth-child(4).dt-sorter::before,
        .dt-table th:nth-child(4).dt-sorter::after {
            right: 21px;
        }

        
        .dt-table th:nth-child(5).dt-sorter::before,
        .dt-table th:nth-child(5).dt-sorter::after {
            right: 25px;
        }

        
        .dt-table th:nth-child(6).dt-sorter::before,
        .dt-table th:nth-child(6).dt-sorter::after {
            right: 25px;
        }

        
        .dt-table th:nth-child(7).dt-sorter::before,
        .dt-table th:nth-child(7).dt-sorter::after {
            right: 23px;
        }
        .dt-table th:nth-child(8).dt-sorter::before,
        .dt-table th:nth-child(8).dt-sorter::after {
            right: 23px;
        }

        .dt-table th:nth-child(9).dt-sorter::before,
        .dt-table th:nth-child(9).dt-sorter::after,
        .dt-table th:nth-child(10).dt-sorter::before,
        .dt-table th:nth-child(10).dt-sorter::after {
            display: none;
        }

        th:nth-child(9),
        th:nth-child(10) {
            pointer-events: none;
        }

        
        .input_error {
            position: relative;
           /*  top: -3px; */
            font-size: 14px;
            color: red;
        }
    </style>
    <title></title>
</head>

<body>

    <div class="container my-5">

        <span id="success_message"></span>

        <div class="card">






            <div class="card-header ">
                <h3 class="text-center">Menu</h3>

            </div>


            <div class="card-body">
                <div class="d-flex justify-content-end ">
                    <button type="button" name="add_data" id="add_data" class="btn btn-success col-lg-2 col-md-3 "> <i class="fa-solid fa-plus"></i> Add</button>
                </div>
                <table id="menu_table" class="table table-sm ">
                    <thead>
                        <tr class="">
                            <th>#</th>
                            <th>Name</th>
                            <th>Desciption</th>
                            <th>Categoty</th>
                            <th>Discount(%)</th>
                            <th>Price</th>
                            <th>Date Added</th>
                            <th>Availability</th>
                            <th>Image</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $menu->fetch_five(); ?>
                    </tbody>
                </table>


            </div>

        </div>
    </div>

    <!-- modal to add or edit an order  -->
    <div class="modal fade" id="menu_modal">
        <form method="post" id="menu_form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header ">

                        <div class="modal-title h6 fw-bold" id="modal_title">Add</div>
                        <div style="color:#A3A3A3; " id="close_menu"><i class="fa-solid fa-xmark"></i></div>
                    </div>


                    <div class="modal-body">
                        <input type="hidden" name="menu_id" id="menu_id" class="" />

                        <div class="form-group mt-2">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" />
                            <span class="input_error" id="name_error"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description" />
                            <span class="input_error" id="description_error"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="category">Category</label>
                            <select class="form-control" name="category" id="category">
                                <option value="none" style="display: none; opacity:0;">Category</option>

                                <!-- display the items from the category table as dropdown -->
                                <?php
                                $query  = $conn->prepare("SELECT * FROM category");
                                $result  =  $query->execute();
                                if ($query->rowCount() > 0) {
                                    while ($row = $query->fetch(PDO::FETCH_BOTH)) {
                                ?>
                                        <option value="<?php echo $row['category_id'] ?>"><?php echo $row['name'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <span class="form-label " id="category_error"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="discount">Discount(%)</label>
                            <input type="text" class="form-control" name="discount" id="discount" />
                            <span class="input_error" id="discount_error"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="price">Price</label>
                            <input type="text" class="form-control" name="price" id="price" />
                            <span class="input_error" id="price_error"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="date">Date</label>
                            <input type="date" class="form-control" name="date" id="date" />
                            <span class="input_error" id="date_error"></span>
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="availability">Availability</label>
                            <select class="form-select" name="availability" id="availability">
                                <option value="none" style="display: none; opacity:0;">Select</option>
                                <option value="Available" selected>Available</option>
                                <option value="Unavailable">Unavailable</option>
                            </select>
                            <span class="input_error" id="availability_error"></span>
                        </div>

                        <input type="text" name="edit_menu_image" id="edit_menu_image" style="display:none;" />

                        <input type="file" name="image" id="image" style="display:none;" />

                        <div class="form-group mt-2  mb-5" style="height: 300px;">
                            <label class="form-label" for="upload_image">Image</label>
                            <div style="width: 100%; height:100%; border:1px solid black; position:relative" id="image_container">
                                <button type="button" class="upload_image " id="upload_image" style="position:absolute; width:100%; height:100%; opacity:0; z-index:100;"></button>
                                <img class="show_menu_image" id="show_menu_image" src="" style="position:absolute; width:100%; height:100%; object-fit:contain;">
                                <!--  <div class="d-flex align-items-center justify-content-center">upload Image here</div> -->
                            </div>
                            <span class="input_error" id="image_error"></span>
                        </div>
                        <!--  <input type="hidden" name="action_menu" id="action_menu" value="Add" />
                   
                        
                        <button type="button" class="btn btn-success btn-add w-100" id="action_menu_button" value="Add">Add</button> -->

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="action_menu" id="action_menu" value="Add" />
                        <!--     <button type="button" class="btn btn-danger w-25" id="close_menu">Close</i></button> -->

                        <button type="button" class="btn btn-success btn-add w-25" id="action_menu_button" value="Add">Add</button>

                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal-backdrop fade show" id="modal_backdrop"></div>

    <!-- toast_notif notification will be appended here -->
    <div class="toast_notif" id="toast_notif"></div>
</body>

<script src="js/Menu.js"></script>
<script src="js/Notification.js"></script>

<script>
    let edit_menu = new Menu();

    /* instantiate JSTable class */
    var table = new JSTable("#menu_table", {
        serverSide: true,
        deferLoading: <?php echo $menu->count_all_data(); ?>,
        ajax: "php/controller/f_menu.php"
    });

    edit_menu.upload_image();
    edit_menu.close_menu();

    /* invoked when the user clicks the add menu button,
    it clears all the value of the input before opening the modal where staff can input menu information */
    document.getElementById('add_data').onclick = function() {

        /* gets and displays the current date to the date field */
        document.getElementById('date').flatpickr({
            minDate: "today",
            defaultDate: `${new Date().getFullYear()}-${new Date().getMonth() + 1}-${new Date().getDate()}`
        });
        edit_menu.reset_input();
        edit_menu.open_menu();
    }

    document.getElementById('close_menu').onclick = function() {
        edit_menu.close_menu();
    }

    document.getElementById('action_menu_button').onclick = function() {
        edit_menu.add_button = true;
        edit_menu.action_menu_button();
    }
</script>

</html>