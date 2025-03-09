<!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">SOFTPRO Admin</a>
      

      <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button> -->

      <button type="button" class="navbar-toggle mobile-nav-toggle sidebar-nav-old">
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