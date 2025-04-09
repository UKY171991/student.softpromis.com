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

        // Fetch existing file names from the database
        $sql = "SELECT candidatephoto, aadhaarphoto, qualificationphoto, applicationphoto FROM tblcandidate WHERE CandidateId = :cid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        // Initialize variables for SQL update
        $updateFields = [];
        $updateParams = [':cid' => $cid];

        // Check and process candidate photo
        if (!empty($_FILES['candidatephoto']['name'])) {
            if ($_FILES['candidatephoto']['size'] > $maxFileSize) {
                $error .= "Candidate photo must be less than 1 MB.<br>";
            } else {
                // Delete the old file if it exists
                if (!empty($result->candidatephoto) && file_exists('doc/' . $result->candidatephoto)) {
                    unlink('doc/' . $result->candidatephoto);
                }
                $candidatephoto = ($_FILES['candidatephoto']['name']);
                $candidatephototarget = 'doc/' . basename($candidatephoto);
                if (move_uploaded_file($_FILES['candidatephoto']['tmp_name'], $candidatephototarget)) {
                    $updateFields[] = "candidatephoto = :candidatephoto";
                    $updateParams[':candidatephoto'] = $candidatephoto;
                } else {
                    $error .= "Failed to upload candidate photo.<br>";
                }
            }
        }

        // Check and process Aadhaar photo
        if (!empty($_FILES['aadhaarphoto']['name'])) {
            if ($_FILES['aadhaarphoto']['size'] > $maxFileSize) {
                $error .= "Aadhaar photo must be less than 1 MB.<br>";
            } else {
                // Delete the old file if it exists
                if (!empty($result->aadhaarphoto) && file_exists('doc/' . $result->aadhaarphoto)) {
                    unlink('doc/' . $result->aadhaarphoto);
                }
                $aadhaarphoto = ($_FILES['aadhaarphoto']['name']);
                $aadhaarphototarget = 'doc/' . basename($aadhaarphoto);
                if (move_uploaded_file($_FILES['aadhaarphoto']['tmp_name'], $aadhaarphototarget)) {
                    $updateFields[] = "aadhaarphoto = :aadhaarphoto";
                    $updateParams[':aadhaarphoto'] = $aadhaarphoto;
                } else {
                    $error .= "Failed to upload Aadhaar photo.<br>";
                }
            }
        }

        // Check and process qualification photo
        if (!empty($_FILES['qualificationphoto']['name'])) {
            if ($_FILES['qualificationphoto']['size'] > $maxFileSize) {
                $error .= "Qualification photo must be less than 1 MB.<br>";
            } else {
                // Delete the old file if it exists
                if (!empty($result->qualificationphoto) && file_exists('doc/' . $result->qualificationphoto)) {
                    unlink('doc/' . $result->qualificationphoto);
                }
                $qualificationphoto = ($_FILES['qualificationphoto']['name']);
                $qualificationphototarget = 'doc/' . basename($qualificationphoto);
                if (move_uploaded_file($_FILES['qualificationphoto']['tmp_name'], $qualificationphototarget)) {
                    $updateFields[] = "qualificationphoto = :qualificationphoto";
                    $updateParams[':qualificationphoto'] = $qualificationphoto;
                } else {
                    $error .= "Failed to upload qualification photo.<br>";
                }
            }
        }

        // Check and process application photo
        if (!empty($_FILES['applicationphoto']['name'])) {
            if ($_FILES['applicationphoto']['size'] > $maxFileSize) {
                $error .= "Application photo must be less than 1 MB.<br>";
            } else {
                // Delete the old file if it exists
                if (!empty($result->applicationphoto) && file_exists('doc/' . $result->applicationphoto)) {
                    unlink('doc/' . $result->applicationphoto);
                }
                $applicationphoto = ($_FILES['applicationphoto']['name']);
                $applicationphototarget = 'doc/' . basename($applicationphoto);
                if (move_uploaded_file($_FILES['applicationphoto']['tmp_name'], $applicationphototarget)) {
                    $updateFields[] = "applicationphoto = :applicationphoto";
                    $updateParams[':applicationphoto'] = $applicationphoto;
                } else {
                    $error .= "Failed to upload application photo.<br>";
                }
            }
        }

        // Update the database only if there are fields to update
        if (!empty($updateFields)) {
            $sql = "UPDATE tblcandidate SET " . implode(", ", $updateFields) . " WHERE CandidateId = :cid";
            $query = $dbh->prepare($sql);
            foreach ($updateParams as $param => $value) {
                $query->bindParam($param, $value, PDO::PARAM_STR);
            }
            $query->execute();
            $msg = "Data has been updated successfully.";
        } else {
            $msg = "No files were uploaded.";
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
                                        <form method="post" enctype="multipart/form-data">
                                            <?php
                                                $cid = intval($_GET['candidateid']);
                                                $sql = "SELECT * from tblcandidate where CandidateId=:cid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':cid', $cid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {   ?>
                                            <input type="hidden" name="candidateid" value="<?php echo $cid; ?>">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="candidatename">Full Name</label>
                                                    <?php echo htmlentities($result->candidatename); ?>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="fathername">Father Name</label>
                                                    <?php echo htmlentities($result->fathername); ?>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="aadharnumber">Aadhar Number</label>
                                                    <?php echo htmlentities($result->aadharnumber); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="aadharnumber">Phone Number</label>
                                                    <?php echo htmlentities($result->phonenumber); ?>
                                                </div>
                                            </div>
                                                
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="candidatephoto">Upload Photo</label>
                                                        <input type="file" name="candidatephoto" class="form-control" value="<?php echo htmlentities($result->candidatephoto); ?>"
                                                            id="candidatephoto">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="aadharnumber">Upload Aadhaar </label>
                                                        <input type="file" name="aadhaarphoto" class="form-control"
                                                            id="aadhar">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="aadharnumber">Upload Education</label>
                                                        <input type="file" name="qualificationphoto"
                                                            class="form-control" id="qualificationphoto">
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="aadharnumber">Upload Application</label>
                                                            <input type="file" name="applicationphoto"
                                                                class="form-control" id="applicationphoto">
                                                        </div>
                                                        
                                                    </div>


                                                </div>
                                            </div>


                                            <?php }
                                                } ?>
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <button type="submit" name="update"
                                                        class="btn btn-success btn-labeled">Update<span
                                                            class="btn-label btn-label-right"><i
                                                                class="fa fa-check"></i></span></button>
                                                </div>
                                            </div>
                                        </form>
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