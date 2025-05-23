<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $invoiceno = $_POST['invoice_no'];
        $invoicedate = $_POST['invoice_date'];
        $manualbatchid = $_POST['manual_batch_id'];
        $trainingcenterid = $_POST['trainingcenterid'];
        $schemeid = $_POST['schemeid'];
        $sectorid = $_POST['sectorid'];
        $jobrollid = $_POST['jobroll_id'];
        $batchid = $_POST['batchid'];
        $tranche = $_POST['tranche'];
        $amount = $_POST['amount'];

        $count = "SELECT * FROM tblinvoice WHERE batchID=:batchID AND tranche=:tranche";
        $query = $dbh->prepare($count);
        $query->bindParam(':batchID', $batchid, PDO::PARAM_STR);
        $query->bindParam(':tranche', $tranche, PDO::PARAM_STR);
        $query->execute();
        $totalbatch = $query->rowCount();
        if ($totalbatch == 0) {
            $sql = "INSERT INTO tblinvoice(invoiceNo, invoiceDate, manualbatchID, trainingcenterID, schemeID, sectorID, jobrollID, batchID, tranche, invoiceAmount) 
                    VALUES(:invoiceno, :invoicedate, :manualbatchid, :trainingcenterid, :schemeid, :sectorid, :jobrollid, :batchid, :tranche, :amount)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':invoiceno', $invoiceno, PDO::PARAM_STR);
            $query->bindParam(':invoicedate', $invoicedate, PDO::PARAM_STR);
            $query->bindParam(':manualbatchid', $manualbatchid, PDO::PARAM_STR);
            $query->bindParam(':trainingcenterid', $trainingcenterid, PDO::PARAM_STR);
            $query->bindParam(':schemeid', $schemeid, PDO::PARAM_STR);
            $query->bindParam(':sectorid', $sectorid, PDO::PARAM_STR);
            $query->bindParam(':jobrollid', $jobrollid, PDO::PARAM_STR);
            $query->bindParam(':batchid', $batchid, PDO::PARAM_STR);
            $query->bindParam(':tranche', $tranche, PDO::PARAM_STR);
            $query->bindParam(':amount', $amount, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = "Invoice added successfully";
            } else {
                $error = "Something went wrong. Please try again";
            }
        } else {
            $error = "Tranche already exists for this batch. Please select a different tranche.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen"> -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>

    <!-- Select2 CSS -->

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">

    
    
    <style>
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 10px; }
        .form-control:focus, .select2-container--default .select2-selection--single:focus { 
            border-color: #007bff; 
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); 
        }
        .select2-container { width: 100% !important; }
    </style>
</head>

<body class="bg-light">
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <?php include('includes/topbar-new.php'); ?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <?php include('includes/left-sidebar-new.php'); ?>
                <?php include('includes/leftbar.php'); ?>

                <!-- Main Content -->
                <main class="col-md-9 col-lg-10 px-md-4">
                    <!-- Page Title -->
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2">Add Invoice</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Invoice</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Form -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Create New Invoice</h5>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="invoice_no" class="form-label">Invoice Number</label>
                                        <input type="text" name="invoice_no" class="form-control" id="invoice_no" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="invoice_date" class="form-label">Invoice Date</label>
                                        <input type="date" name="invoice_date" class="form-control" id="invoice_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="manual_batch_id" class="form-label">Manual Batch ID</label>
                                            <input type="text" name="manual_batch_id" class="form-control" id="manual_batch_id" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="trainingcenterid" class="form-label">Training Center</label>
                                            <select name="trainingcenterid" class="form-select" id="trainingcenterid" required>
                                                <option value="">Select Training Center</option>
                                                <?php 
                                                $sql = "SELECT * FROM tbltrainingcenter";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $trainings = $query->fetchAll(PDO::FETCH_OBJ);
                                                if ($query->rowCount() > 0) {
                                                    foreach ($trainings as $training) { ?>
                                                        <option value="<?php echo htmlentities($training->TrainingcenterId); ?>">
                                                            <?php echo htmlentities($training->trainingcentername); ?>
                                                        </option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="schemeid" class="form-label">Scheme</label>
                                            <select name="schemeid" class="form-select" id="schemeid" required>
                                                <option value="">Select Scheme</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sectorid" class="form-label">Sector</label>
                                            <select name="sectorid" class="form-select" id="sectorid" required>
                                                <option value="">Select Sector</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jobroll_id" class="form-label">Job Roll</label>
                                            <select name="jobroll_id" class="form-select" id="jobroll_id" required>
                                                <option value="">Select Job Roll</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="batchid" class="form-label">Batch</label>
                                            <select name="batchid" class="form-select" id="batchid" required>
                                                <option value="">Select Batch</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tranche" class="form-label">Tranche</label>
                                            <select name="tranche" class="form-select" required>
                                                <option value="">Select Tranche</option>
                                                <option value="1ST">1ST</option>
                                                <option value="2ND">2ND</option>
                                                <option value="3RD">3RD</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Invoice Amount</label>
                                            <input type="number" name="amount" class="form-control" id="amount" step="0.01" required>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Add Invoice
                                </button>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/main.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize Select2
        $('#trainingcenterid, #schemeid, #sectorid, #jobroll_id, #batchid, #tranche').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        // Dynamic loading functions
        $('#trainingcenterid').on('change', function() {
            var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "get_student.php",
                data: 'trainingid=' + val,
                success: function(data) {
                    $("#schemeid").html(data);
                }
            });
        });

        $('#schemeid').on('change', function() {
            var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "get_student.php",
                data: 'schemeid=' + val,
                success: function(data) {
                    $("#sectorid").html(data);
                }
            });
        });

        $('#sectorid').on('change', function() {
            var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "get_student.php",
                data: 'sectorid=' + val,
                success: function(data) {
                    $("#jobroll_id").html(data);
                }
            });
        });

        $('#jobroll_id').on('change', function() {
            var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "get_student.php",
                data: 'jobroll_id=' + val,
                success: function(data) {
                    $("#batchid").html(data);
                }
            });
        });
    });
    </script>
</body>
</html>