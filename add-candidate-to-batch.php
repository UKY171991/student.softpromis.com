<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $trainingcenterid = $_POST['trainingcenterid'];
        $schemeid = $_POST['schemeid'];
        $sectorid = $_POST['sectorid'];
        $jobrollid = $_POST['jobrollid'];
        $batchname = $_POST['batchname'];
        $sdate = $_POST['start_date'];
        $edate = $_POST['end_date'];
        $stime = $_POST['start_time'];
        $etime = $_POST['end_time'];
        $sql = "INSERT INTO tblbatch(training_centre_id, scheme_id, sector_id, job_roll_id, batch_name, start_date, end_date, start_time, end_time) 
                VALUES(:trainingcenter_id, :scheme_id, :sector_id, :job_roll_id, :batch_name, :sdate, :edate, :stime, :etime)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':trainingcenter_id', $trainingcenterid, PDO::PARAM_STR);
        $query->bindParam(':scheme_id', $schemeid, PDO::PARAM_STR);
        $query->bindParam(':sector_id', $sectorid, PDO::PARAM_STR);
        $query->bindParam(':job_roll_id', $jobrollid, PDO::PARAM_STR);
        $query->bindParam(':batch_name', $batchname, PDO::PARAM_STR);
        $query->bindParam(':sdate', $sdate, PDO::PARAM_STR);
        $query->bindParam(':edate', $edate, PDO::PARAM_STR);
        $query->bindParam(':stime', $stime, PDO::PARAM_STR);
        $query->bindParam(':etime', $etime, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Batch added successfully";
        } else {
            $error = "Something went wrong. Please try again";
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
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>


    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="includes/style.css">
    
    <style>
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 10px; }
        .form-control:focus, .select2-container--default .select2-selection--single:focus { 
            border-color: #007bff; 
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); 
        }
        .select2-container { width: 100% !important; }
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .thead-dark { background: #212529; color: white; }
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
                        <h1 class="h2">Add Candidate to Batch</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Candidate to Batch</li>
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

                    <!-- Selection Form -->
                    <div class="card mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Select Batch</h5>
                        </div>
                        <div class="card-body">
                            <form method="post">
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

                                <div class="mb-3">
                                    <label for="schemeid" class="form-label">Scheme</label>
                                    <select name="schemeid" class="form-select" id="schemeid" required>
                                        <option value="">Select Scheme</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="sectorid" class="form-label">Sector</label>
                                    <select name="sectorid" class="form-select" id="sectorid" required>
                                        <option value="">Select Sector</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="jobrollid" class="form-label">Job Roll</label>
                                    <select name="jobrollid" class="form-select" id="jobrollid" required>
                                        <option value="">Select Job Roll</option>
                                    </select>
                                </div>

                                <!-- Hidden fields for batch creation (optional, remove if not needed) -->
                                <input type="hidden" name="batchname" value="AutoGeneratedBatch">
                                <input type="hidden" name="start_date" value="<?php echo date('Y-m-d'); ?>">
                                <input type="hidden" name="end_date" value="<?php echo date('Y-m-d', strtotime('+30 days')); ?>">
                                <input type="hidden" name="start_time" value="09:00">
                                <input type="hidden" name="end_time" value="17:00">

                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Create Batch (Optional)
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Batch Table -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Available Batches</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered" style="width:100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Batch Name</th>
                                            <th>Job Roll</th>
                                            <th>Sector</th>
                                            <th>Scheme</th>
                                            <th>Training Center</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Manage</th>
                                            <th>Add Candidate</th>
                                        </tr>
                                    </thead>
                                    <tbody id="batchid">
                                        <!-- Populated dynamically via AJAX in get_student.php -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/main.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize Select2
        $('#trainingcenterid, #schemeid, #sectorid, #jobrollid').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        // Initialize DataTable
        var table = $('#example').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            pageLength: 10,
            order: [[6, 'desc']] // Order by Start Date
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
                    $("#jobrollid").html(data);
                }
            });
        });

        $('#jobrollid').on('change', function() {
            var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "get_student.php",
                data: 'jobrollid=' + val,
                success: function(data) {
                    $("#batchid").html(data);
                    table.clear().rows.add($(data).find('tr')).draw();
                }
            });
        });
    });
    </script>
</body>
</html>