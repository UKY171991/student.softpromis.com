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
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  body {
    background-color: #e9ecef;
  }
  .bg-teal { background-color: #20c997 !important; }
  .bg-purple { background-color: #6f42c1 !important; }
  .bg-orange { background-color: #fd7e14 !important; }
  .bg-darkblue { background-color: #343a40 !important; }
  .bg-pink { background-color: #e83e8c !important; }
  .bg-indigo { background-color: #6610f2 !important; }
  .bg-maroon { background-color: #dc3545 !important; }
  .bg-gold { background-color: #ffc107 !important; }

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
    
</style>
</head>
<body>
  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">SOFTPRO Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item me-3">
            <a class="nav-link" href="#"><i class="fa-solid fa-user"></i></a>
          </li>
          <li class="nav-item me-3">
            <a class="nav-link" href="#"><i class="fa-solid fa-arrows-alt"></i></a>
          </li>
          <?php
            $sql = "SELECT COUNT(*) AS count FROM emi_list WHERE added_type = 2";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $count = $result['count'];
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
        <h2 class="mb-4">Softpro Account Dashboard</h2>
        <div class="row g-3">

          <!-- Card 1: Regd Candidates Current Month -->
          <div class="col-md-3">
            <div class="dashboard-card bg-purple">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $currentYear = date("Y");
                    $currentMonth = date("m");
                    $sql1 = "SELECT CandidateId FROM tblcandidate WHERE YEAR(DateCreated) = :currentYear AND MONTH(DateCreated) = :currentMonth";
                    $query1 = $dbh->prepare($sql1);
                    $query1->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query1->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
                    $query1->execute();
                    $totalstudentsMonth = $query1->rowCount();
                  ?>
                  <h3><?php echo $totalstudentsMonth; ?></h3>
                  <p>Regd Candidates in <?=date('F');?></p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>

          

          

          <!-- Card 2: Total Fees Current Year -->
          <div class="col-md-3">
            <div class="dashboard-card bg-orange">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $currentYear = date("Y");
                    $sql = "SELECT SUM(total_fee) AS total_collection FROM payment WHERE YEAR(created_at) = :currentYear";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalCollection = $result['total_collection'] ?? 0;
                  ?>
                  <h3><?php echo number_format($totalCollection, 2); ?></h3>
                  <p>Total Fees (<?php echo $currentYear; ?>)</p>
                </div>
                <div class="icon"><i class="fa-solid fa-coins"></i></div>
              </div>
            </div>
          </div>

          <!-- Card 3: Total Fees Current Month -->
          <div class="col-md-3">
            <div class="dashboard-card bg-darkblue">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $currentYear = date("Y");
                    $currentMonth = date("m");
                    $sql = "SELECT SUM(total_fee) AS total_collection FROM payment WHERE YEAR(created_at) = :currentYear AND MONTH(created_at) = :currentMonth";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalCollection = $result['total_collection'] ?? 0;
                  ?>
                  <h3><?php echo number_format($totalCollection, 2); ?></h3>
                  <p>Total Fees (<?php echo date("F Y"); ?>)</p>
                </div>
                <div class="icon"><i class="fa-solid fa-coins"></i></div>
              </div>
            </div>
          </div>




          <!-- Card 4: Pending Payments -->
          <div class="col-md-3">
            <div class="dashboard-card bg-pink">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sql = "SELECT COUNT(*) AS count FROM payment WHERE paid < total_fee";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $pendingPayments = $result['count'] ?? 0;
                  ?>
                  <h3><?php echo $pendingPayments; ?></h3>
                  <p>Pending Payments</p>
                </div>
                <div class="icon"><i class="fa-solid fa-credit-card"></i></div>
              </div>
            </div>
          </div>

          <!-- Card 5: Regd Candidates Current Year -->
          <div class="col-md-3">
            <div class="dashboard-card bg-teal">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $currentYear = date("Y");
                    $sql1 = "SELECT CandidateId FROM tblcandidate WHERE YEAR(DateCreated) = :currentYear";
                    $query1 = $dbh->prepare($sql1);
                    $query1->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
                    $query1->execute();
                    $totalstudents = $query1->rowCount();
                  ?>
                  <h3><?php echo $totalstudents; ?></h3>
                  <p>Regd Candidates in <?=date('Y');?></p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>

          <!-- Card 6: Total Candidates All Time -->
          <div class="col-md-3">
            <div class="dashboard-card bg-indigo">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sql = "SELECT COUNT(CandidateId) AS total FROM tblcandidate";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalCandidates = $result['total'] ?? 0;
                  ?>
                  <h3><?php echo $totalCandidates; ?></h3>
                  <p>Total Candidates All Time</p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>

          <!-- Card 7: Total Fees All Time -->
          <div class="col-md-3">
            <div class="dashboard-card bg-maroon">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sql = "SELECT SUM(total_fee) AS total FROM payment";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $totalFeesAllTime = $result['total'] ?? 0;
                  ?>
                  <h3><?php echo number_format($totalFeesAllTime, 2); ?></h3>
                  <p>Total Fees All Time</p>
                </div>
                <div class="icon"><i class="fa-solid fa-coins"></i></div>
              </div>
            </div>
          </div>

          <!-- Card 8: Active Batches -->
          <div class="col-md-3">
            <div class="dashboard-card bg-gold">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <?php
                    $sql = "SELECT COUNT(DISTINCT batch) AS total FROM tblcandidate WHERE batch IS NOT NULL";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $activeBatches = $result['total'] ?? 0;
                  ?>
                  <h3><?php echo $activeBatches; ?></h3>
                  <p>Active Batches</p>
                </div>
                <div class="icon"><i class="fa-solid fa-chalkboard-teacher"></i></div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->

        <!-- Charts and Data Table -->
        <div class="container-fluid mt-5">
          <div class="row">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">Monthly Register Students Overview</h4>
                  <canvas id="barChart" style="max-height: 300px; height: 100px;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-5">
            <div class="col-xl-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">Monthly Fees Overview</h4>
                  <canvas id="feesChart" style="max-height: 300px; height: 100px;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-5">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">Data List</h4>
                  <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Enrollment ID</th>
                          <th>Candidate Name</th>
                          <th>Phone Number</th>
                          <th>Job Roll</th>
                          <th>Payment Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Enrollment ID</th>
                          <th>Candidate Name</th>
                          <th>Phone Number</th>
                          <th>Job Roll</th>
                          <th>Payment Status</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php
                          if(isset($_GET['batch'])){
                            $batch_id = $_GET['batch'];
                            $sql = "SELECT * FROM tblcandidate WHERE batch='$batch_id' ORDER BY CandidateId DESC";
                          } else {
                            $sql = "SELECT * FROM tblcandidate ORDER BY CandidateId DESC";
                          }
                          $query = $dbh->prepare($sql);
                          $query->execute();
                          $results = $query->fetchAll(PDO::FETCH_OBJ);
                          $cnt = 1;
                          if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                              $jobrollname = '';
                              $candidate_id = $result->CandidateId;
                              $p_checkSql = "SELECT * FROM payment WHERE candidate_id = :candidate_id";
                              $p_checkQuery = $dbh->prepare($p_checkSql);
                              $p_checkQuery->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
                              $p_checkQuery->execute();
                              $p_result = $p_checkQuery->fetchAll(PDO::FETCH_ASSOC);

                              $JobrollId = $result->job_roll;
                              $sql4 = "SELECT JobrollId, jobrollname FROM tbljobroll WHERE JobrollId = '$JobrollId' ORDER BY JobrollId DESC";
                              $query4 = $dbh->prepare($sql4);
                              $query4->execute();
                              $result4 = $query4->fetchAll(PDO::FETCH_ASSOC);
                              $jobrollname = $result4[0]['jobrollname'] ?? '';

                              if (count($p_result) == 0 || $p_result[0]['paid'] != $p_result[0]['total_fee']) {
                        ?>
                        <tr>
                          <td><?php echo htmlentities($cnt); ?></td>
                          <td>
                            <button type="button" class="btn btn-info btn-xs" onClick='all_data(<?php echo htmlentities($result->CandidateId); ?>)' data-toggle="modal" data-target="#c_myModal"><?php echo htmlentities($result->enrollmentid); ?></button>
                          </td>
                          <td><?php echo htmlentities($result->candidatename); ?></td>
                          <td><?php echo htmlentities($result->phonenumber); ?></td>
                          <td><?php echo $jobrollname; ?></td>
                          <td>
                            <?php
                              $status = '';
                              if (count($p_result) == 0) {
                                $status = '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank"><button class="btn btn-danger btn-xs">Pending</button></a>';
                              } elseif ($p_result[0]['paid'] != $p_result[0]['total_fee']) {
                                $status = '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank"><button class="btn btn-warning btn-xs">Pending</button></a>';
                              } else {
                                $status = '<a href="payment.php?last_id='.$result->CandidateId.'" target="_blank"><button class="btn btn-success btn-xs">Paid</button></a>';
                              }
                              echo $status;
                            ?>
                          </td>
                          <td>
                            <a class="btn-info btn-sm" href="edit-candidate.php?candidateid=<?php echo htmlentities($result->CandidateId); ?>" title="Edit Records"><i class="fa fa-edit"></i></a>
                          </td>
                        </tr>
                        <?php
                              }
                              $cnt++;
                            }
                          } else {
                        ?>
                        <tr>
                          <td colspan="7">No record found</td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </main>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

  <!-- Chart Data Preparation -->
  <?php
    $currentMonth = date("m");
    $currentYear = date("Y");
    $monthlyData = [];
    $monthLabels = [];
    for ($i = 0; $i < 12; $i++) {
      $month = date("m", strtotime("-$i months"));
      $year = date("Y", strtotime("-$i months"));
      $sql = "SELECT COUNT(CandidateId) AS total FROM tblcandidate WHERE YEAR(DateCreated) = :year AND MONTH(DateCreated) = :month";
      $query = $dbh->prepare($sql);
      $query->bindParam(':year', $year, PDO::PARAM_INT);
      $query->bindParam(':month', $month, PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      $total = $result['total'] ?? 0;
      $monthlyData[] = $total;
      $monthLabels[] = date("M Y", strtotime("-$i months"));
    }
    $monthlyData = array_reverse($monthlyData);
    $monthLabels = array_reverse($monthLabels);

    $monthlyFeesData = [];
    for ($i = 0; $i < 12; $i++) {
      $month = date("m", strtotime("-$i months"));
      $year = date("Y", strtotime("-$i months"));
      $sql = "SELECT SUM(total_fee) AS total FROM payment WHERE YEAR(created_at) = :year AND MONTH(created_at) = :month";
      $query = $dbh->prepare($sql);
      $query->bindParam(':year', $year, PDO::PARAM_INT);
      $query->bindParam(':month', $month, PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      $total = $result['total'] ?? 0;
      $monthlyFeesData[] = $total;
    }
    $monthlyFeesData = array_reverse($monthlyFeesData);
  ?>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <script>
  document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('barChart').getContext('2d');
    if (window.myBarChart instanceof Chart) {
      window.myBarChart.destroy();
    }
    window.myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($monthLabels); ?>,
        datasets: [{
          label: 'Registered Candidates',
          backgroundColor: '#007bff',
          data: <?php echo json_encode($monthlyData); ?>
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    var ctxf = document.getElementById('feesChart').getContext('2d');
    if (window.myFeesChart instanceof Chart) {
      window.myFeesChart.destroy();
    }
    window.myFeesChart = new Chart(ctxf, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($monthLabels); ?>,
        datasets: [{
          label: 'Monthly Fees Collected (₹)',
          backgroundColor: '#28a745',
          data: <?php echo json_encode($monthlyFeesData); ?>
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  });
  </script>
</body>
</html>
<?php } ?>