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
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/main.css">
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
        .btn-action { padding: 5px 10px; margin: 0 2px; }
        .thead-dark { background: #212529; color: white; }
/*        .dt-buttons { margin-bottom: 15px; }*/
        .dt-button-collection {
            max-height: 300px; /* Adjust height as needed */
            overflow-y: auto !important;
        }

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
                        <h1 class="h2">Manage Candidates</h1>
                    </div>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item">Candidate</li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Candidates</li>
                        </ol>
                    </nav>

                    <!-- Messages -->
                    <?php if ($msg) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } else if ($error) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Candidates Table -->
                    <div class="card">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Candidate Information</h5>
                            <?php if(isset($_GET['batch'])){ ?>
                                <a href="add-candidate-to-particular-batch.php?batchid=<?php echo $_GET['batch']; ?>" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Add Candidate
                                </a>
                            <?php } else { ?>
                                <a href="add-candidate.php" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Add Candidate
                                </a>
                            <?php } ?>
                        </div>
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-bordered" style="width:100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th><input type="checkbox" id="selectAll">#</th>
                                            <th>Enrollment ID</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Job Role</th>
                                            <th>ID</th>
                                            <th>Father</th>
                                            <th>Aadhar</th>
                                            <th>Qualification</th>
                                            <th>DOB</th>
                                            <th>Gender</th>
                                            <th>Marital</th>
                                            <th>Religion</th>
                                            <th>Category</th>
                                            <th>Village</th>
                                            <th>Mandal</th>
                                            <th>District</th>
                                            <th>State</th>
                                            <th>Pincode</th>
                                            <th>Created</th>
                                            <th>Modified</th>
                                            <th>Batch ID</th>
                                            <th>Training Center</th>
                                            <th>Scheme</th>
                                            <th>Sector</th>
                                            <th>Batch</th>
                                            <th>Payment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = isset($_GET['batch']) ? 
                                            "SELECT * FROM tblcandidate WHERE batch=:batch ORDER BY CandidateId DESC" : 
                                            "SELECT * FROM tblcandidate ORDER BY CandidateId DESC";
                                        $query = $dbh->prepare($sql);
                                        if(isset($_GET['batch'])) {
                                            $query->bindParam(':batch', $_GET['batch'], PDO::PARAM_STR);
                                        }
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                $jobrollname = '';
                                                $sql4 = "SELECT jobrollname FROM tbljobroll WHERE JobrollId = :jobroll";
                                                $query4 = $dbh->prepare($sql4);
                                                $query4->bindParam(':jobroll', $result->job_roll, PDO::PARAM_INT);
                                                $query4->execute();
                                                $jobrollname = $query4->fetchColumn();

                                                $tc_sql = "SELECT trainingcentername FROM tbltrainingcenter WHERE TrainingcenterId = :tc";
                                                $tc_query = $dbh->prepare($tc_sql);
                                                $tc_query->bindParam(':tc', $result->training_center, PDO::PARAM_INT);
                                                $tc_query->execute();
                                                $tc_name = $tc_query->fetchColumn();

                                                $scheme_sql = "SELECT SchemeName FROM tblscheme WHERE SchemeId = :scheme";
                                                $scheme_query = $dbh->prepare($scheme_sql);
                                                $scheme_query->bindParam(':scheme', $result->scheme, PDO::PARAM_INT);
                                                $scheme_query->execute();
                                                $scheme_name = $scheme_query->fetchColumn();

                                                $sector_sql = "SELECT SectorName FROM tblsector WHERE SectorId = :sector";
                                                $sector_query = $dbh->prepare($sector_sql);
                                                $sector_query->bindParam(':sector', $result->sector, PDO::PARAM_INT);
                                                $sector_query->execute();
                                                $sector_name = $sector_query->fetchColumn();

                                                $batch_sql = "SELECT batch_name FROM tblbatch WHERE id = :batch";
                                                $batch_query = $dbh->prepare($batch_sql);
                                                $batch_query->bindParam(':batch', $result->batch, PDO::PARAM_INT);
                                                $batch_query->execute();
                                                $batch_name = $batch_query->fetchColumn();

                                                $payment_sql = "SELECT paid, total_fee FROM payment WHERE candidate_id = :cid";
                                                $payment_query = $dbh->prepare($payment_sql);
                                                $payment_query->bindParam(':cid', $result->CandidateId, PDO::PARAM_INT);
                                                $payment_query->execute();
                                                $payment = $payment_query->fetch(PDO::FETCH_ASSOC);
                                                $status = $payment ? 
                                                    ($payment['paid'] == $payment['total_fee'] ? 
                                                        '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank" class="btn btn-success btn-xs">Paid</a>' : 
                                                        '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank" class="btn btn-warning btn-xs">Pending</a>') : 
                                                    '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank" class="btn btn-danger btn-xs">Unpaid</a>';
                                        ?>
                                            <tr>
                                                <td><input type="checkbox" class="deleteCheckbox" value="<?php echo htmlentities($result->CandidateId); ?>"><?php echo htmlentities($cnt); ?></td>
                                                <td><button class="btn btn-info btn-xs" onclick="all_data(<?php echo htmlentities($result->CandidateId); ?>)" data-bs-toggle="modal" data-bs-target="#c_myModal"><?php echo htmlentities($result->enrollmentid); ?></button></td>
                                                <td><?php echo htmlentities($result->candidatename); ?></td>
                                                <td><?php echo htmlentities($result->phonenumber); ?></td>
                                                <td><?php echo htmlentities($jobrollname); ?></td>
                                                <td><?php echo htmlentities($result->CandidateId); ?></td>
                                                <td><?php echo htmlentities($result->fathername); ?></td>
                                                <td><?php echo htmlentities($result->aadharnumber); ?></td>
                                                <td><?php echo htmlentities($result->qualification); ?></td>
                                                <td><?php echo htmlentities($result->dateofbirth); ?></td>
                                                <td><?php echo htmlentities($result->gender); ?></td>
                                                <td><?php echo htmlentities($result->maritalstatus); ?></td>
                                                <td><?php echo htmlentities($result->religion); ?></td>
                                                <td><?php echo htmlentities($result->category); ?></td>
                                                <td><?php echo htmlentities($result->village); ?></td>
                                                <td><?php echo htmlentities($result->mandal); ?></td>
                                                <td><?php echo htmlentities($result->district); ?></td>
                                                <td><?php echo htmlentities($result->state); ?></td>
                                                <td><?php echo htmlentities($result->pincode); ?></td>
                                                <td><?php echo htmlentities($result->DateCreated); ?></td>
                                                <td><?php echo htmlentities($result->DateModified); ?></td>
                                                <td><?php echo htmlentities($result->tblbatch_id); ?></td>
                                                <td><?php echo htmlentities($tc_name); ?></td>
                                                <td><?php echo htmlentities($scheme_name); ?></td>
                                                <td><?php echo htmlentities($sector_name); ?></td>
                                                <td><?php echo htmlentities($batch_name); ?></td>
                                                <td><?php echo $status; ?></td>
                                                <td>
                                                    <a href="edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>" class="btn btn-info btn-xs btn-action" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <button onclick="payment_status(<?php echo htmlentities($result->CandidateId); ?>)" class="btn btn-warning btn-xs btn-action" data-bs-toggle="modal" data-bs-target="#myModal" title="Payment Status"><i class="fas fa-check"></i></button>
                                                    <button class="btn btn-success btn-xs btn-action" data-bs-toggle="modal" data-bs-target="#myModal_<?php echo htmlentities($result->CandidateId); ?>" title="View Images"><i class="fas fa-image"></i></button>
                                                    <button class="btn btn-danger btn-xs btn-action delete" id="del_<?php echo htmlentities($result->CandidateId); ?>" title="Delete"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>

                                            <!-- Image Modal -->
                                            <div class="modal fade" id="myModal_<?php echo htmlentities($result->CandidateId); ?>" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo htmlentities($result->candidatename); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Photo</p>
                                                            <?php echo $result->candidatephoto ? '<a target="_blank" href="doc/'.$result->candidatephoto.'"><img style="width: 76px; height: 44px;" src="doc/'.$result->candidatephoto.'"></a>' : '<i class="fas fa-upload fa-2x"></i>'; ?>
                                                            <hr>
                                                            <p>Aadhaar</p>
                                                            <?php echo $result->aadhaarphoto ? '<a target="_blank" href="doc/'.$result->aadhaarphoto.'"><img style="width: 76px; height: 44px;" src="doc/'.$result->aadhaarphoto.'"></a>' : '<i class="fas fa-upload fa-2x"></i>'; ?>
                                                            <hr>
                                                            <p>Qualification</p>
                                                            <?php echo $result->qualificationphoto ? '<a target="_blank" href="doc/'.$result->qualificationphoto.'"><img style="width: 76px; height: 44px;" src="doc/'.$result->qualificationphoto.'"></a>' : '<i class="fas fa-upload fa-2x"></i>'; ?>
                                                            <hr>
                                                            <p>Application</p>
                                                            <?php echo $result->applicationphoto ? '<a target="_blank" href="doc/'.$result->applicationphoto.'"><img style="width: 76px; height: 44px;" src="doc/'.$result->applicationphoto.'"></a>' : '<i class="fas fa-upload fa-2x"></i>'; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="upload-candidate-file.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>" class="btn btn-success">Upload</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php $cnt++; } } ?>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" id="deleteBtn" class="btn btn-danger mt-3">Delete Selected</button>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="c_id">Loading...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="c_myModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Candidate Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="c_data">Loading...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

  

  

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
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
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>

    <script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 20, 30, 100, 500], [10, 20, 30, 100, 500]],
            order: [[19, 'desc']],
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: function (idx, data, node) {
                            // Exclude the last column (Action)
                            return idx !== table.columns().count() - 1 && table.column(idx).visible();
                        }
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: function (idx, data, node) {
                            // Exclude the last column (Action)
                            return idx !== table.columns().count() - 1 && table.column(idx).visible();
                        }
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: function (idx, data, node) {
                            // Exclude the last column (Action)
                            return idx !== table.columns().count() - 1 && table.column(idx).visible();
                        }
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: function (idx, data, node) {
                            // Exclude the last column (Action)
                            return idx !== table.columns().count() - 1 && table.column(idx).visible();
                        }
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: function (idx, data, node) {
                            // Exclude the last column (Action)
                            return idx !== table.columns().count() - 1 && table.column(idx).visible();
                        }
                    }
                },
                'colvis' // Column visibility button
            ],
            columnDefs: [
                { targets: [0, 1, 2, 3, 4, 26, 27], visible: true }, // Initially visible columns
                { targets: '_all', visible: false }, // Hide all other columns by default
                { targets: -1, orderable: false, searchable: false } // Action column settings
            ],
            dom: 'Bfrtip' // Buttons, filter, table, info, pagination
        });

        // Move buttons to the top
        table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

        // Select All
        $('#selectAll').on('click', function() {
            $('.deleteCheckbox').prop('checked', this.checked);
        });

        // Individual Delete
        $('#example tbody').on('click', '.delete', function() {
            var el = this;
            var id = this.id.split("_")[1];
            if (confirm("Are you sure you want to delete this candidate?")) {
                $.ajax({
                    url: 'action.php',
                    type: 'POST',
                    data: { id: id, action: "Delete candidate" },
                    success: function(response) {
                        if (response == 4) {
                            $(el).closest('tr').css('background', '#ffcccc').fadeOut(800, function() { $(this).remove(); });
                        } else {
                            alert('Error deleting candidate.');
                        }
                    }
                });
            }
        });

        // Bulk Delete
        $('#deleteBtn').on('click', function() {
            var selectedIds = $('.deleteCheckbox:checked').map(function() { return $(this).val(); }).get();
            if (selectedIds.length === 0) {
                alert("Please select at least one candidate to delete.");
                return;
            }
            if (confirm("Are you sure you want to delete selected candidates?")) {
                $.ajax({
                    url: 'delete_candidate.php',
                    type: 'POST',
                    data: { ids: selectedIds },
                    success: function(response) {
                        if (response.trim() === "success") {
                            selectedIds.forEach(function(id) {
                                $('#example tr').has('#del_' + id).css('background', '#ffcccc').fadeOut(800, function() { $(this).remove(); });
                            });
                        } else {
                            alert("Error deleting candidates.");
                        }
                    }
                });
            }
        });
    });

    function payment_status(id) {
        $("#c_id").html('Loading...');
        $.ajax({
            url: 'payment_status.php',
            type: 'post',
            data: { action: 'action', id: id },
            success: function(res) { $("#c_id").html(res); }
        });
    }

    function all_data(id) {
        $("#c_data").html('Loading...');
        $.ajax({
            url: 'candidate_ajax.php',
            type: 'post',
            data: { action: 'action', id: id },
            success: function(res) { $("#c_data").html(res); }
        });
    }
    </script>
