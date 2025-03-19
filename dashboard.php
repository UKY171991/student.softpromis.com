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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOFTPRO | Admin Dashboard</title>
    
    <!-- Modern CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --primary: #0066ff;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --purple: #6f42c1;
            --teal: #20c997;
            --pink: #e83e8c;
        }

        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .dashboard-card {
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            height: 100%;
            background: #fff;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .dashboard-card .icon {
            font-size: 2.5rem;
            opacity: 0.2;
        }

        .dashboard-card h3 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 2rem;
        }

        .dashboard-card p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .main-content {
            padding: 30px;
        }

        @media (max-width: 768px) {
            .dashboard-card {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <?php include('includes/topbar-new.php'); ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include('includes/left-sidebar-new.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <h2 class="mb-4 fw-bold">Softpro Dashboard</h2>
                
                <div class="row g-4">
                    <!-- Card Template -->
                    <?php
                    $cards = [
                        ['title' => 'Regd Candidates', 'count' => $totalstudents, 'icon' => 'users', 'color' => 'primary', 'link' => 'manage-candidate.php'],
                        ['title' => 'Trained Candidates', 'count' => $totalTrained, 'icon' => 'ticket', 'color' => 'success', 'link' => 'trained-candidate.php'],
                        ['title' => 'Ongoing Candidates', 'count' => $ongoingCandidates, 'icon' => 'spinner', 'color' => 'warning', 'link' => 'ongoing-candidate.php'],
                        ['title' => 'Passed Candidates', 'count' => $totalPassed, 'icon' => 'check', 'color' => 'info', 'link' => 'passed-candidate.php'],
                        ['title' => 'Total Batches', 'count' => $totalBatches, 'icon' => 'layer-group', 'color' => 'danger', 'link' => 'manage-batch.php'],
                        ['title' => 'Ongoing Batches', 'count' => $ongoingBatches, 'icon' => 'spinner', 'color' => 'teal', 'link' => 'ongoing-batches.php'],
                        ['title' => 'Assed Batches', 'count' => $assedBatches, 'icon' => 'check-circle', 'color' => 'purple', 'link' => 'assed-batches.php'],
                        ['title' => 'Batch Results', 'count' => $totalResults, 'icon' => 'chart-line', 'color' => 'warning', 'link' => 'manage-subjects.php'],
                        ['title' => 'Training Centers', 'count' => $totalTC, 'icon' => 'school', 'color' => 'secondary', 'link' => 'manage-trainingcenter.php'],
                        ['title' => 'Schemes', 'count' => $totalSchemes, 'icon' => 'clipboard-list', 'color' => 'pink', 'link' => 'manage-scheme.php'],
                        ['title' => 'Sectors', 'count' => $totalSectors, 'icon' => 'industry', 'color' => 'success', 'link' => 'manage-sector.php'],
                        ['title' => 'Job Rolls', 'count' => $totalJobroll, 'icon' => 'briefcase', 'color' => 'dark', 'link' => 'manage-jobroll.php']
                    ];

                    foreach ($cards as $card) {
                    ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="dashboard-card text-<?php echo $card['color']; ?>" 
                                 onclick="location.href='<?php echo $card['link']; ?>'">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3><?php echo htmlentities($card['count']); ?></h3>
                                        <p><?php echo $card['title']; ?></p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa-solid fa-<?php echo $card['icon']; ?>"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>
<?php } ?>