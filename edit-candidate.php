<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

    if (isset($_POST['update'])) {

        $cid = ($_POST['candidateid']);
        $candidatename = $_POST['candidatename'];
        $fathername = $_POST['fathername'];
        $aadharnumber = $_POST['aadharnumber'];
        $phonenumber = $_POST['phonenumber'];
        $phonenumber2 = $_POST['phonenumber2'];
        //$qualification = $_POST['qualification'];
        
        $dateofbirth = $_POST['dateofbirth'];
        // Split the input date into parts using explode
        $dateParts = explode('-', $dateofbirth); // [21, 01, 2025]
        
        // Rearrange the parts to match YYYY-MM-DD format
        $dateofbirth = implode('-', array_reverse($dateParts)); // [2025, 01, 21]

        $gender = $_POST['gender'];
        $maritalstatus = $_POST['maritalstatus'];
        $religion = $_POST['religion'];
        $category = $_POST['category'];
        $village = $_POST['village'];
        $mandal = $_POST['mandal'];
        $district = $_POST['district'];
        $state = $_POST['state'];
        $pincode = $_POST['pincode'];

        $training_center = $_POST['training_center'];
        $scheme = $_POST['scheme'];
        $sector = $_POST['sector'];
        $job_roll = $_POST['job_roll'];
        $batch = $_POST['batch'];

        $status = 1;

        $sql = "UPDATE tblcandidate SET candidatename=:candidatename, fathername=:fathername, aadharnumber=:aadharnumber, phonenumber=:phonenumber, dateofbirth=:dateofbirth, gender=:gender, maritalstatus=:maritalstatus, religion=:religion, category=:category, village=:village,
    mandal=:mandal, district=:district, state=:state, pincode=:pincode, training_center=:training_center, scheme=:scheme, sector=:sector, job_roll=:job_roll, batch=:batch
    WHERE CandidateId=:cid";
    $query = $dbh->prepare($sql);

    $query->bindParam(':candidatename', $candidatename, PDO::PARAM_STR);
    $query->bindParam(':fathername', $fathername, PDO::PARAM_STR);
    $query->bindParam(':aadharnumber', $aadharnumber, PDO::PARAM_STR);
    $query->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
    $query->bindParam(':dateofbirth', $dateofbirth, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':maritalstatus', $maritalstatus, PDO::PARAM_STR);
    $query->bindParam(':religion', $religion, PDO::PARAM_STR);
    $query->bindParam(':category', $category, PDO::PARAM_STR);
    $query->bindParam(':village', $village, PDO::PARAM_STR);
    $query->bindParam(':mandal', $mandal, PDO::PARAM_STR);
    $query->bindParam(':district', $district, PDO::PARAM_STR);
    $query->bindParam(':state', $state, PDO::PARAM_STR);
    $query->bindParam(':pincode', $pincode, PDO::PARAM_STR);
    $query->bindParam(':training_center', $training_center, PDO::PARAM_INT);
    $query->bindParam(':scheme', $scheme, PDO::PARAM_INT);
    $query->bindParam(':sector', $sector, PDO::PARAM_INT);
    $query->bindParam(':job_roll', $job_roll, PDO::PARAM_INT);
    $query->bindParam(':batch', $batch, PDO::PARAM_INT);

    // IMPORTANT FIX: Bind the candidate ID
    $query->bindParam(':cid', $cid, PDO::PARAM_INT);

    // Execute the query and check for success
    if ($query->execute()) {
        $msg = "Data has been updated successfully";
        echo '<script> setTimeout(function() { window.location.href = "payment.php?last_id=' . $cid . '"; }, 2000); </script>';
    } else {
        $error = "An error occurred while updating data.";
    }

    }



    ///  last five column data for  select

    // SQL query to fetch the last tbltrainingcenter
    $sql1 = "SELECT TrainingcenterId, trainingcentername FROM tbltrainingcenter ORDER BY TrainingcenterId DESC";
    $query1 = $dbh->prepare($sql1);
    $query1->execute();
    $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);

    // SQL query to fetch the last tblscheme
    $sql2 = "SELECT SchemeId, SchemeName FROM tblscheme ORDER BY SchemeId DESC";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    // SQL query to fetch the last tblsector
    $sql3 = "SELECT SectorId, SectorName FROM tblsector ORDER BY SectorId DESC";
    $query3 = $dbh->prepare($sql3);
    $query3->execute();
    $result3 = $query3->fetchAll(PDO::FETCH_ASSOC);

    // SQL query to fetch the last tbljobroll
    $sql4 = "SELECT JobrollId, jobrollname FROM tbljobroll ORDER BY JobrollId DESC";
    $query4 = $dbh->prepare($sql4);
    $query4->execute();
    $result4 = $query4->fetchAll(PDO::FETCH_ASSOC);

    // SQL query to fetch the last tblbatch
    $sql5 = "SELECT id, batch_name FROM tblbatch ORDER BY id DESC";
    $query5 = $dbh->prepare($sql5);
    $query5->execute();
    $result5 = $query5->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-----End Top bar-->
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
                                <h2 class="title">Update Candidate Details </h2>
                            </div>

                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Candidate</a></li>
                                    <li class="active">Update Candidate</li>
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
                                                <h5>Update Candidate info<?php echo $candidatephoto;
                                                                                ?></h5>
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
                                                    <label for="enrollmentid">Enrollment ID</label>
                                                    <input type="text" name="enrollmentid" class="form-control"
                                                        id="enrollmentid"
                                                        value="<?php echo htmlentities($result->enrollmentid); ?>" readonly>
                                                </div>
                                                
                                                <div class="form-group col-md-6">
                                                    <label for="candidatename">Full Name</label>
                                                    <input type="text" name="candidatename" class="form-control"
                                                        id="candidatename"
                                                        value="<?php echo htmlentities($result->candidatename); ?>">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="fathername">Father Name</label>
                                                    <input type="text" name="fathername" class="form-control"
                                                        id="fathername"
                                                        value="<?php echo htmlentities($result->fathername); ?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="aadharnumber">Aadhar Number</label>
                                                    <input type="number" name="aadharnumber"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        maxlength="12" class="form-control" id="aadharnumber"
                                                        value="<?php echo htmlentities($result->aadharnumber); ?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="phonenumber">Phone Number</label>
                                                    <input type="number" name="phonenumber"
                                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                        maxlength="10" class="form-control" id="phonenumber"
                                                        value="<?php echo htmlentities($result->phonenumber); ?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="email">Email</label>
                                                    <input type="number" name="email"
                                                    class="form-control" id="email"
                                                    value="<?php echo htmlentities($result->email); ?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                
                                                <?php 
                                                
                                                    $dob = $result->dateofbirth; // Example input date in DD-MM-YY format

                                                    $dateInput = "21-01-2025"; // Example input date in DD-MM-YYYY format
                                                    
                                                    // Split the input date into parts using explode
                                                    $dateParts = explode('-', $dob); // [21, 01, 2025]
                                                    
                                                    // Rearrange the parts to match YYYY-MM-DD format
                                                    $correctedDate = implode('-', array_reverse($dateParts)); // [2025, 01, 21]
                                                ?>
                                                

                                                <div class="form-group col-md-4">
                                                    <label for="dateofbirth">Date of Birth</label>
                                                    <input type="text" name="dateofbirth" class="form-control"
                                                        id="dateofbirth"
                                                        value="<?php echo $correctedDate ?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="gender">Gender</label>
                                                    <select id="gender" name="gender" class="form-control">
                                                        <option selected><?php echo htmlentities($result->gender); ?>
                                                        </option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                        <option>Other</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="maritalstatus">Marital Status</label>
                                                    <select id="maritalstatus" name="maritalstatus"
                                                        class="form-control">
                                                        <option selected>
                                                            <?php echo htmlentities($result->maritalstatus); ?></option>
                                                        <option>Married</option>
                                                        <option>Un Married</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="religion">Religion</label>
                                                    <select id="religion" name="religion" class="form-control">
                                                        <option selected><?php echo htmlentities($result->religion); ?>
                                                        </option>
                                                        <option>Hindu</option>
                                                        <option>Muslim</option>
                                                        <option>Christian</option>
                                                        <option>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="category">Category</label>
                                                    <select id="category" name="category" class="form-control">
                                                        <option selected><?php echo htmlentities($result->category); ?>
                                                        </option>
                                                        <option>BC-A</option>
                                                        <option>BC-B</option>
                                                        <option>BC-C</option>
                                                        <option>BC-D</option>
                                                        <option>BC-E</option>
                                                        <option>EBC</option>
                                                        <option>Minorities</option>
                                                        <option>Other</option>
                                                        <option>OC</option>
                                                        <option>SC</option>
                                                        <option>ST</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="village">Village</label>
                                                    <input type="text" name="village" class="form-control" id="village"
                                                        value="<?php echo htmlentities($result->village); ?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="mandal">Mandal</label>
                                                    <input type="text" name="mandal" class="form-control" id="mandal"
                                                        value="<?php echo htmlentities($result->mandal); ?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="district">District</label>
                                                    <select id="district" name="district" class="form-control">
                                                        <option selected><?php echo htmlentities($result->district); ?>
                                                        </option>
                                                        <option>Alluri Sitharama Raju</option>
                                                        <option>Anakapalli</option>
                                                        <option>Anantapur</option>
                                                        <option>Annamayya</option>
                                                        <option>Bapatla</option>
                                                        <option>Chittoor</option>
                                                        <option>Dr. B. R. Ambedkar</option>
                                                        <option>East Godavari</option>
                                                        <option>Eluru</option>
                                                        <option>Guntur</option>
                                                        <option>Kakinada</option>
                                                        <option>Krishna</option>
                                                        <option>Kurnool</option>
                                                        <option>Nandyal</option>
                                                        <option>NTR</option>
                                                        <option>Palnadu</option>
                                                        <option>Parvathipuram Manyam</option>
                                                        <option>Prakasam</option>
                                                        <option>Sri Potti Sriramulu Nellore</option>
                                                        <option>Sri Sathya Sai</option>
                                                        <option>Srikakulam</option>
                                                        <option>Tirupati</option>
                                                        <option>Visakhapatnam</option>
                                                        <option>Vizianagaram</option>
                                                        <option>West Godavari</option>
                                                        <option>YSR (Kadapa)</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="state">State</label>
                                                    <select id="state" name="state" class="form-control">
                                                        <option selected><?php echo htmlentities($result->state); ?>
                                                        </option>
                                                        <option>Andhra Pradesh</option>
                                                        <option>Orissa</option>
                                                        <option>Telangana</option>
                                                        <option>Delhi</option>
                                                        <option>Jammu & Kashmir</option>
                                                        <option>Kerala</option>
                                                        <option>Arunachal Pradesh</option>
                                                        <option>Maharastra</option>
                                                        <option>Goa</option>
                                                        <option>Rajastan</option>
                                                        <option>Gujarat</option>
                                                        <option>Uttarakand</option>
                                                        <option>Uttar Pradesh</option>
                                                        <option>Assam</option>
                                                        <option>Tiruvanantapur</option>
                                                        <option>Meghalaya</option>
                                                        <option>Sikkim</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="pincode">Pin Code</label>
                                                    <input type="number" name="pincode" class="form-control" id="pincode" placeholder="Pin Code" maxlength="6" oninput="this.value = this.value.slice(0, 6)" value="<?php echo htmlentities($result->pincode); ?>" required>
                                                </div>
                                                

                                                </div>
                                            </div>


                                            <?php }
                                                } ?>

                                            <div class="form-row">

                                                <div class="form-group col-md-12"><hr></div>

                                                <div class="form-group col-md-12">
                                                    <div class="panel-title">
                                                        <h5>Job Information</h5>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="" id="training_center_id" value="<?=$result->TrainingcenterId?>">

                                                <div class="form-group col-md-4">
                                                    <label for="training_center">Training Center</label>
                                                    <select id="training_center" name="training_center" class="form-control js-example-basic-single" required>
                                                        <option>Select</option>
                                                        <?php 
                                                        foreach ($result1 as $row1) { ?>
                                                            <option <?=($result->training_center == $row1['TrainingcenterId']) ? "selected" : "";?> value="<?=$row1['TrainingcenterId']; ?>"><?=$row1['trainingcentername']?></option>
                                                        <?php } ?>
                                                        
                                                    </select>
                                                </div>

                                                <input type="hidden" name="" id="scheme_id" value="<?=$result->scheme?>">

                                                <div class="form-group col-md-4">
                                                    <label for="scheme">Scheme</label>
                                                    <select id="scheme" name="scheme" class="form-control js-example-basic-single" required>
                                                        <option>Select</option>
                                                        <?php 
                                                        foreach ($result2 as $row2) { ?>
                                                            <option <?=($result->scheme == $row2['SchemeId']) ? "selected" : "";?> value="<?=$row2['SchemeId']; ?>"><?=$row2['SchemeName']?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <input type="hidden" name="" id="sector_id" value="<?=$result->sector?>">

                                                <div class="form-group col-md-4">
                                                    <label for="sector">Sector</label>
                                                    <select id="sector" name="sector" class="form-control js-example-basic-single" required>
                                                        <option>Select</option>
                                                        <?php 
                                                        foreach ($result3 as $row3) { ?>
                                                            <option <?=($result->sector == $row3['SectorId']) ? "selected" : "";?> value="<?=$row3['SectorId']; ?>"><?=$row3['SectorName']?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <input type="hidden" name="" id="job_roll_id" value="<?=$result->job_roll?>">

                                                <div class="form-group col-md-4">
                                                    <label for="job_roll">Job Roll</label>
                                                    <select id="job_roll" name="job_roll" class="form-control js-example-basic-single" required>
                                                        <option>Select</option>
                                                        <?php 
                                                        foreach ($result4 as $row4) { ?>
                                                            <option <?=($result->job_roll == $row4['JobrollId']) ? "selected" : "";?> value="<?=$row4['JobrollId']; ?>"><?=$row4['jobrollname']?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <input type="hidden" name="" id="batch_selected_id" value="<?=$result->batch?>">
                                                

                                                <div class="form-group col-md-4">
                                                    <label for="batch">Batch</label>
                                                    <select id="batch" name="batch" class="form-control js-example-basic-single" required>
                                                        <option>Select</option>
                                                        <?php 
                                                        foreach ($result5 as $row5) { ?>
                                                            <option <?=($result->batch == $row5['id']) ? "selected" : "";?> value="<?=$row5['id']; ?>"><?=$row5['batch_name']?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>


                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-12">
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
    <script src="js/select2/select2.min.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    
    <script>
        $(function () {
          $("#dateofbirth").datepicker({
            dateFormat: "dd-mm-yy", // Sets the format to DD-MM-YYYY
            changeMonth: true,      // Allows changing months
            changeYear: true,       // Allows changing years
            yearRange: "1900:2100", // Sets the year range
          });
        });
      </script>



      <script>
$(document).ready(function(){
    $('#village,#mandal').on('keyup', function(){
        var value = $(this).val().toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
        $(this).val(value);
    });
});


// In your Javascript (external .js resource or <script> tag)
// $(document).ready(function() {
//     $('.js-example-basic-single').select2();
// });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#job_roll').change(function() {
            var job_id = $(this).val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: {job_id: job_id},
                dataType: 'json',
                success: function(response) {
                    $('#batch').empty().append('<option selected disabled>Select Batch</option>');
                    if (response.length > 0) {
                        $.each(response, function(index, batch) {
                            $('#batch').append('<option value="' + batch.id + '">' + batch.batch_name + '</option>');
                        });
                    } else {
                        $('#batch').append('<option disabled>No batches available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading batches: " + error);
                }
            });
        });
    });

    $(document).ready(function() {
        $(window).on('load', function() {
            var job_id = $('#job_roll').val();
            var batch_selected_id = $('#batch_selected_id').val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: { job_id: job_id },
                dataType: 'json',
                success: function(response) {
                    $('#batch').empty().append('<option selected disabled>Select Batch</option>');
                    
                    if (response.length > 0) {
                        $.each(response, function(index, batch) {
                            // Fix here: declare 'selected' properly
                            var selected = (batch_selected_id == batch.id) ? 'selected' : '';
                            
                            $('#batch').append(
                                '<option value="' + batch.id + '" ' + selected + '>' + batch.batch_name + '</option>'
                            );
                        });
                    } else {
                        $('#batch').append('<option disabled>No batches available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading batches: " + error);
                }
            });
        });
    });

