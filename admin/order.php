<?php
include("../db_connect.php");
global $conn;
session_start();
$orderDetails = "SELECT orders.* FROM orders";
$result = mysqli_query($conn, $orderDetails);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List - Bakery Admin</title>
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f3ef;
            font-family: Poppins, sans-serif;
        }

        /* Main Card */
        .main-card {
            background: #fdfaf5;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08)
        }

        .search-box {
            border-radius: 30px
        }

        .table thead {
            background: #f1eee8
        }

        .table td,
        .table th {
            vertical-align: middle
        }

        /* Buttons */
        .btn-main {
            background: linear-gradient(45deg, #ff4f81, #ff7a18);
            border-radius: 10px;
        }

        .btn-main:hover {
            opacity: 0.9;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px
        }


        .pending {
            background: #ffe5c2;
            color: #ff8c32;

        }

        .preparing {
            background-color: #f9f5a3;
        }

        .delivered {
            background: #d4edda;
            color: #28a745
        }

        .canceled {
            background: #f8d7da;
            color: #dc3545
        }

        .btn-orange {
            background: #ff8c32;
            color: #fff;
            border: none
        }

        .btn-orange:hover {
            background: #e67620
        }

        /* Badges */
        .badge-edit {
            background: #ffe1ea;
            color: #ff4f81;
            border-radius: 8px;
        }

        .badge-delete {
            background: #ff4f81;
            border-radius: 8px;
        }

        /* Action hover */
        .badge:hover {
            transform: scale(1.05);
            transition: 0.2s;
        }

        /* Action Buttons Container */
        .action-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.3s;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php include("sidebar.php") ?>

            <!-- Main -->
            <div class="col-lg-10 mt-3">

                <div class="main-card">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas"
                                data-bs-target="#mobileMenu">
                                <i class="fa fa-bars"></i>
                            </button>
                            <h3 class="mb-0">Order List</h3>
                        </div>
                        <button class="btn btn-light rounded-circle"><i class="fa fa-user"></i></button>
                    </div>

                    <!-- Filters -->
                    <div class=" d-flex justify-content-end gap-3">
                        <a href="add_status.php" class="btn btn-main text-light">
                            ➕ Add Status
                        </a>
                        <a href="add_paymentMethod.php" class="btn btn-main text-light">
                            ➕ Add Payment Method
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table align-middle" id="myTable">
                            <thead>
                                <tr class="text-center">
                                    <th>Order Id</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Detail</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                foreach ($row as $key => $value) {
                                ?>
                                    <tr class="text-center">
                                        <td><?php echo $value['id']; ?></td>
                                        <td><?php echo $value['username']; ?></td>
                                        <td><?php echo $value['order_date']; ?></td>
                                        <td>
                                            <?php
                                            $status = $value['status'];
                                            if ($status == "Pending") {
                                                echo "<span class='status-badge pending'>$status</span>";
                                            } elseif ($status == "Preparing" || $status == "Shipped") {
                                                echo "<span class='status-badge preparing text-warning'>$status</span>";
                                            } elseif ($status == "Deliverd") {
                                                echo "<span class='status-badge delivered'>$status</span>";
                                            } else {
                                                echo "<span class='status-badge canceled'>$status</span>";
                                            }
                                            ?>
                                        </td>
                                        </td>
                                        <td><?php echo $value['price'] ?></td>
                                        <td><a href="orderDetails.php?id=<?php echo $value['id']; ?>" class="text-light">
                                                <button class="btn btn-orange btn-sm">
                                                    <i class="fa fa-id-card"></i>
                                                </button>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="order_edit.php?order_id=<?php echo $value['id']; ?>"
                                                    class="action-btn badge-edit"
                                                    title="Edit Product">
                                                    <i class="fa fa-pen"></i>
                                                </a>

                                                <!-- DELETE -->
                                                <a href="deleteProduct.php?order_id=<?php echo $value['id']; ?>&badge=order"
                                                    class="action-btn badge-delete text-light"
                                                    title="Delete Product"
                                                    onclick="return confirm('Are you sure you want to delete?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-4.0.0.js"
        integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous">
    </script>

    <!-- Data Tables from jquery -->
    <script src="//cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>

</body>

</html>