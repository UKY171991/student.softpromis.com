<nav class="col-lg-2 col-md-3 d-none d-md-block sidebar p-0 sidebar-nav sidebarnew">
    <div class="sidebar-header">
        <img src="images/logo.jpg" alt="Profile" class="rounded-circle mb-2" width="80">
        <h6>Rajesh G</h6>
        <small>Softpro Admin</small>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">
                <i class="fa-solid fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="account.php" class="nav-link">
                <i class="fa fa fa-server"></i> <span>Account</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#candidateSubmenu" role="button" aria-expanded="false" aria-controls="candidateSubmenu">
                <i class="fa-solid fa-users me-2"></i>Candidate <i class="fa-solid fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="candidateSubmenu">
                <ul class="nav flex-column ps-3">
                    <li class="nav-item">
                        <a class="nav-link" href="add-candidate.php"><i class="fa fa-user-plus me-2"></i>Register Candidate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="candidate-bulk-upload.php"><i class="fa fa-upload me-2"></i>Bulk Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage-candidate.php"><i class="fa fa-users me-2"></i>Manage Candidates</a>
                    </li>
                </ul>
            </div>
        </li>




        <?php if($_SESSION['user_type'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#trainingCenterSubmenu" role="button" aria-expanded="false" aria-controls="trainingCenterSubmenu">
                    <i class="fa fa-users me-2"></i>Training Center <i class="fa-solid fa-chevron-down float-end"></i>
                </a>
                <div class="collapse" id="trainingCenterSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item">
                            <a class="nav-link" href="create-trainingcenter.php"><i class="fa fa-plus me-2"></i>Create Training Center</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage-trainingcenter.php"><i class="fa fa-cogs me-2"></i>Manage Training Center</a>
                        </li>
                    </ul>
                </div>
            </li>
        <?php } ?>

        <?php if($_SESSION['user_type']==1){ ?>
    <!-- Scheme Sub-menu -->
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#schemeSubmenu" role="button" aria-expanded="false" aria-controls="schemeSubmenu">
            <i class="fa fa-bandcamp me-2"></i>Scheme <i class="fa-solid fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="schemeSubmenu">
            <ul class="nav flex-column ps-3">
                <li class="nav-item"><a class="nav-link" href="create-scheme.php"><i class="fa fa-plus me-2"></i>Create Scheme</a></li>
                <li class="nav-item"><a class="nav-link" href="manage-scheme.php"><i class="fa fa-cogs me-2"></i>Manage Scheme</a></li>
                <li class="nav-item"><a class="nav-link" href="asign-scheme.php"><i class="fa fa-handshake me-2"></i>Assign Scheme</a></li>
            </ul>
        </div>
    </li>

    <!-- Sector Sub-menu -->
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#sectorSubmenu" role="button" aria-expanded="false" aria-controls="sectorSubmenu">
            <i class="fa fa-building me-2"></i>Sector <i class="fa-solid fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="sectorSubmenu">
            <ul class="nav flex-column ps-3">
                <li class="nav-item"><a class="nav-link" href="create-sector.php"><i class="fa fa-plus me-2"></i>Create Sector</a></li>
                <li class="nav-item"><a class="nav-link" href="manage-sector.php"><i class="fa fa-cogs me-2"></i>Manage Sector</a></li>
                <li class="nav-item"><a class="nav-link" href="assign-sector.php"><i class="fa fa-check-circle me-2"></i>Assign Sector</a></li>
            </ul>
        </div>
    </li>

    <!-- Job Roll Sub-menu -->
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#jobRollSubmenu" role="button" aria-expanded="false" aria-controls="jobRollSubmenu">
            <i class="fa fa-briefcase me-2"></i>Job Roll <i class="fa-solid fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="jobRollSubmenu">
            <ul class="nav flex-column ps-3">
                <li class="nav-item"><a class="nav-link" href="create-jobroll.php"><i class="fa fa-plus me-2"></i>Create Job Roll</a></li>
                <li class="nav-item"><a class="nav-link" href="manage-jobroll.php"><i class="fa fa-cogs me-2"></i>Manage Job Roll</a></li>
                <li class="nav-item"><a class="nav-link" href="assign-jobroll.php"><i class="fa fa-check-circle me-2"></i>Assign Job Roll</a></li>
            </ul>
        </div>
    </li>
    <?php } ?>  

    <!-- Batch Sub-menu -->
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#batchSubmenu" role="button" aria-expanded="false" aria-controls="batchSubmenu">
            <i class="fa fa-users me-2"></i>Batch <i class="fa-solid fa-chevron-down float-end"></i>
        </a>
        <div class="collapse" id="batchSubmenu">
            <ul class="nav flex-column ps-3">
                <li class="nav-item"><a class="nav-link" href="add-batch.php"><i class="fa fa-plus me-2"></i>Add Batch</a></li>
                <li class="nav-item"><a class="nav-link" href="manage-batch.php"><i class="fa fa-cogs me-2"></i>Manage Batch</a></li>
                <li class="nav-item"><a class="nav-link" href="add-candidate-to-batch.php"><i class="fa fa-user-plus me-2"></i>Add Candidate to Batch</a></li>
            </ul>
        </div>
    </li>

        <!-- Result Sub-menu -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#resultSubmenu" role="button" aria-expanded="false" aria-controls="resultSubmenu">
                <i class="fa fa-rocket me-2"></i>Result <i class="fa-solid fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="resultSubmenu">
                <ul class="nav flex-column ps-3">
                    <li class="nav-item"><a class="nav-link" href="add-result.php"><i class="fa fa-plus me-2"></i>Add Result</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage-results.php"><i class="fa fa-cogs me-2"></i>Manage Results</a></li>
                </ul>
            </div>
        </li>

        <!-- Placement Sub-menu -->
        <li class="nav-item">
            <a class="nav-link" href="manage-placement.php">
                <i class="fa fa-handshake me-2"></i>Placement
            </a>
        </li>

        <!-- Certification Sub-menu -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#certificationSubmenu" role="button" aria-expanded="false" aria-controls="certificationSubmenu">
                <i class="fa fa-certificate me-2"></i>Certification <i class="fa-solid fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="certificationSubmenu">
                <ul class="nav flex-column ps-3">
                    <li class="nav-item"><a class="nav-link" href="add-certification.php"><i class="fa fa-plus me-2"></i>Add Certificate</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage-certification.php"><i class="fa fa-cogs me-2"></i>Manage Certificate</a></li>
                </ul>
            </div>
        </li>

        <!-- Invoice Sub-menu -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#invoiceSubmenu" role="button" aria-expanded="false" aria-controls="invoiceSubmenu">
                <i class="fa fa-file-invoice me-2"></i>Invoice <i class="fa-solid fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="invoiceSubmenu">
                <ul class="nav flex-column ps-3">
                    <li class="nav-item"><a class="nav-link" href="add-invoice.php"><i class="fa fa-plus me-2"></i>Add Invoice</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage-invoice.php"><i class="fa fa-cogs me-2"></i>Manage Invoice</a></li>
                </ul>
            </div>
        </li>

        <?php if($_SESSION['user_type']==1){ ?>
            <!-- Admin Control Sub-menu -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#adminSubmenu" role="button" aria-expanded="false" aria-controls="adminSubmenu">
                    <i class="fa fa-lock me-2"></i>Admin Control <i class="fa-solid fa-chevron-down float-end"></i>
                </a>
                <div class="collapse" id="adminSubmenu">
                    <ul class="nav flex-column ps-3">
                        <li class="nav-item"><a class="nav-link" href="create-user.php"><i class="fa fa-user-plus me-2"></i>Create User</a></li>
                        <li class="nav-item"><a class="nav-link" href="manage-user.php"><i class="fa fa-cogs me-2"></i>Manage User</a></li>
                    </ul>
                </div>
            </li>
        <?php } ?>
    </ul>
</nav>