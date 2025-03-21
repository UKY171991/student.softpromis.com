<?php
session_start();
error_reporting(0);
$batchid = $_GET['batchid'];
include('includes/config.php');
$sql = "SELECT tblcandidateresults.*,tblcandidate.*,tblbatch.* from tblcandidateresults JOIN tblcandidate JOIN tblbatch ON tblcandidateresults.candidate_id=tblcandidate.CandidateId AND tblcandidateresults.batch_id=tblbatch.id";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$candidatecount = $query->rowCount();
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $date  = mysqli_real_escape_string($dbh, $_POST['date']);
        $candidateid     = $_POST['candidateid'];
        $batchid = $_POST['batchid'];
        $candidateresults = $_POST['result'];

        //INSERT
        for ($i = 0; $i <= $candidatecount; $i++) {
            # code...
            $sql = "UPDATE tblcandidate SET result=:result WHERE CandidateId=:candidateid ";
            $query = $dbh->prepare($sql);
            $query->bindParam(':result', $candidateresults[$i], PDO::PARAM_STR);
            $query->bindParam(':candidateid', $candidateid[$i], PDO::PARAM_STR);
            $query->execute();
            // echo $result;
        }
        if ($query->execute()) {
            $msg = "student added to particular batch";
        } {
            $error = "student failed to add to particular batch";
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">


  <link rel="stylesheet" href="includes/style.css">

  
    
    <style>
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 10px; }
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .thead-dark { background: #212529; color: white; }
        .dt-buttons { margin-bottom: 15px; }
        
        /* Enhanced Pagination Styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin: 0 2px;
            padding: 5px 10px;
            background: #fff;
            color: #007bff;
            transition: all 0.3s ease;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            color: #6c757d;
            background: #f8f9fa;
            border-color: #dee2e6;
            cursor: not-allowed;
        }
        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            justify-content: flex-end;
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
                        <h1 class="h2">Manage Results</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item">Result</li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Result</li>
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

                    <!-- Results Table -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Manage Result</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <form method="post" action="">
                                    <table id="example" class="table table-hover table-bordered" style="width:100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Candidate Name</th>
                                                <th>Father Name</th>
                                                <th>Aadhar Number</th>
                                                <th>Phone Number</th>
                                                <th>Qualification</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>
                                                <th>Batch</th>
                                                <th>Result</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Candidate Name</th>
                                                <th>Father Name</th>
                                                <th>Aadhar Number</th>
                                                <th>Phone Number</th>
                                                <th>Qualification</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>
                                                <th>Batch</th>
                                                <th>Result</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php $batch = "";
                                            $cnt = 1;
                                            if ($candidatecount > 0) {
                                                foreach ($results as $result) {   ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($result->candidatename); ?></td>
                                                        <td><?php echo htmlentities($result->fathername); ?></td>
                                                        <td><?php echo htmlentities($result->aadharnumber); ?></td>
                                                        <td><?php echo htmlentities($result->phonenumber); ?></td>
                                                        <td><?php echo htmlentities($result->qualification); ?></td>
                                                        <td><?php echo htmlentities($result->dateofbirth); ?></td>
                                                        <td><?php echo htmlentities($result->gender); ?></td>
                                                        <td><?php echo htmlentities($result->batch_name); ?></td>
                                                        <td><?php echo htmlentities($result->result); ?></td>
                                                    </tr>
                                            <?php $cnt = $cnt + 1;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>


    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
    $(function($) {
        $('#example').DataTable();

        $('#example2').DataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false
        });

        $('#example3').DataTable();
    });
    </script>
</body>
</html>
<?php } ?>