</body>
</html>
<?php } ?>













<?php
session_start();
error_reporting(0);
$batchid = $_GET['batchid']; 
include('includes/config.php');
$sql = "SELECT * from tblcandidate WHERE tblbatch_id='$batchid'";
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
        $candidatecertification = $_POST['certification'];
        $candidatecertificationphoto = ($_FILES['certificatefile']['name']);
        $candidatecertificationtarget = 'doc/' . basename($candidatecertificationphoto);

        //INSERT
        for ($i = 0; $i < $candidatecount; $i++) {
            $sql = "SELECT * FROM tblcandidatecertification WHERE candidate_id=:candidateid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':candidateid', $candidateid[$i], PDO::PARAM_STR);
            $query->execute();
            $duplicateresultcount = $query->rowCount();
            if ($duplicateresultcount > 0) {

                $sql = "UPDATE tblcandidatecertification SET certification=:certification,certificatedoc=:certificatefile WHERE candidate_id=:candidateid ";
                $query = $dbh->prepare($sql);
                $query->bindParam(':certification', $candidatecertification[$i], PDO::PARAM_STR);
                $query->bindParam(':certificatefile', $candidatecertificationphoto[$i], PDO::PARAM_STR);

                $query->bindParam(':candidateid', $candidateid[$i], PDO::PARAM_STR);
                $query->execute();
                move_uploaded_file($_FILES['certificatefile']['tmp_name'], $candidatecertificationtarget);
                $info = "update";
            } else {
                # code...
                $sql = "INSERT INTO tblcandidatecertification(candidate_id,batch_id,certification,certificatedoc)VALUE(:candidateid,:batchid,:certification,:certificatefile)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':certification', $candidatecertification[$i], PDO::PARAM_STR);
                $query->bindParam(':certificatefile', $candidatecertificationphoto[$i], PDO::PARAM_STR);
                $query->bindParam(':batchid', $batchid, PDO::PARAM_STR);
                $query->bindParam(':candidateid', $candidateid[$i], PDO::PARAM_STR);
                $query->execute();
                move_uploaded_file($_FILES['certificatefile']['tmp_name'], $candidatecertificationtarget);
                $info = "execute";
                // echo $result;
            }
        }
        if (($info == "execute")) {
            $msg = "student certification added successfully";
        } elseif ($info == "update") {
            $msg = "student certification updated successfully";
        } else {
            $error = "student certification failed to add";
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
                                <h2 class="title">Add certification to particular batch</h2>
                            </div>
                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Training Center</li>
                                    <li class="active">Add certification to particular batch</li>
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
                                                <h5>Add certification to particular batch</h5>
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
                                                <form method="post" enctype="multipart/form-data">
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
                                                                <th>certification</th>

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
                                                                <th>certification</th>

                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <?php $batch = "";
                                                                $cnt = 1;
                                                                if ($candidatecount > 0) {
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
                                                                    <input type="hidden" name="candidateid[]"
                                                                        value="<?php echo ($result->CandidateId); ?>">
                                                                    <input type="hidden" name="batchid"
                                                                        value="<?php echo $batchid; ?>">
                                                                    <input type="text" name="certification[]" required>
                                                                </td>
                                                                <!---- <td>
                                                            <input type="file" name="certificatefile[]"  required>                                                                                                                        

                                                                </td> --->
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