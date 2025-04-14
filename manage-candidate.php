<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css">
    
    <style>
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 10px; }
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .btn-action { padding: 5px 10px; margin: 0 2px; }
        .thead-dark { background: #212529; color: white; }
/*        .dt-buttons { margin-bottom: 15px; }*/
        .dt-button-collection {
            max-height: 300px; /* Adjust height as needed */
            overflow-y: auto !important;
        }

        th.num_list,td.num_list {
            text-align: end;
        }

        input.checkbox_list {
            text-align: left !important;
            float: inline-start;
        }

        /* Table Styling */
        .custom-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            max-width: 100%;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .custom-table thead th {
            background-color: #343a40 !important;
            border-bottom: 2px solid #dee2e6;
            color: white !important;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 1rem;
            vertical-align: middle;
        }

        .custom-table tbody td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
            color: #495057;
            font-size: 0.9rem;
        }

        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Card Styling */
        .custom-card {
            border: none !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
            margin-bottom: 2rem;
        }

        .custom-card .card-header {
            background-color: #fff !important;
            border-bottom: 1px solid #dee2e6;
            padding: 1.25rem 1.5rem;
        }

        /* Button Styling */
        .btn-custom {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }

        .btn-action {
            padding: 0.4rem 0.75rem;
            border-radius: 4px;
            margin: 0 2px;
            font-size: 0.875rem;
        }

        /* Status Badges */
        .badge-custom {
            padding: 0.5rem 0.75rem;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* DataTables Customization */
        .dataTables_wrapper .dataTables_length select {
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            background-color: #fff;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            background-color: #fff;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            margin: 0 2px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #00c1d4 !important;
            border-color: #00c1d4 !important;
            color: white !important;
        }

        /* Utility Classes */
        .text-end {
            text-align: right !important;
        }

        .checkbox_list {
            width: 18px;
            height: 18px;
            border-radius: 3px;
        }

        /* Button Colors */
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        /* Main Table Styling */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .table thead th {
            background: #343a40;
            color: #fff;
            font-weight: 500;
            font-size: 14px;
            padding: 12px 15px;
            border-bottom: none;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            font-size: 14px;
            color: #333;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Card Styling */
        .card {
            background: #fff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .card-header {
            background: #fff;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .card-body {
            padding: 20px;
        }

        /* Button Styling */
        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            line-height: 32px;
            text-align: center;
            margin: 0 3px;
            border-radius: 4px;
        }

        .btn-info {
            background: #00c1d4;
            border-color: #00c1d4;
            color: #fff;
        }

        .btn-warning {
            background: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .btn-success {
            background: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        .btn-danger {
            background: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        /* DataTable Styling */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 6px 12px;
            height: 34px;
        }

        .dataTables_wrapper .dataTables_length select {
            width: 70px;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 200px;
            margin-left: 8px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            margin: 0 2px;
            border-radius: 4px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #00c1d4 !important;
            border-color: #00c1d4 !important;
            color: white !important;
        }

        /* Checkbox Styling */
        .checkbox-custom {
            width: 18px;
            height: 18px;
            margin: 0;
        }

        /* Status Badge */
        .badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 12px;
        }

        /* Essential Table Styling */
        #example {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        #example thead th {
            background: #2c3e50;
            color: white;
            font-weight: 500;
            padding: 12px;
            font-size: 13px;
            border-bottom: none;
            white-space: nowrap;
        }

        #example tbody td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        #example tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            border: none;
            color: white;
            font-size: 14px;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-edit { background: #3498db; }
        .btn-payment { background: #f1c40f; }
        .btn-view { background: #2ecc71; }
        .btn-delete { background: #e74c3c; }

        /* Search and Length Controls */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 6px 10px;
            margin-left: 5px;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 4px 8px;
        }

        /* Add New Button */
        .add-new-btn {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .add-new-btn:hover {
            background: #27ae60;
            color: white;
        }

        /* Card */
        .content-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card-top {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 18px;
            font-weight: 500;
            color: #2c3e50;
            margin: 0;
        }
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
                        <h1 class="h2">Manage Candidates</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item">Candidate</li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Candidates</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Candidates Table -->
                    <div class="content-card">
                        <div class="card-top">
                            <h5 class="card-title">Manage Candidates</h5>
                            <?php if(isset($_GET['batch'])){ ?>
                                <a href="add-candidate-to-particular-batch.php?batchid=<?php echo $_GET['batch']; ?>" class="add-new-btn">
                                    <i class="fas fa-plus"></i>
                                    <span>Add Candidate</span>
                                </a>
                            <?php } else { ?>
                                <a href="add-candidate.php" class="add-new-btn">
                                    <i class="fas fa-plus"></i>
                                    <span>Add Candidate</span>
                                </a>
                            <?php } ?>
                        </div>

                        <div class="p-3">
                            <table id="example" class="table table-borderless w-100">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                        <th>Enrollment ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Job Role</th>
                                        <th>ID</th>
                                        <th>Father</th>
                                        <th>Aadhar</th>
                                        <th>Qualification</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Marital</th>
                                        <th>Religion</th>
                                        <th>Category</th>
                                        <th>Village</th>
                                        <th>Mandal</th>
                                        <th>District</th>
                                        <th>State</th>
                                        <th>Pincode</th>
                                        <th>Created</th>
                                        <th>Modified</th>
                                        <th>Batch ID</th>
                                        <th>Training Center</th>
                                        <th>Scheme</th>
                                        <th>Sector</th>
                                        <th>Batch</th>
                                        <th>Payment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = isset($_GET['batch']) ? 
                                        "SELECT * FROM tblcandidate WHERE batch=:batch ORDER BY CandidateId DESC" : 
                                        "SELECT * FROM tblcandidate ORDER BY CandidateId DESC";
                                    $query = $dbh->prepare($sql);
                                    if(isset($_GET['batch'])) {
                                        $query->bindParam(':batch', $_GET['batch'], PDO::PARAM_STR);
                                    }
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {
                                            $jobrollname = '';
                                            $sql4 = "SELECT jobrollname FROM tbljobroll WHERE JobrollId = :jobroll";
                                            $query4 = $dbh->prepare($sql4);
                                            $query4->bindParam(':jobroll', $result->job_roll, PDO::PARAM_INT);
                                            $query4->execute();
                                            $jobrollname = $query4->fetchColumn();

                                            $tc_sql = "SELECT trainingcentername FROM tbltrainingcenter WHERE TrainingcenterId = :tc";
                                            $tc_query = $dbh->prepare($tc_sql);
                                            $tc_query->bindParam(':tc', $result->training_center, PDO::PARAM_INT);
                                            $tc_query->execute();
                                            $tc_name = $tc_query->fetchColumn();

                                            $scheme_sql = "SELECT SchemeName FROM tblscheme WHERE SchemeId = :scheme";
                                            $scheme_query = $dbh->prepare($scheme_sql);
                                            $scheme_query->bindParam(':scheme', $result->scheme, PDO::PARAM_INT);
                                            $scheme_query->execute();
                                            $scheme_name = $scheme_query->fetchColumn();

                                            $sector_sql = "SELECT SectorName FROM tblsector WHERE SectorId = :sector";
                                            $sector_query = $dbh->prepare($sector_sql);
                                            $sector_query->bindParam(':sector', $result->sector, PDO::PARAM_INT);
                                            $sector_query->execute();
                                            $sector_name = $sector_query->fetchColumn();

                                            $batch_sql = "SELECT batch_name FROM tblbatch WHERE id = :batch";
                                            $batch_query = $dbh->prepare($batch_sql);
                                            $batch_query->bindParam(':batch', $result->batch, PDO::PARAM_INT);
                                            $batch_query->execute();
                                            $batch_name = $batch_query->fetchColumn();

                                            $payment_sql = "SELECT paid, total_fee FROM payment WHERE candidate_id = :cid";
                                            $payment_query = $dbh->prepare($payment_sql);
                                            $payment_query->bindParam(':cid', $result->CandidateId, PDO::PARAM_INT);
                                            $payment_query->execute();
                                            $payment = $payment_query->fetch(PDO::FETCH_ASSOC);
                                            $status = $payment ? 
                                                ($payment['paid'] == $payment['total_fee'] ? 
                                                    '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank" class="btn btn-success btn-xs">Paid</a>' : 
                                                    '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank" class="btn btn-warning btn-xs">Pending</a>') : 
                                                '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank" class="btn btn-danger btn-xs">Unpaid</a>';
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-check-input" name="id[]" value="<?php echo $result->CandidateId; ?>">
                                            </td>
                                            <td><?php echo htmlentities($result->enrollmentid); ?></td>
                                            <td><?php echo htmlentities($result->candidatename); ?></td>
                                            <td><?php echo htmlentities($result->phonenumber); ?></td>
                                            <td><?php echo $jobrollname; ?></td>
                                            <td><?php echo htmlentities($result->CandidateId); ?></td>
                                            <td><?php echo htmlentities($result->fathername); ?></td>
                                            <td><?php echo htmlentities($result->aadharnumber); ?></td>
                                            <td><?php echo htmlentities($result->qualification); ?></td>
                                            <td><?php echo htmlentities($result->dateofbirth); ?></td>
                                            <td><?php echo htmlentities($result->gender); ?></td>
                                            <td><?php echo htmlentities($result->maritalstatus); ?></td>
                                            <td><?php echo htmlentities($result->religion); ?></td>
                                            <td><?php echo htmlentities($result->category); ?></td>
                                            <td><?php echo htmlentities($result->village); ?></td>
                                            <td><?php echo htmlentities($result->mandal); ?></td>
                                            <td><?php echo htmlentities($result->district); ?></td>
                                            <td><?php echo htmlentities($result->state); ?></td>
                                            <td><?php echo htmlentities($result->pincode); ?></td>
                                            <td><?php echo htmlentities($result->DateCreated); ?></td>
                                            <td><?php echo htmlentities($result->DateModified); ?></td>
                                            <td><?php echo htmlentities($result->tblbatch_id); ?></td>
                                            <td><?php echo htmlentities($tc_name); ?></td>
                                            <td><?php echo htmlentities($scheme_name); ?></td>
                                            <td><?php echo htmlentities($sector_name); ?></td>
                                            <td><?php echo htmlentities($batch_name); ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="action-btn btn-edit" 
                                                            onclick="window.location='edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>'"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="action-btn btn-payment" 
                                                            onclick="payment_status(<?php echo htmlentities($result->CandidateId); ?>)"
                                                            title="Payment Status">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" class="action-btn btn-view" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#myModal_<?php echo htmlentities($result->CandidateId); ?>"
                                                            title="View Images">
                                                        <i class="fas fa-image"></i>
                                                    </button>
                                                    <button type="button" class="action-btn btn-delete delete" 
                                                            id="del_<?php echo htmlentities($result->CandidateId); ?>"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Image Modal -->
                                        <div class="modal fade" id="myModal_<?php echo htmlentities($result->CandidateId); ?>" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?php echo htmlentities($result->candidatename); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Photo</p>
                                                        <?php echo $result->candidatephoto ? '<a target="_blank" href="doc/'.$result->candidatephoto.'"><img style="width: 76px; height: 44px;" src="doc/'.$result->candidatephoto.'"></a>' : '<i class="fas fa-upload fa-2x"></i>'; ?>
                                                        <hr>
                                                        <p>Aadhaar</p>
                                                        <?php echo $result->aadhaarphoto ? '<a target="_blank" href="doc/'.$result->aadhaarphoto.'"><img style="width: 76px; height: 44px;" src="doc/'.$result->aadhaarphoto.'"></a>' : '<i class="fas fa-upload fa-2x"></i>'; ?>
                                                        <hr>
                                                        <p>Qualification</p>
                                                        <?php echo $result->qualificationphoto ? '<a target="_blank" href="doc/'.$result->qualificationphoto.'"><img style="width: 76px; height: 44px;" src="doc/'.$result->qualificationphoto.'"></a>' : '<i class="fas fa-upload fa-2x"></i>'; ?>
                                                        <hr>
                                                        <p>Application</p>
                                                        <?php echo $result->applicationphoto ? '<a target="_blank" href="doc/'.$result->applicationphoto.'"><img style="width: 76px; height: 44px;" src="doc/'.$result->applicationphoto.'"></a>' : '<i class="fas fa-upload fa-2x"></i>'; ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="upload-candidate-file.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>" class="btn btn-success">Upload</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php $cnt++; } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="c_id">Loading...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="c_myModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Candidate Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="c_data">Loading...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>

    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            "pageLength": 10,
            "ordering": true,
            "responsive": true,
            "info": true,
            "dom": '<"top"fl>rt<"bottom"ip>',
            "language": {
                "search": "",
                "searchPlaceholder": "Search...",
                "lengthMenu": "_MENU_ per page"
            }
        });

        $('#selectAll').click(function() {
            $('table tbody input[type="checkbox"]').prop('checked', this.checked);
        });

        // Individual Delete
        $('#example tbody').on('click', '.delete', function() {
            var el = this;
            var id = this.id.split("_")[1];
            if (confirm("Are you sure you want to delete this candidate?")) {
                $.ajax({
                    url: 'action.php',
                    type: 'POST',
                    data: { id: id, action: "Delete candidate" },
                    success: function(response) {
                        if (response == 4) {
                            $(el).closest('tr').css('background', '#ffcccc').fadeOut(800, function() { $(this).remove(); });
                        } else {
                            alert('Error deleting candidate.');
                        }
                    }
                });
            }
        });

        // Bulk Delete
        $('#deleteBtn').on('click', function() {
            var selectedIds = $('.deleteCheckbox:checked').map(function() { return $(this).val(); }).get();
            if (selectedIds.length === 0) {
                alert("Please select at least one candidate to delete.");
                return;
            }
            if (confirm("Are you sure you want to delete selected candidates?")) {
                $.ajax({
                    url: 'delete_candidate.php',
                    type: 'POST',
                    data: { ids: selectedIds },
                    success: function(response) {
                        if (response.trim() === "success") {
                            selectedIds.forEach(function(id) {
                                $('#example tr').has('#del_' + id).css('background', '#ffcccc').fadeOut(800, function() { $(this).remove(); });
                            });
                        } else {
                            alert("Error deleting candidates.");
                        }
                    }
                });
            }
        });
    });

    function payment_status(id) {
        $("#c_id").html('Loading...');
        $.ajax({
            url: 'payment_status.php',
            type: 'post',
            data: { action: 'action', id: id },
            success: function(res) { $("#c_id").html(res); }
        });
    }

    function all_data(id) {
        $("#c_data").html('Loading...');
        $.ajax({
            url: 'candidate_ajax.php',
            type: 'post',
            data: { action: 'action', id: id },
            success: function(res) { $("#c_data").html(res); }
        });
    }
    </script>
</body>
</html>
<?php } ?>