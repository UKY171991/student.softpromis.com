<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else { 

    $last_id = $_GET['last_id'];



    $candidate_id = $last_id;




    $checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
    $checkQuery->execute();
    
    // Fetch all rows associated with the candidate_id
    $result = $checkQuery->fetchAll(PDO::FETCH_ASSOC);

    $Balance_val = $row['total_fee'];
    $total_fee= $row['total_fee'];

    if (!empty($result)) {
        // Candidate exists, show the data
        foreach ($result as $row) {
            $Discount_val = $row['discount'];
            $Paid_val = $row['paid'];
            $total_fee= $row['total_fee'];
            if($row['balance'] == ''){
                $Balance_val = $row['total_fee'];
            }else{
                $Balance_val = $row['balance'];
            }
            
            
        }
    } else {
        
        $Discount_val = '0';
        $Paid_val = '0';
        $total_fee = '0';
    }

    if (isset($_POST['submit'])) {



    $enrollmentid = $_POST['enrollmentid'];
    $candidate_id = $_POST['candidate_id'];
    $discount = $_POST['discount']+$Discount_val;
    $paid = $_POST['paid'];
    $balance = $_POST['balance'];
    $total_fee = $_POST['total_fee'];
    $created_at = date("Y-m-d H:i:s"); // Current timestamp


    try {
        // Check if record exists
        $checkSql = "SELECT COUNT(*) as count FROM payment WHERE enrollmentid = :enrollmentid AND candidate_id = :candidate_id";
        $checkQuery = $dbh->prepare($checkSql);
        $checkQuery->bindParam(':enrollmentid', $enrollmentid, PDO::PARAM_STR);
        $checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $checkQuery->execute();
        $recordExists = $checkQuery->fetch(PDO::FETCH_ASSOC)['count'] > 0;

        if ($recordExists) {


            $balance = $_POST['balance'];
            
            $paid = $_POST['total_fee'] - $_POST['balance'];

            if($total_fee == $paid){
                $status = "Paid";
            }else{
                $status = "Pending";
            }

             // Update existing record
            $updateSql = "UPDATE payment 
                          SET discount = :discount, paid = :paid, balance = :balance, created_at = :created_at,status=:status ,added_type=:added_type
                          WHERE candidate_id = :candidate_id";

            $updateQuery = $dbh->prepare($updateSql);

            // Bind parameters
            $updateQuery->bindParam(':discount', $discount, PDO::PARAM_STR); // Adjust type if needed
            $updateQuery->bindParam(':paid', $paid, PDO::PARAM_STR);
            $updateQuery->bindParam(':balance', $balance, PDO::PARAM_STR);
            $updateQuery->bindParam(':created_at', $created_at, PDO::PARAM_STR);
            $updateQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT); // Ensure candidate_id is bound
            $updateQuery->bindParam(':status', $status, PDO::PARAM_STR); // Ensure candidate_id is bound
            $updateQuery->bindParam(':added_type', $_SESSION['user_type'], PDO::PARAM_STR); // Ensure candidate_id is bound

            // Execute the query
            $updateQuery->execute();

            $paid = $_POST['discount'] + $_POST['paid'];
            $insertSql = "INSERT INTO emi_list (candidate_id, paid, created,added_type ) VALUES ( :candidate_id, :paid, :created,:added_type )";
            $insertQuery = $dbh->prepare($insertSql);
            $insertQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $insertQuery->bindParam(':paid', $paid, PDO::PARAM_STR);
            $insertQuery->bindParam(':created', $created, PDO::PARAM_STR);
            $insertQuery->bindParam(':added_type', $_SESSION['user_type'], PDO::PARAM_STR);
            $insertQuery->execute();


            // Check if any row was updated
            if ($updateQuery->rowCount() > 0) {
                //echo "Record updated successfully.";

                echo "<script>alert('Payment  updated')</script>";
                echo "<script>window.location.href = window.location.href;</script>";
            } else {
                echo "No record updated. Please check if candidate_id exists.";
            }
        } else {
            //$balance = $total_fee-($_POST['paid']);
            $balance = $_POST['balance'];
            //$paid = $Paid_val+$_POST['paid']+$_POST['discount'];
            $paid = $_POST['total_fee'] - $_POST['balance'];
            // Insert new record
            $insertSql = "INSERT INTO payment (
                enrollmentid, candidate_id, discount, paid, balance, total_fee, created_at,added_type
            ) VALUES (
                :enrollmentid, :candidate_id, :discount, :paid, :balance, :total_fee, :created_at,:added_type
            )";
            $insertQuery = $dbh->prepare($insertSql);
            $insertQuery->bindParam(':enrollmentid', $enrollmentid, PDO::PARAM_STR);
            $insertQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $insertQuery->bindParam(':discount', $discount, PDO::PARAM_STR);
            $insertQuery->bindParam(':paid', $paid, PDO::PARAM_STR);
            $insertQuery->bindParam(':balance', $balance, PDO::PARAM_STR);
            $insertQuery->bindParam(':total_fee', $total_fee, PDO::PARAM_STR);
            $insertQuery->bindParam(':created_at', $created_at, PDO::PARAM_STR);
            $insertQuery->bindParam(':added_type', $_SESSION['user_type'], PDO::PARAM_STR);
            $insertQuery->execute();

            $lastInsertId = $dbh->lastInsertId();

            $paid = $_POST['discount'] + $_POST['paid'];

            $insertSql = "INSERT INTO emi_list (candidate_id, paid, created ,added_type) VALUES ( :candidate_id, :paid, :created ,:added_type)";
            $insertQuery = $dbh->prepare($insertSql);
            $insertQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $insertQuery->bindParam(':paid', $paid, PDO::PARAM_STR);
            $insertQuery->bindParam(':created', $created, PDO::PARAM_STR);
            $insertQuery->bindParam(':added_type', $_SESSION['user_type'], PDO::PARAM_STR);
            $insertQuery->execute();

            echo "<script>alert('Record inserted successfully')</script>";
            echo "<script>window.location.href = window.location.href;</script>";


            echo "Record inserted successfully. Last Insert ID: " . $lastInsertId;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
    
    // SQL query to fetch the last enrollmentid
    $sql = "SELECT * FROM tblcandidate WHERE CandidateId = '$last_id' "; // Replace 'id' with the actual primary key or a unique column
    
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);

    //print_r($results); die;
    
    // Check if a result was found
    if ($results) {
        $enroll = $results['enrollmentid'];
    } else {
        $enroll = "No records found.";
    }


    $last_id = $_GET['last_id'];
    // SQL query to fetch the last enrollmentid
    $sql1 = "SELECT CandidateId,jobid FROM tblcandidate WHERE CandidateId = '$last_id' "; // Replace 'id' with the 
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $jobid = $result['job_roll'];


    // SQL query to fetch the last tbljobroll
    $sql4 = "SELECT JobrollId, payment FROM tbljobroll WHERE JobrollId = :jobid";
    $query4 = $dbh->prepare($sql4);

    // Bind parameter to prevent SQL injection
    $query4->bindParam(':jobid', $jobid, PDO::PARAM_INT);

    // Execute the query
    $query4->execute();

    // Fetch the first row
    $result4 = $query4->fetch(PDO::FETCH_ASSOC);

    if ($result4 && isset($result4['payment'])) {
        $payment_val = $result4['payment'];
        if($total_fee =='0'){
            $Balance_val = $result4['payment'];
        }

    } else {
        echo "No payment record found for JobrollId: " . htmlspecialchars($jobid);
    }


    $candidate_id = $last_id;
    $checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
    $checkQuery->execute();
    
    // Fetch all rows associated with the candidate_id
    $result_new = $checkQuery->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result_new)) {
        // Candidate exists, show the data
        foreach ($result_new as $row) {
            $Discount_val = '0';//$row['discount'];
            $Paid_val = $row['paid'];
            $total_fee= $row['total_fee'];
            //if($row['balance'] == ''){
             //   $Balance_val = $row['total_fee'];
            //}else{
                $Balance_val = $row['balance'];
            //}
            
            
        }
    }


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/mystyle.css">
    <script src="js/modernizr/modernizr.min.js"></script>

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
                                <h2 class="title">Candidate Payment</h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>

                                    <li class="active">Candidate Payment</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="container-fluid">
                        <?php // print_r($results);?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Fill the Payment info</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($msg) { ?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                        </div><?php } else if ($error) { ?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="candidate_id"  required="required" value="<?=$_GET['last_id']?>">

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="enrollmentid">Enrollment ID</label>
                                                    <input type="text" name="enrollmentid" class="form-control"
                                                        id="enrollmentid" required="required"
                                                        placeholder="Enrollment ID" value="<?=$enroll?>">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="created_at">Created Date</label>
                                                    <input type="text" name="created_at" class="form-control"
                                                        id="created_at" required="required"
                                                        placeholder="Created Date" value="<?=$results['DateCreated']; ?>">
                                                </div>
                                                
                                                <div class="form-group col-md-6">
                                                    <label for="candidatename">Full Name</label>
                                                    <input type="text" name="candidatename" class="form-control"
                                                        id="candidatename" required="required"
                                                        placeholder="Enter Full Name" value="<?=$results['candidatename']; ?>">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="fathername">Father Name</label>
                                                    <input type="text" name="fathername" required="required"
                                                        class="form-control" id="fathername"
                                                        placeholder="Enter Father Name" value="<?=$results['fathername']; ?>">
                                                </div>
                                            </div>

                                        
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="village">Village</label>
                                                    <input type="text" name="village" class="form-control" id="village"
                                                        placeholder="Village" value="<?=$results['village']; ?>">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="total_fee">Total Fee</label>
                                                    <input type="text" name="total_fee" class="form-control" id="total_fee"
                                                        placeholder="Total Fee" value="<?=$payment_val?>" readonly>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="discount">Discount</label>
                                                    <input type="number" name="discount" class="form-control" id="discount"
                                                        placeholder="Discount" value="0">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="paid">Paid</label>
                                                    <input type="number" name="paid" class="form-control" id="paid"
                                                        placeholder="Paid" value="0">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="balance">Balance</label>
                                                    <input type="text" name="balance" class="form-control" id="balance"
                                                        placeholder="Balance" value="<?=$Balance_val?>">

                                                        <input type="hidden" name="" class="form-control" id="balance_total"
                                                        placeholder="Balance" value="<?=$Balance_val?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-12">

                                                    <button type="submit" name="submit" class="btn btn-primary">Make Payment</button>
                                                    <a href="manage-candidate.php" class="btn btn-danger">Skip</a>

                                                    <button type="button" class="btn btn-success" onClick='p_all_data(<?php echo $last_id; ?>)' data-toggle="modal" data-target="#p_myModal">Print</td></button>

                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>


        <?php
        // candidate table
            $c_checkSql = "SELECT * FROM tblcandidate WHERE CandidateId = :candidate_id";

            $c_checkQuery = $dbh->prepare($c_checkSql);
            $c_checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $c_checkQuery->execute();

            // Fetch all rows associated with the CandidateId
            $c_result = $c_checkQuery->fetchAll(PDO::FETCH_ASSOC);

            // Training Center table
            $TrainingcenterId = $c_result[0]['training_center'];
            $t_checkSql = "SELECT * FROM tbltrainingcenter WHERE TrainingcenterId = :TrainingcenterId";

            $t_checkQuery = $dbh->prepare($t_checkSql);
            $t_checkQuery->bindParam(':TrainingcenterId', $TrainingcenterId, PDO::PARAM_INT);
            $t_checkQuery->execute();

            // Fetch all rows associated with the TrainingcenterId
            $t_result = $t_checkQuery->fetchAll(PDO::FETCH_ASSOC);

            // Payment table
            $p_checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";

            $p_checkQuery = $dbh->prepare($p_checkSql);
            $p_checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
            $p_checkQuery->execute();

            // Fetch all rows associated with the TrainingcenterId
            $p_result = $p_checkQuery->fetchAll(PDO::FETCH_ASSOC);

            // tblscheme table
            $SchemeId = $c_result[0]['scheme'];
            $scheme_checkSql = "SELECT * FROM tblscheme WHERE SchemeId = :SchemeId";

            $scheme_checkQuery = $dbh->prepare($scheme_checkSql);
            $scheme_checkQuery->bindParam(':SchemeId', $SchemeId, PDO::PARAM_INT);
            $scheme_checkQuery->execute();

            // Fetch all rows associated with the TrainingcenterId
            $scheme_result = $scheme_checkQuery->fetchAll(PDO::FETCH_ASSOC);

            // tblsector table
            $SectorId = $c_result[0]['sector'];
            $sector_checkSql = "SELECT * FROM tblsector WHERE SectorId = :SectorId";

            $sector_checkQuery = $dbh->prepare($sector_checkSql);
            $sector_checkQuery->bindParam(':SectorId', $SectorId, PDO::PARAM_INT);
            $sector_checkQuery->execute();

            // Fetch all rows associated with the TrainingcenterId
            $sector_result = $sector_checkQuery->fetchAll(PDO::FETCH_ASSOC);

            // tbljobroll table
            $JobrollId = $c_result[0]['job_roll'];
            $job_checkSql = "SELECT * FROM tbljobroll WHERE JobrollId = :JobrollId";

            $job_checkQuery = $dbh->prepare($job_checkSql);
            $job_checkQuery->bindParam(':JobrollId', $JobrollId, PDO::PARAM_INT);
            $job_checkQuery->execute();

            // Fetch all rows associated with the TrainingcenterId
            $job_result = $job_checkQuery->fetchAll(PDO::FETCH_ASSOC);

            // tbljobroll table
            $batch_id = $c_result[0]['batch'];
            $batch_checkSql = "SELECT * FROM tblbatch WHERE id = :batch_id";

            $batch_checkQuery = $dbh->prepare($batch_checkSql);
            $batch_checkQuery->bindParam(':batch_id', $batch_id, PDO::PARAM_INT);
            $batch_checkQuery->execute();

            // Fetch all rows associated with the TrainingcenterId
            $batch_result = $batch_checkQuery->fetchAll(PDO::FETCH_ASSOC);

            // emi table
            // Prepare and execute the query to fetch all records from the emi_list table
            $sql = "SELECT id, candidate_id, paid, created,added_type FROM emi_list where candidate_id = '$candidate_id'";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // Fetch all rows as an associative array
            $emi_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $pending_list=1;
        ?>


        <!-- Modal for all Content-->
        <div id="p_myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
             <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
            <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
            <link rel="stylesheet" href="css/prism/prism.css" media="screen">
            <link rel="stylesheet" href="css/select2/select2.min.css">
            <link rel="stylesheet" href="css/main.css" media="screen">
            <link rel="stylesheet" href="css/mystyle.css">

            <style type="text/css">
                #p_myModal p, #p_myModal blockquote, #p_myModal pre, #p_myModal address, #p_myModal dl, #p_myModal ol, #p_myModal ul, #p_myModal table {
                    margin-bottom: 0em;
                }
            </style>

            <?php // print_r($p_result)?>

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Payment Receipt</h4>
              </div>
              <div class="modal-body" id="p_myModals">
                <style>
                    hr {
                        margin-top: 7px;
                        margin-bottom: 8px;
                    }
                    .modal-body {
                        padding-top: 0px;
                        padding-bottom: 0px;
                    }
                    #p_myModals p {
                        font-size: 12px;
                        line-height: 1.45em;
                    }
                    #p_myModals .table>tbody>tr>td, #p_myModals .table>tbody>tr>th, #p_myModals .table>tfoot>tr>td, #p_myModals .table>tfoot>tr>th, #p_myModals .table>thead>tr>td, #p_myModals .table>thead>tr>th {
                        padding: 3px;
                    }
                        #p_myModals table td, #p_myModals table th, #p_myModals table td b,#p_myModals table th b {
                        font-size: 12px;
                    }
                </style>
                <p class="text-center"><b>SOFTPRO PAYMENT RECEIPT</b></p>
                <hr>
                <div class="row">
                    <div class="col-xs-5 col-md-5" width="40%">
                        <p>EF. No: <b><?=$c_result[0]['enrollmentid']?></b></p>
                        <p>Student: <b><?=$c_result[0]['candidatename']?></b></p>
                        <p>Training Center: <b><?=$t_result[0]['trainingcentername']?></b></p>
                        <p>Scheme: <b><?=$scheme_result[0]['SchemeName']?></b></p>
                        <p>Sector: <b><?=$sector_result[0]['SectorName']?></b></p>
                    </div>
                    <div class="col-xs-5 col-md-5" width="40%">
                        <p>Job Roll: <b><?=$job_result[0]['jobrollname']?></b></p>
                        <p>Batch: <b><?=$batch_result[0]['batch_name']?></b></p>
                        <p>Payment Date: <b><?=date("M d, Y", strtotime($p_result[0]['created_at']))?></b></p>
                        <p>Paid Amount: <b><?=$p_result[0]['paid']?></b></p>
                        <p>Remarks: <b>cash</b></p>
                    </div>

                    <div class="col-xs-2 col-md-2" width="20%">
                        <img src="images/print_logo.jpg" style="width:100%">
                    </div>
                </div>
                <hr>

                <p><b>Payment Summary</b></p>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            
                            <td width="100%">
                            <p><b>Payment Details</b></p>
                                <table width="100%" class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td width="50%">Date</td>
                                            <td width="50%" class="text-right">Amount</td>
                                        </tr>
                                        <!-- <tr>
                                            <td><b><?=date("M d, Y", strtotime($p_result[0]['created_at']))?></b></td>
                                            <td class="text-right"><b><?=$p_result[0]['paid']?></b></td>
                                        </tr> -->
                                        <?php if (!empty($emi_result)): ?>
                                            <?php foreach ($emi_result as $row): ?>

                                                <?php
                                                if($row['added_type'] !=1 ){
                                                    $pending_list = $row['added_type'];
                                                }
                                                 
                                                 ?>
                                            
                                            <tr>
                                                <td><b><?=date("M d, Y", strtotime($row['created']))?></b></td>
                                                <td class="text-right"><b><?php echo htmlspecialchars($row['paid']); ?></b></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                                <table width="100%" class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Total Payable Fee</td>
                                            <td class="text-right"><b><?=$p_result[0]['total_fee']?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Total Paid</td>
                                            <td class="text-right"><b><?=$p_result[0]['paid']?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Balance</td>
                                            <td class="text-right"><b><?=$p_result[0]['balance']?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <?php // print_r($_SESSION['user_type'])?>
                <?php if($pending_list == 1){ ?>
                <button type="button" class="btn btn-success" id="printButton" data-dismiss="modal">Print</button>
                <?php }else{ echo "Pending Approval"; } ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
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


        function p_all_data(id){
            $("#p_data").html('Loading...');
            $.ajax({
                url:'candidate_ajax.php',
                type:'post',
                data:{action:'action',id:id},
                success:function(res){
                   /// $("#p_data").html(res);
                }
            });
        }
        </script>

        <script>

        $(document).ready(function () {
            $('#printButton').click(function () {
                var printContents = $('#p_myModals').html();
                var printWindow = window.open('', '', 'height=600,width=800');

                // Add your CSS file(s) here
                var cssLink = '<link rel="stylesheet" href="https://student.softpromis.com/css/bootstrap.min.css" />';

                printWindow.document.write('<html><head><title>Print</title>' + cssLink + '</head><body>');
                printWindow.document.write(printContents);
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                // Wait for the content to load, then trigger print
                printWindow.onload = function() {
                    printWindow.print();
                };
            });
        });




        $('#discount,#paid').on('input',function(){
            var total_fee = $('#balance_total').val();
            var discount = $('#discount').val();
            var paid = $('#paid').val();
            $('#balance').val(total_fee - discount - paid);
        });
    </script>

</body>

</html>
<?PHP } ?>