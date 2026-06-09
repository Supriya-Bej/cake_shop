<?php
include("../db_connect.php");
global $conn;
include("function.php");
include("count_function.php");
session_start();

if (!isset($_SESSION['admmin_id'])) {
    header("Location:login.php");
}

$total_orders = countDetails('orders');
$total_products = countDetails('products');
$total_users = countDetails('users');
$total_revenue = count_revenue('orders');
$message_count = countDetails('contact');

$select = "SELECT * FROM `banner`";
$res = mysqli_query($conn, $select);
$banner_data = mysqli_fetch_all($res, MYSQLI_ASSOC);

if (isset($_GET['toggle_status'])) {

    $id = $_GET['toggle_status'];

    $check = "SELECT * FROM banner WHERE banner_id='$id'";
    $run_check = mysqli_query($conn, $check);
    $data = mysqli_fetch_assoc($run_check);

    if ($data['status'] == 1) {
        $status = 0;
    } else {
        $status = 1;
        $updateStatus = "UPDATE `banner` SET `status`='0' WHERE banner_id!='$id'";
        mysqli_query($conn,$updateStatus);
    }

    $update = "UPDATE banner SET status='$status' WHERE banner_id='$id'";
    mysqli_query($conn, $update);

    header("Location:dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f6f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Topbar */
        .topbar {
            background: linear-gradient(135deg, #d991a3, #b76e79);
            padding: 15px 20px;
            border-radius: 15px;
            color: white;
        }

        /* .search-box {
            border-radius: 25px;
            border: none;
            padding-left: 15px;
        } */
        .search-box {
            border-radius: 25px;
            border: none;
            padding-left: 15px;
            height: 45px;
            min-width: 250px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .badge {
            padding: 6px 8px;
        }

        /* Cards */
        .card-custom {
            border-radius: 18px;
            border: none;
            padding: 20px;
            background: white;
            transition: 0.3s;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .bg-pink {
            background: #d991a3;
        }

        .bg-blue {
            background: #5a9bd5;
        }

        .bg-green {
            background: #58c9a3;
        }

        .bg-orange {
            background: #f4a261;
        }

        /* Table */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: #d991a3;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f9f1f3;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        /* Buttons */
        .btn-main {
            background: linear-gradient(45deg, #ff4f81, #ff7a18);
            /* color: white; */
            border-radius: 10px;
        }

        .btn-main:hover {
            opacity: 0.9;
        }

        /* Banner */

        .table thead tr {
            background-color: #f8d7df;
        }

        .table thead th {
            border: none;
            padding: 18px;
            color: #8b4d5d;
            font-size: 15px;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 18px;
            border-color: #f1f1f1;
        }

        .table tbody tr:hover {
            background-color: #fff7f9;
            transition: 0.3s;
        }

        .badge {
            font-size: 13px;
            font-weight: 500;
        }

        .btn-warning {
            background-color: #f4a261;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e58b3d;
        }

        .btn-danger {
            border: none;
        }

        .card {
            border-radius: 25px;
        }
    </style>
</head>

<body>

    <?php include("sidebar.php") ?>

    <div class="col-lg-10 mt-3">

        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center mb-4">

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                    <i class="fa fa-bars"></i>
                </button>

                <h5 class="mb-0 fw-bold">Admin Dashboard</h5>
            </div>

            <div class="d-flex align-items-center gap-3">

                <!-- Search Box -->
                <!-- <div class="position-relative">
                    <input type="text" class="form-control search-box pe-5" placeholder="Search here...">

                    <i class="fa fa-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                </div> -->

                <!-- Message Notification Box -->


                <div class="position-relative">

                    <a href="user_message.php">
                        <button class="btn btn-light rounded-circle shadow-sm"
                            style="width:45px;height:45px;">
                            <i class="fa-solid fa-envelope text-dark"></i>
                        </button>
                    </a>

                    <!-- Count Badge -->
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size:11px;">

                        <?= $message_count; ?>

                    </span>

                </div>

                <!-- Admin Profile -->
                <!-- <button class="btn btn-light rounded-circle shadow-sm"
                    style="width:45px;height:45px;">

                    <i class="fa fa-user text-dark"></i>

                </button> -->

            </div>

        </div>

        <!-- Stats -->
        <div class="row g-4 mb-4">

            <div class="col-md-6 col-xl-3">
                <div class="card-custom d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Orders</h6>
                        <h3 class="fw-bold"><?= $total_orders; ?></h3>
                    </div>
                    <div class="icon-box bg-pink">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card-custom d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Cakes</h6>
                        <h3 class="fw-bold"><?= $total_products; ?></h3>
                    </div>
                    <div class="icon-box bg-blue">
                        <i class="fa fa-birthday-cake"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card-custom d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Users</h6>
                        <h3 class="fw-bold"><?= $total_users; ?></h3>
                    </div>
                    <div class="icon-box bg-green">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card-custom d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Revenue</h6>
                        <h3 class="fw-bold">₹<?= $total_revenue; ?></h3>
                    </div>
                    <div class="icon-box bg-orange">
                        <i class="fa fa-rupee-sign"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- Banner Table Card -->
        <div class="card border-0 shadow-lg rounded-4 mt-4 overflow-hidden">

            <!-- Header -->
            <div class="card-header border-0 py-3 px-4"
                style="background: linear-gradient(135deg, #d991a3, #b76e79);">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="text-white fw-bold mb-0">
                            <i class="fa fa-image me-2"></i> Banner Management
                        </h4>
                    </div>

                    <div class="d-flex gap-2">

                        <!-- Add Banner Button -->
                        <a href="add_banner.php">

                            <button class="btn btn-light rounded-pill px-4 fw-semibold">

                                <i class="fa fa-plus me-2 text-primary"></i>
                                Add Banner
                            </button>

                        </a>

                    </div>

                </div>

            </div>

            <!-- Table -->
            <div class="card-body p-4 bg-white">

                <div class="table-responsive">

                    <table class="table align-middle table-hover text-center">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Banner Preview</th>
                                <th>Title</th>
                                <th>Status</th>
                                <!-- <th>Actions</th> -->
                            </tr>

                        </thead>

                        <tbody>

                            <!-- Row 1 -->
                            <?php if (!empty($banner_data)) {
                                foreach ($banner_data as $key => $value) {

                            ?>
                                    <tr>

                                        <td>
                                            <span class="fw-bold text-dark"><?php echo $value['banner_id']; ?></span>
                                        </td>

                                        <td>
                                            <img src="../banner_image/<?php echo $value['banner_image']; ?>" class="rounded-4 shadow-sm"
                                                width="170" height="80" style="object-fit:cover;">
                                        </td>

                                        <td>

                                            <div class="fw-semibold fs-6">
                                                <?php echo $value['title']; ?>
                                            </div>

                                        </td>

                                        <td>

                                            <div class="form-check form-switch d-flex justify-content-center">

                                                <input class="form-check-input shadow-none" type="checkbox"
                                                    style="width:55px; height:25px; cursor:pointer;"
                                                    onchange="window.location.href='dashboard.php?toggle_status=<?php echo $value['banner_id']; ?>'"
                                                    <?php
                                                    if ($value['status'] == 1) {
                                                        echo "checked";
                                                    }
                                                    ?>>

                                            </div>

                                        </td>

                                        <!-- <td>

                                            <div class="d-flex justify-content-center gap-2">

                                                <button class="btn btn-sm btn-warning rounded-circle"
                                                    style="width:40px;height:40px;">

                                                    <i class="fa fa-edit text-white"></i>

                                                </button>

                                                <button class="btn btn-sm btn-danger rounded-circle"
                                                    style="width:40px;height:40px;">

                                                    <i class="fa fa-trash"></i>

                                                </button>

                                            </div>

                                        </td> -->

                                    </tr>
                            <?php
                                }
                            }
                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

    <script src="../Assests/js/bootstrap.bundle.min.js"></script>
</body>

</html>