</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#training_center').change(function() {
            var job_id = $(this).val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: {training_center: training_center},
                dataType: 'json',
                success: function(response) {
                    $('#scheme').empty().append('<option selected disabled>Select Batch</option>');
                    if (response.length > 0) {
                        $.each(response, function(index, scheme) {
                            $('#scheme').append('<option value="' + scheme.SchemeId + '">' + scheme.SchemeName + '</option>');
                        });
                    } else {
                        $('#scheme').append('<option disabled>No batches available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading batches: " + error);
                }
            });
        });
    });

    $(document).ready(function() {
        $(window).on('load', function() {
            var training_center = $('#training_center').val();
            var training_center_id = $('#training_center_id').val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: { training_center: training_center },
                dataType: 'json',
                success: function(response) {
                    $('#scheme').empty().append('<option selected disabled>Select Batch</option>');
                    
                    if (response.length > 0) {
                        $.each(response, function(index, scheme) {
                            // Fix here: declare 'selected' properly
                            var selected = (batch_selected_id == scheme.id) ? 'selected' : '';
                            
                            $('#scheme').append(
                                '<option value="' + scheme.SchemeId + '" ' + selected + '>' + scheme.SchemeName + '</option>'
                            );
                        });
                    } else {
                        $('#scheme').append('<option disabled>No batches available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading batches: " + error);
                }
            });
        });
    });

