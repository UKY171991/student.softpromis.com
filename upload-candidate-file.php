<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['update'])) {

        $cid = ($_POST['candidateid']);
        $maxFileSize = 1048576; // 1 MB in bytes
        $error = "";

        // Check and process candidate photo
        if (!empty($_FILES['candidatephoto']['name'])) {
            if ($_FILES['candidatephoto']['size'] > $maxFileSize) {
                $error .= "Candidate photo must be less than 1 MB.<br>";
            } else {
                $candidatephoto = ($_FILES['candidatephoto']['name']);
                $candidatephototarget = 'doc/' . basename($candidatephoto);
                move_uploaded_file($_FILES['candidatephoto']['tmp_name'], $candidatephototarget);
            }
        }

        // Check and process Aadhaar photo
        if (!empty($_FILES['aadhaarphoto']['name'])) {
            if ($_FILES['aadhaarphoto']['size'] > $maxFileSize) {
                $error .= "Aadhaar photo must be less than 1 MB.<br>";
            } else {
                $aadhaarphoto = ($_FILES['aadhaarphoto']['name']);
                $aadhaarphototarget = 'doc/' . basename($aadhaarphoto);
                move_uploaded_file($_FILES['aadhaarphoto']['tmp_name'], $aadhaarphototarget);
            }
        }

        // Check and process qualification photo
        if (!empty($_FILES['qualificationphoto']['name'])) {
            if ($_FILES['qualificationphoto']['size'] > $maxFileSize) {
                $error .= "Qualification photo must be less than 1 MB.<br>";
            } else {
                $qualificationphoto = ($_FILES['qualificationphoto']['name']);
                $qualificationphototarget = 'doc/' . basename($qualificationphoto);
                move_uploaded_file($_FILES['qualificationphoto']['tmp_name'], $qualificationphototarget);
            }
        }

        // Check and process application photo
        if (!empty($_FILES['applicationphoto']['name'])) {
            if ($_FILES['applicationphoto']['size'] > $maxFileSize) {
                $error .= "Application photo must be less than 1 MB.<br>";
            } else {
                $applicationphoto = ($_FILES['applicationphoto']['name']);
                $applicationphototarget = 'doc/' . basename($applicationphoto);
                move_uploaded_file($_FILES['applicationphoto']['tmp_name'], $applicationphototarget);
            }
        }

        // Update database only if there are no errors
        if (empty($error)) {
            $sql = "UPDATE tblcandidate SET 
                candidatephoto=:candidatephoto, 
                aadhaarphoto=:aadhaarphoto, 
                qualificationphoto=:qualificationphoto, 
                applicationphoto=:applicationphoto
                WHERE CandidateId=:cid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':candidatephoto', $candidatephoto, PDO::PARAM_STR);
            $query->bindParam(':aadhaarphoto', $aadhaarphoto, PDO::PARAM_STR);
            $query->bindParam(':qualificationphoto', $qualificationphoto, PDO::PARAM_STR);
            $query->bindParam(':applicationphoto', $applicationphoto, PDO::PARAM_STR);
            $query->bindParam(':cid', $cid, PDO::PARAM_STR);
            $query->execute();

            $msg = "Data has been updated successfully.";
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
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-----End Top bar>
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
                                <h2 class="title">Update Candidate Document </h2>
                            </div>

                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Candidate</a></li>
                                    <li class="active">Update Candidate Document</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12" style="background-color: white;">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Update Candidate Document<?php echo $candidatephoto;
                                                                                ?></h5>
                                            </div>
                                        </div>
                                        <?php if (!empty($error)) { ?>
                                        <div class="alert alert-danger">
                                            <strong>Error!</strong> <?php echo $error; ?>
                                        </div>
                                        <?php } ?>
                                        <?php if (!empty($msg)) { ?>
                                        <div class="alert alert-success">
                                            <strong>Success!</strong> <?php echo $msg; ?>
                                        </div>
                                        <?php } ?>
                                        <form id="uploadForm" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="candidatephoto">Upload Photo</label>
                                                <input type="file" name="candidatephoto" id="candidatephoto" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="aadhaarphoto">Upload Aadhaar</label>
                                                <input type="file" name="aadhaarphoto" id="aadhaarphoto" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="qualificationphoto">Upload Qualification</label>
                                                <input type="file" name="qualificationphoto" id="qualificationphoto" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="applicationphoto">Upload Application</label>
                                                <input type="file" name="applicationphoto" id="applicationphoto" class="form-control">
                                            </div>
                                            <button type="button" id="uploadButton" class="btn btn-success">Upload</button>
                                        </form>
                                        <div id="uploadStatus"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-8 col-md-offset-2 -->
                        </div>
                        <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                </section>
                <!-- /.section -->
            </div>
            <!-- /.main-page -->
            <!-- /.right-sidebar -->
        </div>
        <!-- /.content-container -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- /.main-wrapper -->
    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>
<?php  } ?>