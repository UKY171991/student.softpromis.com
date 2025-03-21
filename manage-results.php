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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

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
        .thead-dark { background: #212529; color: white; }
        .dt-buttons { margin-bottom: 15px; }
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
                            <h5 class="mb-0">Batch Results</h5>
                        </div>
                        <div class="card-body p-2">
                            <form method="post">
                                <!-- <div class="mb-3">
                                    <label for="date" class="form-label">Result Date</label>
                                    <input type="date" name="date" id="date" class="form-control" required>
                                </div> -->
                                <div class="table-responsive">
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
                                        <tbody>
                                            <?php 
                                            if ($candidatecount > 0) {
                                                $cnt = 1;
                                                foreach ($results as $result) { ?>
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
                                                        <td>
                                                            <input type="hidden" name="candidateid[]" value="<?php echo htmlentities($result->CandidateId); ?>">
                                                            <input type="hidden" name="batchid" value="<?php echo htmlentities($result->batch_id); ?>">
                                                            <select name="result[]" class="form-select" required>
                                                                <option value="<?php echo htmlentities($result->result); ?>" selected>
                                                                    <?php echo htmlentities($result->result); ?>
                                                                </option>
                                                                <option value="Pass">Pass</option>
                                                                <option value="Fail">Fail</option>
                                                                <option value="Pending">Pending</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                            <?php $cnt++; }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">No candidates found for this batch</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if ($candidatecount > 0) { ?>
                                    <button type="submit" name="submit" class="btn btn-primary mt-3">
                                        <i class="fas fa-check me-2"></i>Update Results
                                    </button>
                                <?php } ?>
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/select2/select2.min.js"></script>

    <script src="js/main.js"></script>

    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            pageLength: 10,
            ordering: false, // Disable sorting to keep form inputs stable
            searching: true,
            paging: true
        });
    });
    </script>
</body>
</html>
<?php } ?>
