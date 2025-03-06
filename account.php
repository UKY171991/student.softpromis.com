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









    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <div id="layout-wrapper">

     
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row text-end" >
                        <div class="col-xl-12 " >
                            <a href="add.php" style="float: right;margin-bottom: 15px;" class="btn btn-outline-primary" ><i class="fa fa-plus" ></i>Add Policy</a>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row">
                                                                <div class="col-md-3">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body" style="background-color: #17a2b8 !important;">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <a href="policies.php?latest=latest">     
                                                        <p class="text-muted fw-medium" style="color: white !important;">Policies</p>
                                                        <h4 class="mb-0" style="color:white">11</h4>
                                                    </a>    
                                                </div>
                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary" style="color:white"> <span class="avatar-title">
                                                                <i class="bx bx-copy-alt font-size-24"></i>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="col-md-3">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body" style="background-color: #28a745!important;">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium" style="color: white !important;">Premium</p>
                                                    <h4 class="mb-0" style="color: white !important;">&#8377;85632</h4>
                                                </div>
                                                <div class="flex-shrink-0 align-self-center ">
                                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon"> <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-archive-in font-size-24"></i>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="col-md-3">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body" style="background-color: #ffc107!important;">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <a href="manage-renewal.php?renewal=renewal">
                                                        <p class="text-muted fw-medium" style="color: white !important;">Total Renewal</p>
                                                        <h4 class="mb-0" style="color: white !important;">174</h4>
                                                    </a>
                                                </div>
                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon"> <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="col-md-3">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body" style="background-color: #dc3545!important;">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <a href="manage-renewal.php?pending=pending">
                                                        <p class="text-muted fw-medium" style="color: white !important;">Pending Renewal</p>
                                                        <h4 class="mb-0" style="color: white !important;">31</h4>
                                                    </a>
                                                </div>
                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon"> <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            
                            <!--Bar chart start-->
                            
                            <div class="card card-success">
                              <div class="card-header">
                                <!--<h3 class="card-title">Bar Chart</h3>-->
                                <div class="ms-auto">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item"> 
                                                    <select class="form-control" id="year" >
                                                        <option>Select</option>
                                                                                                                <option value="2019" >2019</option>
                                                                                                                                                                        <option value="2020" >2020</option>
                                                                                                                                                                        <option value="2021" >2021</option>
                                                                                                                                                                        <option value="2022" >2022</option>
                                                                                                                                                                        <option value="2023" >2023</option>
                                                                                                                                                                        <option value="2024" >2024</option>
                                                                                                                                                                        <option value="2025" >2025</option>
                                                                                                                
                                                    </select>
                                                </li>
                                            </ul>
                                        </div>
                
                                <div class="card-tools">
                                
                                </div>
                              </div>
                              <div class="card-body">
                                <div class="chart">
                                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                              </div>
                              <!-- /.card-body -->
                            </div>  
                            
                             <!--Bar chart start-->
            
                                                        <!--<div class="card">-->
                            <!--    <div class="card-body">-->
                            <!--        <div class="d-sm-flex flex-wrap">-->
                            <!--            <h4 class="card-title mb-4">Policies</h4>-->
                            <!--        </div>-->
                            <!--        <div id="policies-chart" class="apex-charts" dir="ltr"></div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="card">-->
                            <!--    <div class="card-body">-->
                            <!--        <div class="d-sm-flex flex-wrap">-->
                            <!--            <h4 class="card-title mb-4">Revenue</h4>-->
                            <!--        </div>-->
                            <!--        <div id="revenue-chart" class="apex-charts" dir="ltr"></div>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                    </div> 
                    <div class="row" >
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Policy type</h4>
                                    
                                    <div id="policy_type_chart" class="apex-charts" dir="ltr"></div>  
                                </div>
                            </div><!--end card-->
                            
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Vehicles</h4>
                                    
                                    <div id="vehicle_chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div><!--end card-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Renewal</h4>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center">S.No.</th>
                                                    <th class="text-center">VEHICLE&nbsp;NUMBER</th>
                                                    <th class="text-center">NAME</th>
                                                    <th class="text-center">PHONE</th>
                                                    <th class="text-center">VEHICLE&nbsp;TYPE</th>
                                                    <th class="text-center">POLICY&nbsp;TYPE</th>
                                                    <th class="text-center">INSURANCE&nbsp;COMPANY</th>
                                                    <th class="text-center">POLICY&nbsp;END DATE</th>
                                                    <th class="text-center">ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                                                                <tr>
                                                    <td class="text-center" >1</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="23" >AP39TC4102</a></td>
                                                    <td class="text-center" >SURAVARAPU NOOKA RATNAM</td>
                                                    <td class="text-center" >8074454758</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >23-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=23" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >2</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="50" >AP35Y3261</a></td>
                                                    <td class="text-center" >VAMPATAPU SRINIVASARAO</td>
                                                    <td class="text-center" >9490749075</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >19-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=50" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >3</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="63" >AP35TB2652</a></td>
                                                    <td class="text-center" >ARISARLA NAGABHUSHANA RAO</td>
                                                    <td class="text-center" >9553232230</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >21-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=63" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >4</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="90" >AP39Y6698</a></td>
                                                    <td class="text-center" >ALLU MAHESH</td>
                                                    <td class="text-center" >9866052838</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >09-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=90" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >5</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="228" >AP35TB3121</a></td>
                                                    <td class="text-center" >HARIKRISHNA GALAGATLA</td>
                                                    <td class="text-center" >8179944902</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >23-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=228" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >6</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="229" >AP35X3840</a></td>
                                                    <td class="text-center" >SANAPATHI SAMBAYYA</td>
                                                    <td class="text-center" >9948053411</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Third Party</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >25-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=229" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >7</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="241" >AP35W4992</a></td>
                                                    <td class="text-center" >PALLEM HARIPRASADA RAO</td>
                                                    <td class="text-center" >9642237819</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >22-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=241" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >8</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="528" >AP35Y1593</a></td>
                                                    <td class="text-center" >KOLAKA RAJA RAO</td>
                                                    <td class="text-center" >6303290795</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >19-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=528" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >9</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="550" >AP39TR5674</a></td>
                                                    <td class="text-center" >KONDAGORRI SUNNAMMA</td>
                                                    <td class="text-center" >9160271272</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >21-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=550" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >10</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="571" >AP39TJ0664</a></td>
                                                    <td class="text-center" >SESHAPU SAIKUMAR</td>
                                                    <td class="text-center" >9052306091</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >12-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=571" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >11</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="582" >AP35AF6308</a></td>
                                                    <td class="text-center" > SIMHACHALAM BALAGA</td>
                                                    <td class="text-center" >6300298787</td>
                                                    <td class="text-center" >Tractor</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >11-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=582" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >12</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="588" >AP39TJ5649</a></td>
                                                    <td class="text-center" > BADE PRABHAKARA RAO</td>
                                                    <td class="text-center" >9849741410</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >21-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=588" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >13</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="595" >AP35X7552</a></td>
                                                    <td class="text-center" >SAMALA SURESH</td>
                                                    <td class="text-center" >9849355693</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >14-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=595" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >14</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="597" >AP35Y2744</a></td>
                                                    <td class="text-center" >ARASADA MANOHARA RAO .</td>
                                                    <td class="text-center" >7416770896</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >18-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=597" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >15</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="604" >AP35TB0340</a></td>
                                                    <td class="text-center" >GANGULU PULLARI</td>
                                                    <td class="text-center" >9398838423</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >19-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=604" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >16</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="611" >AP03TL0193</a></td>
                                                    <td class="text-center" >SANKARA RAO SAPPA</td>
                                                    <td class="text-center" >9618641301</td>
                                                    <td class="text-center" >Tractor</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >21-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=611" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >17</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="761" >AP39TN8476</a></td>
                                                    <td class="text-center" >MANDANGI KAMALAHASAN</td>
                                                    <td class="text-center" >9515790567</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >11-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=761" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >18</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="771" >AP35AR2157</a></td>
                                                    <td class="text-center" >NIMMAKA  KRUPARAO</td>
                                                    <td class="text-center" >8919285635</td>
                                                    <td class="text-center" >Tractor</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >25-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=771" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >19</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="882" >AP39TQ3241</a></td>
                                                    <td class="text-center" >MUDILA TIRUPATIRAO</td>
                                                    <td class="text-center" >9160271272</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >15-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=882" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >20</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="927" >AP39TK9234</a></td>
                                                    <td class="text-center" >ALLU GANGULU</td>
                                                    <td class="text-center" >9705076071</td>
                                                    <td class="text-center" >Tractor</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >25-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=927" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >21</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="933" >AP35X2975</a></td>
                                                    <td class="text-center" >CHIPURUPALLI SIVUDU</td>
                                                    <td class="text-center" >6302967198</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Third Party</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >12-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=933" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >22</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="939" >AP31TU3471</a></td>
                                                    <td class="text-center" >URALPU UMA</td>
                                                    <td class="text-center" >7995283896</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Third Party</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >05-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=939" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >23</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="964" >AP39T9707</a></td>
                                                    <td class="text-center" >CHANDRA RAO LANKA</td>
                                                    <td class="text-center" >7981151621</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >18-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=964" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >24</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="1197" >AP35Y6438</a></td>
                                                    <td class="text-center" >GULLA ANNAPURNAMMA</td>
                                                    <td class="text-center" >6301450344</td>
                                                    <td class="text-center" >Tractor</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >04-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=1197" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >25</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="1198" >AP35X0930</a></td>
                                                    <td class="text-center" >SOMESWARA RAO VANGALA</td>
                                                    <td class="text-center" >9160271272</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >04-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=1198" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >26</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="1199" >AP35X7567</a></td>
                                                    <td class="text-center" >GUTTHAVILLI BABURAO</td>
                                                    <td class="text-center" >9160271272</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >08-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=1199" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >27</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="1200" >AP39UM3019</a></td>
                                                    <td class="text-center" >REDDI RAMAKRISHNA</td>
                                                    <td class="text-center" >9160271272</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >08-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=1200" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >28</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="1201" >AP35TB2974</a></td>
                                                    <td class="text-center" >GOLA APPANNA</td>
                                                    <td class="text-center" >7288002142</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >12-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=1201" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >29</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="1202" >AP35TB2187</a></td>
                                                    <td class="text-center" >PEDAKAPU PRASAD</td>
                                                    <td class="text-center" >7093450912</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >12-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=1202" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >30</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="1203" >AP35TB3309</a></td>
                                                    <td class="text-center" >SEEDHARAPU SRIKANTH</td>
                                                    <td class="text-center" >9160271272</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Full</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >12-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=1203" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                                <tr>
                                                    <td class="text-center" >31</td>
                                                    <td class="text-center" ><a href="javascript: void(0);" class="text-body fw-bold waves-effect waves-light" onclick="viewpolicy(this)" data-id="1204" >AP31TT7784</a></td>
                                                    <td class="text-center" > POTNURU DURGARAO</td>
                                                    <td class="text-center" >9160271272</td>
                                                    <td class="text-center" >Auto</td>
                                                    <td class="text-center" >Third Party</td>
                                                    <td class="text-center" >SBI General Insurance</td>
                                                    <td class="text-center" >12-03-2025</td>
                                                    <td class="text-center" >
                                                        <a href="edit.php?id=1204" class="btn btn-outline-primary btn-sm edit" ><i class="fas fa-pencil-alt" ></i></a>
                                                        <!-- <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm edit" ><i class="fas fa-trash-alt" ></i></a> -->
                                                    </td>
                                                </tr>
                                                                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true" id="renewalpolicyview" >
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" id="viewpolicydata" ></div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script>© Softpro.</div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">Design & Develop by Softpro</div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/pages/dashboard.init.js"></script>
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script>
    
    
    <!--Bar chart script start-->
    
    <!-- ChartJS -->
    <script src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>
    
    
    <script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */


     var areaChartData = {
     // labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    //  labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
        {
          label               : 'Premium',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : ['590511.00', '282934.00', '85632.00', '', '', '', '','','','','','']
        },
        {
          label               : 'Policies',
          backgroundColor     : '#FF0000',
          borderColor         : '#000',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : ['53', '36', '11', '', '', '', '','','','','','']
        },
        {
          label               : 'Revenue',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : ['64333.00', '22918.00', '7811.00', '', '', '', '','','','','','']
        },
      ]
    }

    //-------------
    //- BAR CHART -
   //- BAR CHART -
    //-------------
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#barChart').get(0).getContext('2d')
  //  var stackedBarChartCanva1 = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
    
    <!--Barchart script end-->
    
    
    
    <script type="text/javascript">
        function viewpolicy(identifier) {
            var id= $(identifier).data("id");
            $('#renewalpolicyview').modal("show");
            $.post("include/view-policy.php",{ id:id }, function(data) {
                $('#viewpolicydata').html(data);
            });
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#year').on("change", function () {
                window.location.href='home.php?year='+$(this).val();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var options = {
                chart: {
                    height: 300,
                    type: "bar",
                    stacked: !0,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !0
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "15%",
                        endingShape: "rounded"
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                series: [{
                    name: "Premium",
                    data: [590511,282934,85632]                }],
                xaxis: {
                    categories: ["Jan 25","Feb 25","Mar 25"]                },
                colors: ["#556ee6"],
                legend: {
                    position: "bottom"
                },
                fill: {
                    opacity: 1
                }
            },
            chart = new ApexCharts(document.querySelector("#premium-chart"), options);
            chart.render();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var options = {
                chart: {
                    height: 300,
                    type: "bar",
                    stacked: !0,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !0
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "15%",
                        endingShape: "rounded"
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                series: [{
                    name: "Policies",
                    data: [53,36,11]                }],
                xaxis: {
                    categories: ["Jan 25","Feb 25","Mar 25"]                },
                colors: ["#f1b44c"],
                legend: {
                    position: "bottom"
                },
                fill: {
                    opacity: 1
                }
            },
            chart = new ApexCharts(document.querySelector("#policies-chart"), options);
            chart.render();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var options = {
                chart: {
                    height: 300,
                    type: "bar",
                    stacked: !0,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !0
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "15%",
                        endingShape: "rounded"
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                series: [{
                    name: "Revenue",
                    data: [64333,22918,7811]                }],
                xaxis: {
                    categories: ["Jan 25","Feb 25","Mar 25"]                },
                colors: ["#34c38f"],
                legend: {
                    position: "bottom"
                },
                fill: {
                    opacity: 1
                }
            },
            chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
            chart.render();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            options = {
                chart: {
                    height: 350,
                    type: "bar",
                    toolbar: {
                        show: !1
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !0
                    }
                },
                dataLabels: {
                    enabled: !1
                },
                series: [{
                    data: [59,7,2,3,2,13,6,8]                }],
                colors: ["#34c38f"],
                grid: {
                    borderColor: "#f1f1f1"
                },
                xaxis: {
                    categories: ["Auto","Bolero","Car","Lorry","Person","Tractor","Trailer","Two Wheeler"]                }
            };
            (chart = new ApexCharts(document.querySelector("#vehicle_chart"), options)).render();
        });
        $(document).ready(function() {
            options = {
                chart: {
                    height: 370,
                    type: "radialBar"
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: "22px"
                            },
                            value: {
                                fontSize: "16px"
                            },
                            total: {
                                show: !0,
                                label: "Total",
                                formatter: function (e) {
                                    return 100
                                }
                            }
                        }
                    }
                },
                series: [78,2,20],
                labels: ["Full","Health","Third Party"],
                colors: ["#556ee6", "#34c38f", "#f46a6a"]
            };
            (chart = new ApexCharts(document.querySelector("#policy_type_chart"), options)).render();
        });
    </script>















        </div><!-- /.row -->
      </main>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>