</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#scheme').change(function() {
            var job_id = $(this).val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: {scheme: scheme},
                dataType: 'json',
                success: function(response) {
                    $('#sector').empty().append('<option selected disabled>Select sector</option>');
                    if (response.length > 0) {
                        $.each(response, function(index, sector) {
                            $('#sector').append('<option value="' + sector.SectorId + '">' + sector.SectorName + '</option>');
                        });
                    } else {
                        $('#sector').append('<option disabled>No sector available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading sector: " + error);
                }
            });
        });
    });

    $(document).ready(function() {
        $(window).on('load', function() {
            var scheme = $('#scheme').val();
            var scheme_id = $('#scheme_id').val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: { scheme: scheme },
                dataType: 'json',
                success: function(response) {
                    $('#sector').empty().append('<option selected disabled>Select Batch</option>');
                    
                    if (response.length > 0) {
                        $.each(response, function(index, sector) {
                            // Fix here: declare 'selected' properly
                            var selected = (batch_selected_id == sector.id) ? 'selected' : '';
                            
                            $('#sector').append(
                                '<option value="' + sector.SectorId + '" ' + selected + '>' + sector.SectorName + '</option>'
                            );
                        });
                    } else {
                        $('#sector').append('<option disabled>No sector available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading sector: " + error);
                }
            });
        });
    });

