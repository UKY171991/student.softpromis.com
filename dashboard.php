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
  <title>SOFTPRO | ADMIN | Dashboard</title>

  <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/mystyle.css">
    <script src="js/modernizr/modernizr.min.js"></script>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #e9ecef;
    }
    /* Custom color theme */
    .bg-teal { background-color: #20c997 !important; }
    .bg-purple { background-color: #6f42c1 !important; }
    .bg-orange { background-color: #fd7e14 !important; }
    .bg-darkblue { background-color: #343a40 !important; }
    .bg-pink { background-color: #e83e8c !important; }
    
    /* Sidebar styling */
    .sidebar {
      background-color: #343a40;
      min-height: 100vh;
    }
    .sidebar .nav-link {
      color: #adb5bd;
      padding: 0.75rem 1rem;
      font-size: 0.9rem;
    }
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
      color: #fff;
      background-color: #495057;
      border-radius: 0.25rem;
    }
    .sidebar .sidebar-header {
      padding: 1.5rem;
      text-align: center;
      color: #fff;
    }
    /* Small Dashboard Card styling */
    .dashboard-card {
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
      color: #fff;
      transition: transform 0.3s ease;
      cursor: pointer;
      font-size: 0.9rem;
    }
    .dashboard-card:hover {
      transform: translateY(-3px);
    }
    .dashboard-card .icon {
      font-size: 1.8rem;
    }
    .dashboard-card h3 {
      margin: 0;
      font-size: 1.2rem;
    }
    .dashboard-card p {
      margin: 0;
    }
  </style>
</head>
<body>
  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">SOFTPRO Admin</a>
      

      <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button> -->

      <button type="button" class="navbar-toggle mobile-nav-toggle">
          <i class="fa fa-bars"></i>
      </button>


      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="fa fa-ellipsis-v"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto align-items-center">
          <!-- <li class="nav-item me-3">
            <a class="nav-link" href="#"><i class="fa-solid fa-user"></i></a>
          </li>
          <li class="nav-item me-3">
            <a class="nav-link" href="#"><i class="fa-solid fa-arrows-alt"></i></a>
          </li> -->

          <?php
                // Prepare the query to count the rows
                    $sql = "SELECT COUNT(*) AS count FROM emi_list WHERE added_type = 2";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();

                    // Fetch the result
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $count = $result['count'];

                    //print_r($_SESSION);

                   // echo "Total records with added_type 2: " . $count;
                ?>

          <li class="nav-item me-3">
            <a class="nav-link text-danger" href="pending_payment_approval.php">
              <i class="fa-solid fa-credit-card"></i> Pending Approval (<?=$count?>)
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php">
              <i class="fa-solid fa-sign-out-alt"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->

      <?php include('includes/left-sidebar-new.php'); ?>


      <!-- Main Content -->
      <main class="col-lg-10 col-md-9 p-4">
        <h2 class="mb-4">Softpro Dashboard</h2>
        <div class="row g-3">
          <!-- Regd Candidates Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-teal" onclick="location.href='manage-candidate.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sql1 = "SELECT CandidateId FROM tblcandidate";
                    $query1 = $dbh->prepare($sql1);
                    $query1->execute();
                    $totalstudents = $query1->rowCount();
                  ?>
                  <h3><?php echo $totalstudents; ?></h3>
                  <p>Regd Candidates</p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>
          <!-- Trained Candidates Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-purple" onclick="location.href='trained-candidate.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sql = "SELECT CandidateId FROM tblcandidate 
                            JOIN tblbatch ON tblcandidate.tblbatch_id = tblbatch.id 
                            AND tblbatch.end_date < CURRENT_DATE()";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $totalTrained = $query->rowCount();
                  ?>
                  <h3><?php echo htmlentities($totalTrained); ?></h3>
                  <p>Trained Candidates</p>
                </div>
                <div class="icon"><i class="fa-solid fa-ticket"></i></div>
              </div>
            </div>
          </div>
          <!-- Ongoing Candidates Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-orange" onclick="location.href='ongoing-candidate.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sql2 = "SELECT CandidateId FROM tblcandidate 
                             JOIN tblbatch ON tblcandidate.tblbatch_id = tblbatch.id 
                             AND tblbatch.end_date > CURRENT_DATE()";
                    $query2 = $dbh->prepare($sql2);
                    $query2->execute();
                    $ongoingCandidates = $query2->rowCount();
                  ?>
                  <h3><?php echo htmlentities($ongoingCandidates); ?></h3>
                  <p>Ongoing Candidates</p>
                </div>
                <div class="icon"><i class="fa-solid fa-spinner"></i></div>
              </div>
            </div>
          </div>
          <!-- Passed Candidates Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-darkblue" onclick="location.href='passed-candidate.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sql3 = "SELECT tblcandidate.CandidateId, tblcandidateresults.* FROM tblcandidate 
                             INNER JOIN tblcandidateresults ON tblcandidate.CandidateId = tblcandidateresults.candidate_id 
                             AND tblcandidateresults.result = 'Pass'";
                    $query3 = $dbh->prepare($sql3);
                    $query3->execute();
                    $totalPassed = $query3->rowCount();
                  ?>
                  <h3><?php echo htmlentities($totalPassed); ?></h3>
                  <p>Passed Candidates</p>
                </div>
                <div class="icon"><i class="fa-solid fa-check"></i></div>
              </div>
            </div>
          </div>
          <!-- Total Batches Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-pink" onclick="location.href='manage-batch.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sqlBatch = "SELECT DISTINCT batch_name FROM tblbatch";
                    $queryBatch = $dbh->prepare($sqlBatch);
                    $queryBatch->execute();
                    $totalBatches = $queryBatch->rowCount();
                  ?>
                  <h3><?php echo htmlentities($totalBatches); ?></h3>
                  <p>Total Batches</p>
                </div>
                <div class="icon"><i class="fa-solid fa-layer-group"></i></div>
              </div>
            </div>
          </div>
          <!-- Ongoing Batches Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-teal" onclick="location.href='ongoing-batches.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sqlOngoingBatch = "SELECT id FROM tblbatch WHERE end_date > CURRENT_DATE()";
                    $queryOngoingBatch = $dbh->prepare($sqlOngoingBatch);
                    $queryOngoingBatch->execute();
                    $ongoingBatches = $queryOngoingBatch->rowCount();
                  ?>
                  <h3><?php echo htmlentities($ongoingBatches); ?></h3>
                  <p>Ongoing Batches</p>
                </div>
                <div class="icon"><i class="fa-solid fa-spinner"></i></div>
              </div>
            </div>
          </div>
          <!-- Assed Batches Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-purple" onclick="location.href='assed-batches.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sqlAssed = "SELECT id FROM tblbatch WHERE end_date < CURRENT_DATE()";
                    $queryAssed = $dbh->prepare($sqlAssed);
                    $queryAssed->execute();
                    $assedBatches = $queryAssed->rowCount();
                  ?>
                  <h3><?php echo htmlentities($assedBatches); ?></h3>
                  <p>Assed Batches</p>
                </div>
                <div class="icon"><i class="fa-solid fa-check-circle"></i></div>
              </div>
            </div>
          </div>
          <!-- Batch Results Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-orange" onclick="location.href='manage-subjects.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sqlResults = "SELECT DISTINCT tblcandidate.CandidateId, tblcandidateresults.batch_id 
                                   FROM tblcandidate 
                                   INNER JOIN tblcandidateresults ON tblcandidate.CandidateId = tblcandidateresults.candidate_id";
                    $queryResults = $dbh->prepare($sqlResults);
                    $queryResults->execute();
                    $totalResults = $queryResults->rowCount();
                  ?>
                  <h3><?php echo htmlentities($totalResults); ?></h3>
                  <p>Batch Results</p>
                </div>
                <div class="icon"><i class="fa-solid fa-chart-line"></i></div>
              </div>
            </div>
          </div>
          <!-- Training Centers Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-darkblue" onclick="location.href='manage-trainingcenter.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sqlTC = "SELECT TrainingcenterId FROM tbltrainingcenter";
                    $queryTC = $dbh->prepare($sqlTC);
                    $queryTC->execute();
                    $totalTC = $queryTC->rowCount();
                  ?>
                  <h3><?php echo htmlentities($totalTC); ?></h3>
                  <p>Training Centers</p>
                </div>
                <div class="icon"><i class="fa-solid fa-school"></i></div>
              </div>
            </div>
          </div>
          <!-- Schemes Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-pink" onclick="location.href='manage-scheme.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sqlScheme = "SELECT Schemeid FROM tblscheme";
                    $queryScheme = $dbh->prepare($sqlScheme);
                    $queryScheme->execute();
                    $totalSchemes = $queryScheme->rowCount();
                  ?>
                  <h3><?php echo htmlentities($totalSchemes); ?></h3>
                  <p>Schemes</p>
                </div>
                <div class="icon"><i class="fa-solid fa-clipboard-list"></i></div>
              </div>
            </div>
          </div>
          <!-- Sectors Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-orange" onclick="location.href='manage-sector.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sqlSector = "SELECT SectorId FROM tblsector";
                    $querySector = $dbh->prepare($sqlSector);
                    $querySector->execute();
                    $totalSectors = $querySector->rowCount();
                  ?>
                  <h3><?php echo htmlentities($totalSectors); ?></h3>
                  <p>Sectors</p>
                </div>
                <div class="icon"><i class="fa-solid fa-industry"></i></div>
              </div>
            </div>
          </div>
          <!-- Job Rolls Card -->
          <div class="col-md-3">
            <div class="dashboard-card bg-darkblue" onclick="location.href='manage-jobroll.php';">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sqlJobroll = "SELECT JobrollId FROM tbljobroll";
                    $queryJobroll = $dbh->prepare($sqlJobroll);
                    $queryJobroll->execute();
                    $totalJobroll = $queryJobroll->rowCount();
                  ?>
                  <h3><?php echo htmlentities($totalJobroll); ?></h3>
                  <p>Job Rolls</p>
                </div>
                <div class="icon"><i class="fa-solid fa-briefcase"></i></div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->
      </main>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

  <!-- Bootstrap Bundle with Popper -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

  <script src="js/jquery/jquery-2.2.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="js/bootstrap/bootstrap.min.js"></script>
  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/select2/select2.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
<?php } ?>
