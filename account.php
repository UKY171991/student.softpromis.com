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
        <h2 class="mb-4">Softpro Account Dashboard</h2>
        <div class="row g-3">

          <!-- Regd Candidates Card -->
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
                  <p>Regd Candidates Current Year</p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>

          <!-- Trained Candidates Card -->
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
                  <p>Regd Candidates Current Month</p>
                </div>
                <div class="icon"><i class="fa-solid fa-users"></i></div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
		    <div class="dashboard-card bg-success">
		        <div class="d-flex justify-content-between align-items-center">
		            <div>
		                <?php
		                $currentYear = date("Y");
		                $sql = "SELECT SUM(total_fee) AS total_collection FROM payment WHERE YEAR(created_at) = :currentYear";
		                $query = $dbh->prepare($sql);
		                $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
		                $query->execute();
		                $result = $query->fetch(PDO::FETCH_ASSOC);
		                $totalCollection = $result['total_collection'] ?? 0; // Default to 0 if no payments found
		                ?>
		                <h3><?php echo number_format($totalCollection, 2); ?></h3>
		                <p>Total Fees (<?php echo $currentYear; ?>)</p>
		            </div>
		            <div class="icon"><i class="fa-solid fa-coins"></i></div>
		        </div>
		    </div>
		</div>

		<div class="col-md-3">
		    <div class="dashboard-card bg-success">
		        <div class="d-flex justify-content-between align-items-center">
		            <div>
		                <?php
		                $currentYear = date("Y");
		                $currentMonth = date("m"); // Get current month as a number (01-12)

		                $sql = "SELECT SUM(total_fee) AS total_collection 
		                        FROM payment 
		                        WHERE YEAR(created_at) = :currentYear 
		                        AND MONTH(created_at) = :currentMonth";

		                $query = $dbh->prepare($sql);
		                $query->bindParam(':currentYear', $currentYear, PDO::PARAM_INT);
		                $query->bindParam(':currentMonth', $currentMonth, PDO::PARAM_INT);
		                $query->execute();
		                $result = $query->fetch(PDO::FETCH_ASSOC);
		                $totalCollection = $result['total_collection'] ?? 0; // Default to 0 if no payments found
		                ?>
		                <h3><?php echo number_format($totalCollection, 2); ?></h3>
		                <p>Total Fees (<?php echo date("F Y"); ?>)</p> <!-- Displays Month & Year -->
		            </div>
		            <div class="icon"><i class="fa-solid fa-coins"></i></div>
		        </div>
		    </div>
		</div>





	    <div class="container-fluid mt-5">
	        <div class="row">
	            <div class="col-xl-12">
	                <!-- Bar Chart -->
	                <div class="card">
	                    <div class="card-body">
	                        <h4 class="card-title mb-4">Monthly Data Overview</h4>
	                        <canvas id="barChart" style="min-height: 100px; height: 100px;"></canvas>
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
	                                <thead class="table-light">
	                                    <tr>
	                                        <th class="text-center">S.No.</th>
	                                        <th class="text-center">Name</th>
	                                        <th class="text-center">Phone</th>
	                                        <th class="text-center">Category</th>
	                                        <th class="text-center">Date</th>
	                                        <th class="text-center">Actions</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <tr>
	                                        <td class="text-center">1</td>
	                                        <td class="text-center">John Doe</td>
	                                        <td class="text-center">1234567890</td>
	                                        <td class="text-center">Category A</td>
	                                        <td class="text-center">01-03-2025</td>
	                                        <td class="text-center"><button class="btn btn-primary btn-sm">View</button></td>
	                                    </tr>
	                                    <tr>
	                                        <td class="text-center">2</td>
	                                        <td class="text-center">Jane Smith</td>
	                                        <td class="text-center">0987654321</td>
	                                        <td class="text-center">Category B</td>
	                                        <td class="text-center">05-03-2025</td>
	                                        <td class="text-center"><button class="btn btn-primary btn-sm">View</button></td>
	                                    </tr>
	                                </tbody>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>

    







        </div><!-- /.row -->
      </main>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->



  <?php
// Database connection
//require 'config.php'; // Ensure this connects to your database

// Get the current month and year
$currentMonth = date("m");
$currentYear = date("Y");

// Array to store data for the past 12 months
$monthlyData = [];
$monthLabels = [];

for ($i = 0; $i < 12; $i++) {
    // Calculate the month and year for each iteration
    $month = date("m", strtotime("-$i months"));
    $year = date("Y", strtotime("-$i months"));
    
    // Query to count registered candidates for each month
    $sql = "SELECT COUNT(CandidateId) AS total FROM tblcandidate WHERE YEAR(DateCreated) = :year AND MONTH(DateCreated) = :month";
    $query = $dbh->prepare($sql);
    $query->bindParam(':year', $year, PDO::PARAM_INT);
    $query->bindParam(':month', $month, PDO::PARAM_INT);
    $query->execute();
    
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $total = $result['total'] ?? 0; // If no data, default to 0
    
    // Store values in arrays
    $monthlyData[] = $total;
    $monthLabels[] = date("M Y", strtotime("-$i months")); // Month Name + Year (e.g., "Mar 2025")
}

// Reverse arrays to display oldest to newest month
$monthlyData = array_reverse($monthlyData);
$monthLabels = array_reverse($monthLabels);
?>



  <!-- jQuery (Required for DataTables and Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Bundle (JS + Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Chart.js (For Graphs) - Latest Version -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
	$(document).ready(function() {
	    $('#datatable').DataTable();
	});

	// Function to initialize Chart.js
	function renderChart() {
	    var ctx = document.getElementById('barChart').getContext('2d');

	    // ✅ Destroy existing chart instance if it exists
	    if (window.myBarChart instanceof Chart) {
	        window.myBarChart.destroy();
	    }

	    // ✅ Create a new chart instance
	    window.myBarChart = new Chart(ctx, {
	        type: 'bar',
	        data: {
	            labels: ['January', 'February', 'March', 'April'],
	            datasets: [{
	                label: 'Data Count',
	                backgroundColor: '#007bff',
	                data: [50, 30, 20, 40]
	            }]
	        },
	        options: {
	            responsive: true,
	            maintainAspectRatio: true, // ✅ Prevents infinite height growth
	            scales: {
	                y: {
	                    beginAtZero: true
	                }
	            }
	        }
	    });
	}

	// ✅ Ensure Chart.js only initializes once
	document.addEventListener("DOMContentLoaded", function() {
	    renderChart();
	});
	</script>



	<canvas id="barChart" style="min-height: 250px; height: 250px;"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('barChart').getContext('2d');

    // Destroy previous instance if it exists
    if (window.myBarChart instanceof Chart) {
        window.myBarChart.destroy();
    }

    // Create a new chart
    window.myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($monthLabels); ?>, // PHP Array to JS
            datasets: [{
                label: 'Registered Candidates',
                backgroundColor: '#007bff',
                data: <?php echo json_encode($monthlyData); ?> // PHP Array to JS
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>



</body>
</html>
<?php } ?>
