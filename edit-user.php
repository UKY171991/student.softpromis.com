<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['update'])) {
        $username = $_POST['username'];
        $userid = ($_POST['userid']);
        $password = md5($_POST['password']);
        $user_type = $_POST['user_type'];
        $email = $_POST['email'];

        if($_POST['password'] !=''){
            $sql = "update  admin set UserName=:username,email=:email,Password=:password,user_type=:user_type where id=:userid ";
            $query = $dbh->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':user_type', $user_type, PDO::PARAM_STR);
            $query->bindParam(':userid', $userid, PDO::PARAM_STR);
        }else{
            $sql = "update  admin set UserName=:username,email=:email,user_type=:user_type where id=:userid ";
            $query = $dbh->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':user_type', $user_type, PDO::PARAM_STR);
            $query->bindParam(':userid', $userid, PDO::PARAM_STR);
        }

        
        $query->execute();
        $msg = "Data has been updated successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFTPRO | ADMIN</title>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style type="text/css">
        .error { color: red; font-size: 14px; display: none; }
    </style>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-----End Top bar> -->
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
                                <h2 class="title">Update user Details </h2>
                            </div>

                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="#">Admin control</a></li>
                                    <li class="active">Update user</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->

                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel p-5">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Update user info</h5>
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

                                        <form action="edit-user.php" method="post" id="myForm">

                                            <?php
                                                $sid = intval($_GET['userid']);
                                                $sql = "SELECT * from admin where id=:sid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                 $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {   ?>
                                            <input type="hidden" name="userid" value="<?php echo $sid; ?>">

                                            <div class="form-group has-success">
                                                <label for="success" class="control-label">user Name</label>
                                                <div class="">
                                                    <select name="user_type" class="form-control" required="required" id="success">
                                                            <option value="">Select User Type</option>
                                                            <option value="1" <?php if($result->user_type == 1){ echo 'selected';}else{ echo ''; }?>>Admin</option>
                                                            <option value="2" <?php if($result->user_type == 2){ echo 'selected';}else{ echo ''; }?>>MIS</option>
                                                            <option value="3" <?php if($result->user_type == 3){ echo 'selected';}else{ echo ''; }?>>Training Center</option>
                                                        </select>


                                                </div>
                                            </div>

                                            <div class="form-group has-success">
                                                <label for="success" class="control-label">Email</label>
                                                <div class="">
                                                    <input type="email" name="email"
                                                        value="<?php echo htmlentities($result->email); ?>"
                                                        required="required" class="form-control" id="success">


                                                </div>
                                            </div>

                                            <div class="form-group has-success">
                                                <label for="success" class="control-label">user Name</label>
                                                <div class="">
                                                    <input type="text" name="username"
                                                        value="<?php echo htmlentities($result->UserName); ?>"
                                                        required="required" class="form-control" id="success">


                                                </div>
                                            </div>

                                            <div class="form-group has-success">
                                                <label for="success" class="control-label">Password</label>
                                                <div class="">
                                                    <input type="password" name="password" value=""
                                                        class="form-control password" id="success">


                                                </div>
                                                <span class="error" id="passwordError">Password must be at least 8 characters and include uppercase, lowercase, number, and special character.</span>
                                            </div>


                                            <?php }
                                                } ?>
                                            <div class="form-group has-success">

                                                <div class="">
                                                    <button type="submit" name="update"
                                                        class="btn btn-success btn-labeled">Update<span
                                                            class="btn-label btn-label-right"><i
                                                                class="fa fa-check"></i></span></button>
                                                </div>



                                        </form>


                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-8 col-md-offset-2 -->
                        </div>
                        <!-- /.row -->




                </div>
                <!-- /.container-fluid -->
                </section>
                <!-- /.section -->

            </div>
            <!-- /.main-page -->


            <!-- /.right-sidebar -->

        </div>
        <!-- /.content-container -->
    </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- /.main-wrapper -->

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>



    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->

    <script>
        $(document).ready(function () {
            $("#myForm").on("submit", function (e) {
                var password = $(".password").val();
                if(password !=''){
                    var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

                    if (!passwordPattern.test(password)) {
                        e.preventDefault(); // Prevent form submission
                        $("#passwordError").show(); // Show error message
                    } else {
                        $("#passwordError").hide(); // Hide error if valid
                    }
                }
                
            });
        });
    </script>
</body>

</html>
<?php  } ?>