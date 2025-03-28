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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen"> -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/mystyle.css"> 
    <script src="js/modernizr/modernizr.min.js"></script>


  <link rel="stylesheet" href="includes/style.css">

    
    <style>
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 10px; }
        .table-responsive { border-radius: 10px; overflow: hidden; }
        .btn-action { padding: 5px 10px; margin: 0 2px; }
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
                        <h1 class="h2">Manage Batches</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item">Students</li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Batch</li>
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

                    <!-- Batches Table -->
                    <div class="card">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Batch Information</h5>
                            <a href="add-batch.php" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add Batch
                            </a>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered" style="width:100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Batch Name</th>
                                            <th>Job Roll</th>
                                            <th>Sector</th>
                                            <th>Scheme</th>
                                            <th>Training Center</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = "SELECT tbltrainingcenter.trainingcentername, tblscheme.SchemeName, tblsector.SectorName, tbljobroll.jobrollname, tblbatch.* 
                                                FROM tbltrainingcenter, tblscheme, tblsector, tbljobroll, tblbatch 
                                                WHERE tblbatch.training_centre_id = tbltrainingcenter.TrainingcenterId 
                                                AND tblbatch.scheme_id = tblscheme.SchemeId 
                                                AND tblbatch.sector_id = tblsector.SectorId 
                                                AND tblbatch.job_roll_id = tbljobroll.JobrollId";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td>
                                                        <a href="manage-candidate.php?batch=<?php echo htmlentities($result->id); ?>" 
                                                           class="btn btn-info btn-sm" target="_blank">
                                                            <?php echo htmlentities($result->batch_name); ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo htmlentities($result->jobrollname); ?></td>
                                                    <td><?php echo htmlentities($result->SectorName); ?></td>
                                                    <td><?php echo htmlentities($result->SchemeName); ?></td>
                                                    <td><?php echo htmlentities($result->trainingcentername); ?></td>
                                                    <td><?php echo htmlentities($result->start_date); ?></td>
                                                    <td><?php echo htmlentities($result->end_date); ?></td>
                                                    <td><?php echo htmlentities($result->start_time); ?></td>
                                                    <td><?php echo htmlentities($result->end_time); ?></td>
                                                    <td>
                                                        <a href="edit-batch.php?batchid=<?php echo htmlentities($result->id); ?>" 
                                                           class="btn btn-info btn-sm btn-action" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-danger btn-sm btn-action delete" 
                                                                id="del_<?php echo htmlentities($result->id); ?>" 
                                                                title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                        <?php $cnt++; }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
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
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
      <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
    <script src="js/main.js"></script>


    <script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 20, 30, 100], [10, 20, 30, 100]],
            order: [[6, 'desc']], // Order by Start Date
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] } // Exclude Actions column
                },
                {
                    extend: 'csv',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] }
                },
                {
                    extend: 'excel',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] }
                },
                {
                    extend: 'pdf',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] }
                },
                {
                    extend: 'print',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] }
                },
                //'colvis'
            ],
            dom: 'Bfrtip'
        });

        table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

        // Delete functionality
        $('#example tbody').on('click', '.delete', function() {
            var el = this;
            var id = this.id.split("_")[1];
            if (confirm("Are you sure you want to delete this batch?")) {
                $.ajax({
                    url: 'action.php',
                    type: 'POST',
                    data: { id: id, action: "Delete batch" },
                    success: function(response) {
                        if (response == 4) {
                            $(el).closest('tr').css('background', '#ffcccc').fadeOut(800, function() {
                                $(this).remove();
                            });
                        } else {
                            alert('Error deleting batch.');
                        }
                    }
                });
            }
        });
    });

    function all_data(id) {
        $("#c_data").html('Loading...');
        $.ajax({
            url: 'batch_list.php',
            type: 'POST',
            data: { action: 'fetch_data', id: id },
            success: function(res) {
                $("#c_data").html(res);
            },
            error: function() {
                $("#c_data").html('<div class="alert alert-danger">Error fetching data.</div>');
            }
        });
    }
    </script>
</body>
</html>
<?php } ?>



















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
                                <h2 class="title">Add placement</h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> placement</li>
                                    <li class="active">Add placement</li>
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
                                                <h5>View Job Roll Info</h5>
                                            </div>
                                        </div>
                                        <?php if ($msg) { ?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                        </div><?php } else if ($error) { ?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <div class="panel-body p-20">

                                            <table id="example" class="display table table-striped table-bordered"
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
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php $sql = "SELECT tblcandidate.*,tblplacement.* from tblcandidate  JOIN tblplacement ON tblcandidate.CandidateId != tblplacement.candidate_id";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($result->candidatename); ?></td>
                                                        <td><?php echo htmlentities($result->fathername); ?></td>
                                                        <td><?php echo htmlentities($result->aadharnumber); ?></td>
                                                        <td><?php echo htmlentities($result->phonenumber); ?></td>
                                                        <td><?php echo htmlentities($result->qualification); ?></td>
                                                        <td><?php echo htmlentities($result->dateofbirth); ?></td>
                                                        <td>
                                                            <a
                                                                href="add-placement-for-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>"><button
                                                                    class="btn btn-primary">Add placement</button> </a>

                                                        </td>
                                                    </tr>
                                                    <?php $cnt = $cnt + 1;
                                                            }
                                                        } ?>


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