</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#sector').change(function() {
            var sector = $(this).val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: {sector: sector},
                dataType: 'json',
                success: function(response) {
                    $('#job_roll').empty().append('<option selected disabled>Select job roll</option>');
                    if (response.length > 0) {
                        $.each(response, function(index, job_roll) {
                            $('#job_roll').append('<option value="' + job_roll.SectorId + '">' + job_roll.SectorName + '</option>');
                        });
                    } else {
                        $('#job_roll').append('<option disabled>No job roll available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading job roll: " + error);
                }
            });
        });
    });

    $(document).ready(function() {
        $(window).on('load', function() {
            var sector = $('#sector').val();
            var sector_id = $('#sector_id').val();

            $.ajax({
                url: 'get_batches.php',
                type: 'POST',
                data: { sector: sector },
                dataType: 'json',
                success: function(response) {
                    $('#job_roll').empty().append('<option selected disabled>Select Batch</option>');
                    
                    if (response.length > 0) {
                        $.each(response, function(index, job_roll) {
                            // Fix here: declare 'selected' properly
                            var selected = (batch_selected_id == job_roll.id) ? 'selected' : '';
                            
                            $('#job_roll').append(
                                '<option value="' + job_roll.JobrollId + '" ' + selected + '>' + job_roll.jobrollname + '</option>'
                            );
                        });
                    } else {
                        $('#job_roll').append('<option disabled>No job roll available</option>');
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error loading job roll: " + error);
                }
            });
        });
    });

</script>



    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>
<?php  } ?>