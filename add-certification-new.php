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
                        <h1 class="h2">Add Batch</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Batch</li>
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
                            <h5 class="mb-0">Add New Batch</h5>
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
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <script>
    function getStudent(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'trainingid=' + val,
            success: function(data) {
                $("#studentid").html(data);
            }
        });
    }

    function getsector(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'schemeid=' + val,
            success: function(data) {
                $("#sectorid").html(data);
            }
        });
    }

    function getjobroll(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'sectorid=' + val,
            success: function(data) {
                $("#jobrollid").html(data);
            }
        });
    }

    function getbatch(val) {
        $.ajax({
            type: "POST",
            url: "get_student.php",
            data: 'jobrollid_for_certificate=' + val,
            success: function(data) {
                $("#batchid").html(data);

            }
        });
    }
    </script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <!-- ========== LEFT SIDEBAR ========== -->
                <?php include('includes/leftbar.php'); ?>
                <!-- /.left-sidebar -->
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Add certification to batch</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Add certification to batch</li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-body">
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
                                        <form class="form-horizontal" method="post">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Training
                                                    Center</label>
                                                <div class="col-sm-10">
                                                    <select name="trainingcenterid" class="form-control clid"
                                                        id="classid" onChange="getStudent(this.value);"
                                                        required="required">
                                                        <option value="">Select Training Center Name</option>
                                                        <?php $sql = "SELECT * from tbltrainingcenter";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $trainings = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($trainings as $training) {   ?>
                                                        <option
                                                            value="<?php echo htmlentities($training->TrainingcenterId); ?>">
                                                            <?php echo htmlentities($training->trainingcentername); ?>&nbsp;
                                                        </option>
                                                        <?php }
                                                            } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="date" class="col-sm-2 control-label ">Scheme Name</label>
                                                <div class="col-sm-10">
                                                    <select name="schemeid" class="form-control stid" id="studentid"
                                                        required="required" onChange="getsector(this.value);">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Sector Name</label>
                                                <div class="col-sm-10">
                                                    <select name="sectorid" class="form-control stid" id="sectorid"
                                                        required="required" onChange="getjobroll(this.value);">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Jobroll Name</label>
                                                <div class="col-sm-10">
                                                    <select name="jobrollid" class="form-control stid" id="jobrollid"
                                                        required="required" onChange="getbatch(this.value);">
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-body p-20">
                                        <table id="example" class="display table table-striped table-bordered"
                                            cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Batch Name</th>
                                                    <th>Jobroll</th>
                                                    <th>Sector</th>
                                                    <th>Scheme</th>
                                                    <th>Training Center</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Batch Name</th>
                                                    <th>Jobroll</th>
                                                    <th>Sector</th>
                                                    <th>Scheme</th>
                                                    <th>Training Center</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="batchid">

                                            </tbody>
                                        </table>
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
    </div>
    <!-- /.content-container -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- /.main-wrapper -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    $(function($) {
        $(".js-states").select2();
        $(".js-states-limit").select2({
            maximumSelectionLength: 2
        });
        $(".js-states-hide").select2({
            minimumResultsForSearch: Infinity
        });
    });
    </script>
</body>

</html>
<?php } ?>