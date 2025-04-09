<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
    exit;
} else {
    if (isset($_POST['update'])) {
        $cid = ($_POST['candidateid']);
        $maxFileSize = 1048576; // 1 MB
        $error = "";
        $fieldsToUpdate = [];
        $params = [':cid' => $cid];

        // Handle file upload
        function handleFileUpload($fieldName, $label, $maxFileSize, &$fieldsToUpdate, &$params, &$error) {
            if (!empty($_FILES[$fieldName]['name'])) {
                if ($_FILES[$fieldName]['size'] > $maxFileSize) {
                    $error .= "$label must be less than 1 MB.<br>";
                } else {
                    $filename = basename($_FILES[$fieldName]['name']);
                    $targetPath = "doc/" . $filename;
                    if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $targetPath)) {
                        $fieldsToUpdate[] = "$fieldName = :$fieldName";
                        $params[":$fieldName"] = $filename;
                    } else {
                        $error .= "Failed to upload $label.<br>";
                    }
                }
            }
        }

        handleFileUpload('candidatephoto', 'Candidate Photo', $maxFileSize, $fieldsToUpdate, $params, $error);
        handleFileUpload('aadhaarphoto', 'Aadhaar Photo', $maxFileSize, $fieldsToUpdate, $params, $error);
        handleFileUpload('qualificationphoto', 'Qualification Photo', $maxFileSize, $fieldsToUpdate, $params, $error);
        handleFileUpload('applicationphoto', 'Application Photo', $maxFileSize, $fieldsToUpdate, $params, $error);

        if (empty($error) && count($fieldsToUpdate) > 0) {
            $sql = "UPDATE tblcandidate SET " . implode(', ', $fieldsToUpdate) . " WHERE CandidateId = :cid";
            $query = $dbh->prepare($sql);
            foreach ($params as $key => $value) {
                $query->bindParam($key, $value, PDO::PARAM_STR);
            }
            $query->execute();
            $msg = "Document(s) updated successfully.";
        } elseif (count($fieldsToUpdate) == 0) {
            $msg = "No new file selected. Nothing updated.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SOFTPRO | ADMIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Update Candidate Document</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li>Candidate</li>
                                    <li class="active">Update Candidate Document</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12" style="background-color: white;">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h5>Update Candidate Documents</h5>
                                        </div>
                                        <?php if (!empty($error)) { ?>
                                            <div class="alert alert-danger"><strong>Error!</strong> <?= $error; ?></div>
                                        <?php } ?>
                                        <?php if (!empty($msg)) { ?>
                                            <div class="alert alert-success"><strong>Success!</strong> <?= $msg; ?></div>
                                        <?php } ?>
                                        <form method="post" enctype="multipart/form-data">
                                            <?php
                                            $cid = intval($_GET['candidateid']);
                                            $sql = "SELECT * FROM tblcandidate WHERE CandidateId = :cid";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':cid', $cid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                            ?>
                                            <input type="hidden" name="candidateid" value="<?= $cid; ?>">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Full Name</label>
                                                    <?= htmlentities($result->candidatename); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Father Name</label>
                                                    <?= htmlentities($result->fathername); ?>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Aadhar Number</label>
                                                    <?= htmlentities($result->aadharnumber); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Phone Number</label>
                                                    <?= htmlentities($result->phonenumber); ?>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Upload Candidate Photo</label>
                                                    <input type="file" name="candidatephoto" class="form-control">
                                                    <?php if ($result->candidatephoto) echo "<small>Current: " . htmlentities($result->candidatephoto) . "</small>"; ?>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Upload Aadhaar</label>
                                                    <input type="file" name="aadhaarphoto" class="form-control">
                                                    <?php if ($result->aadhaarphoto) echo "<small>Current: " . htmlentities($result->aadhaarphoto) . "</small>"; ?>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Upload Qualification</label>
                                                    <input type="file" name="qualificationphoto" class="form-control">
                                                    <?php if ($result->qualificationphoto) echo "<small>Current: " . htmlentities($result->qualificationphoto) . "</small>"; ?>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Upload Application</label>
                                                    <input type="file" name="applicationphoto" class="form-control">
                                                    <?php if ($result->applicationphoto) echo "<small>Current: " . htmlentities($result->applicationphoto) . "</small>"; ?>
                                                </div>
                                            </div>
                                            <?php } } ?>
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <button type="submit" name="update" class="btn btn-success btn-labeled">
                                                        Update <span class="btn-label btn-label-right"><i class="fa fa-check"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div> <!-- panel -->
                                </div> <!-- col -->
                            </div> <!-- row -->
                        </div>
                    </section>
                </div> <!-- main-page -->
            </div> <!-- content-container -->
        </div> <!-- content-wrapper -->
    </div> <!-- main-wrapper -->

    <!-- JS Files -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<?php } ?>
