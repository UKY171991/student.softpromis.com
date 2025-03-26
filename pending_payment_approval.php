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



    
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />

  <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen"> -->
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
  <link rel="stylesheet" href="includes/style.css">
  <style type="text/css">
      select.input-sm {
            height: 30px;
            line-height: 20px;
        }
  </style>

</head>
<body>
  <!-- Top Navbar -->
  <?php include('includes/topbar-new.php'); ?>
  
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->

      <?php include('includes/left-sidebar-new.php'); ?>
       <?php include('includes/leftbar.php'); ?>


      <!-- Main Content -->
      <main class="col-lg-10 col-md-9 p-4">
        <h2 class="mb-4">Softpro Dashboard</h2>
      

      <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Pending Approval</h5>
            </div>
            <div class="card-body">
                <div class="panel-heading">
                    <div class="panel-title" style="display: flex;">
                        <?php
                        $sqls = "SELECT SUM(paid) as total_paid FROM emi_list WHERE added_type = 2";
                        $querys = $dbh->prepare($sqls);
                        $querys->execute();
                        $res = $querys->fetch(PDO::FETCH_OBJ); 

                        //print_r($res->total_paid);
                        ?>

                        <!-- <h5>Pending Payment Approval : <?=$res->total_paid?></h5> -->
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
                    <table id="example"
                        class="table table-stripped table-bordered table-hover table-full-width table-grey table-responsive-lg"
                        cellspacing="0" width="100%">
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
                             $sql = "SELECT * from emi_list where added_type= 2";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;



                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { 
                                        $candidate_id = $result->candidate_id;


                                         $sql_p = "SELECT * from payment where added_type= 2";
                                         $query_p = $dbh->prepare($sql_p);
                                         $query_p->execute();
                                         $results_p = $query_p->fetchAll(PDO::FETCH_OBJ);

                                    

                                        $sql_c = "SELECT * from tblcandidate where CandidateId= '$candidate_id'";
                                        $query_c = $dbh->prepare($sql_c);
                                        $query_c->execute();
                                        $results_c = $query_c->fetchAll(PDO::FETCH_OBJ);

                                ?>
                            <tr>
                                <td>
                                    <?php echo htmlentities($cnt); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($results_c[0]->enrollmentid); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($results_c[0]->candidatename); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($results_p[0]->total_fee); ?>
                                </td>

                                <td>
                                    <?php echo htmlentities($results_p[0]->paid); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($results_p[0]->balance); ?>
                                </td>

                                <td>
                                    <?php echo htmlentities($result->paid); ?>
                                </td>
                                
                                <td>
                                    <?php echo date("d M Y h:i:s A", strtotime($result->created)); ?>
                                </td>
                                <td>
                                    <?php
                                     if($_SESSION['user_type']!=1){
                                        echo "Pending Approval";
                                     }else{
                                        echo '<a class="badge badge-info" href="#" onclick="updateStatus( '. htmlentities($result->candidate_id) .', '. htmlentities($result->id) .')">Approve</a>';
                                     } 
                                     ?>
                                    
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

    </main>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

  <!-- Bootstrap Bundle with Popper -->
  

  <script src="js/jquery/jquery-2.2.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/bootstrap/bootstrap.min.js"></script>
  <script src="js/pace/pace.min.js"></script>
  <script src="js/lobipanel/lobipanel.min.js"></script>
  <script src="js/iscroll/iscroll.js"></script>
  <script src="js/prism/prism.js"></script>
  <script src="js/select2/select2.min.js"></script>
  <script src="js/DataTables/datatables.min.js"></script>
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


<script>

function updateStatus(candidateId,id) {
    // Ask for confirmation
    if (confirm("Are you sure you want to update the status?")) {
        $.ajax({
            url: 'appve_ajax.php',  // Path to the PHP backend file
            type: 'POST',
            data: { candidate_id: candidateId,id:id },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success'){
                    alert('Status updated successfully!');
                     window.location.reload();
                    // Optionally, update the UI here (e.g., change a label or reload a section)
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
