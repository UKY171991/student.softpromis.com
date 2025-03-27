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

        $count = "SELECT batch_name FROM tblbatch WHERE batch_name=:batch_name";
        $query = $dbh->prepare($count);
        $query->bindParam(':batch_name', $batchname, PDO::PARAM_STR);
        $query->execute();
        $totalbatch = $query->rowCount();
        if ($totalbatch == 0) {
            $sql = "INSERT INTO tblbatch(training_centre_id, scheme_id, sector_id, job_roll_id, batch_name, start_date, end_date, start_time, end_time) VALUES(:trainingcenter_id, :scheme_id, :sector_id, :job_roll_id, :batch_name, :sdate, :edate, :stime, :etime)";
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
        } else {
            $error = "Batch name already exists. Please try again";
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
                        <h1 class="h2">Add candidate to particular batch</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add candidate to particular batch</li>
                        </ol>
                    </nav>

                    

                    <!-- Form -->
                    <div class="card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Add candidate to particular batch</h5>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                

                              

                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Add Batch
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


   
</body>
</html>







<?php
session_start();
error_reporting(0);
$batchid = $_GET['batchid'];
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

    if (isset($_POST['submit'])) {
        $date  = mysqli_real_escape_string($dbh, $_POST['date']);
        $candidateid     = $_POST['chkbox'];
        $batchid = $_POST['batchid'];
        $batch = $_POST['batchid'];

        $sql_b = "SELECT * FROM tblbatch WHERE id = :batchid ORDER BY id DESC";
        $query_b = $dbh->prepare($sql_b);
        $query_b->bindParam(':batchid', $batchid, PDO::PARAM_INT);
        $query_b->execute();
        $batches = $query_b->fetchAll(PDO::FETCH_ASSOC);

        $training_center = $batches[0]['training_centre_id'];
        $scheme = $batches[0]['scheme_id'];
        $sector = $batches[0]['sector_id'];
        $job_roll = $batches[0]['job_roll_id'];

        //print_r($_POST); die;
        //INSERT
        foreach ($candidateid as $id) {
            # code...
            // $sql = "UPDATE tblcandidate SET tblbatch_id=:batch_id, training_center=:training_center, scheme=:scheme, sector=:sector, job_roll=:job_roll,batch:batch WHERE CandidateId=:candidateid ";
            // $query = $dbh->prepare($sql);
            // $query->bindParam(':batch_id', $batchid, PDO::PARAM_STR);
            // $query->bindParam(':training_center', $training_center, PDO::PARAM_STR);
            // $query->bindParam(':scheme', $scheme, PDO::PARAM_STR);
            // $query->bindParam(':sector', $sector, PDO::PARAM_STR);
            // $query->bindParam(':job_roll', $job_roll, PDO::PARAM_STR);
            // $query->bindParam(':batch', $batch, PDO::PARAM_STR);

            // $query->bindParam(':candidateid', $id, PDO::PARAM_STR);

            $sql = "UPDATE tblcandidate 
        SET tblbatch_id=:batch_id, 
            training_center=:training_center, 
            scheme=:scheme, 
            sector=:sector, 
            job_roll=:job_roll, 
            batch=:batch 
        WHERE CandidateId=:candidateid";

            $query = $dbh->prepare($sql);
            $query->bindParam(':batch_id', $batchid, PDO::PARAM_STR);
            $query->bindParam(':training_center', $training_center, PDO::PARAM_STR);
            $query->bindParam(':scheme', $scheme, PDO::PARAM_STR);
            $query->bindParam(':sector', $sector, PDO::PARAM_STR);
            $query->bindParam(':job_roll', $job_roll, PDO::PARAM_STR);
            $query->bindParam(':batch', $batch, PDO::PARAM_STR);
            $query->bindParam(':candidateid', $id, PDO::PARAM_STR);
            
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
    </style>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Add candidate to particular batch</h2>
                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Training Center</li>
                                    <li class="active">Add candidate to particular batch</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->

                    <section class="section">
                        <div class="container-fluid">



                            <div class="row">
                                <div class="col-md-12">

                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Add candidate to particular batch</h5>
                                            </div>
                                        </div>
                                        <?php if ($msg) { ?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Well done!</strong>
                                            <?php echo htmlentities($msg); ?>
                                        </div>
                                        <?php } else if ($error) { ?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong>
                                            <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <div style="overflow: auto;">
                                            <div class="panel-body p-20">
                                                <form method="post" action="add-candidate-to-particular-batch.php">
                                                    <table id="example"
                                                        class="display table table-striped table-bordered"
                                                        cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Candidate Name</th>
                                                                <th>Father Name</th>
                                                                <th>Aadhar Number</th>
                                                                <th>Phone Number</th>
                                                                <th>Qualification</th>
                                                                <th>Date of Birth</th>
                                                                <th>Gender</th>
                                                                <th>Marital Status</th>
                                                                <th>Religion</th>
                                                                <th>Action</th>
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
                                                                <th>Marital Status</th>
                                                                <th>Religion</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <?php $batch = "";
                                                                $sql = "SELECT * from tblcandidate WHERE tblbatch_id IS NULL";
                                                                $query = $dbh->prepare($sql);
                                                                $query->execute();
                                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                                $cnt = 1;
                                                                if ($query->rowCount() > 0) {
                                                                    foreach ($results as $result) {   ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo htmlentities($cnt); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->candidatename); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->fathername); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->aadharnumber); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->phonenumber); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->qualification); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->dateofbirth); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->gender); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->maritalstatus); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlentities($result->religion); ?>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="batchid"
                                                                        value="<?php echo $batchid; ?>">
                                                                    <input type="checkbox" name="chkbox[]"
                                                                        value="<?php echo htmlentities($result->CandidateId); ?>">
                                                                </td>
                                                            </tr>
                                                            <?php $cnt = $cnt + 1;
                                                                    }
                                                                } ?>


                                                        </tbody>
                                                    </table>
                                                    <input class="btn btn-success" type="submit" name="submit"
                                                        value="submit">
                                                </form>
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                        </div>
                        <!-- /.panel -->
                </div>
                <!-- /.col-md-6 -->

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->
        </section>
        <!-- /.section -->

    </div>
    <!-- /.main-page -->



    </div>
    <!-- /.content-container -->
    </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- /.main-wrapper -->

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
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