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
    <title>SOFTPRO | ADMIN</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
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
                                <h2 class="title">Manage user</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Admin control</li>
                                    <li class="active">Manage user</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title" style="display: flex;">
                                                <?php
                                                $sqls = "SELECT SUM(paid) as total_paid FROM emi_list WHERE added_type = 2";
                                                $querys = $dbh->prepare($sqls);
                                                $querys->execute();
                                                $res = $querys->fetch(PDO::FETCH_OBJ);
                                                ?>
                                                <h5>Total Pending Amount : <?=$res->total_paid?></h5>
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
                                        <div class="panel-body p-20" style="overflow: scroll;">
                                            <table id="example" class="table table-stripped table-bordered table-hover table-full-width table-grey table-responsive-lg" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Enrollment id</th>
                                                        <th>Name</th>
                                                        <th>Total fee</th>
                                                        <th>Paid</th>
                                                        <th>Balance</th>
                                                        <th>Last Paid</th>
                                                        <th>Updated Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Enrollment id</th>
                                                        <th>Name</th>
                                                        <th>Total fee</th>
                                                        <th>Paid</th>
                                                        <th>Balance</th>
                                                        <th>Last Paid</th>
                                                        <th>Updated Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT 
                                                                e.id,
                                                                e.candidate_id,
                                                                e.paid,
                                                                e.created,
                                                                c.enrollmentid,
                                                                c.candidatename,
                                                                p.total_fee,
                                                                p.paid AS paid_total,
                                                                p.balance
                                                            FROM emi_list e
                                                            INNER JOIN tblcandidate c ON e.candidate_id = c.CandidateId
                                                            INNER JOIN payment p ON p.added_type = e.added_type
                                                            WHERE e.added_type = 2";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;

                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) { ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($result->enrollmentid); ?></td>
                                                        <td><?php echo htmlentities($result->candidatename); ?></td>
                                                        <td><?php echo htmlentities($result->total_fee); ?></td>
                                                        <td><?php echo htmlentities($result->paid_total); ?></td>
                                                        <td><?php echo htmlentities($result->balance); ?></td>
                                                        <td><?php echo htmlentities($result->paid); ?></td>
                                                        <td><?php echo date("d M Y h:i:s A", strtotime($result->created)); ?></td>
                                                        <td>
                                                            <?php
                                                            if ($_SESSION['user_type'] != 1) {
                                                                echo "Pending Approval";
                                                            } else {
                                                                echo '<a class="badge badge-info" href="#" onclick="updateStatus(' . htmlentities($result->candidate_id) . ', ' . htmlentities($result->id) . ')">Approve</a>';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++;
                                                        }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
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
    });
    </script>
</body>
</html>
<?php } ?>

<script>
function updateStatus(candidateId, id) {
    if (confirm("Are you sure you want to update the status?")) {
        $.ajax({
            url: 'appve_ajax.php',
            type: 'POST',
            data: { candidate_id: candidateId, id: id },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Status updated successfully!');
                    window.location.reload();
                } else {
                    alert('Update failed: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('An error occurred while updating the status.');
            }
        });
    }
}
</script>