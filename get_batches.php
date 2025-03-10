<?php
include('includes/config.php');

if (isset($_POST['job_id'])) {
    echo $job_id = intval($_POST['job_id']);

    // Example Query: Adjust according to your actual database schema
    $sql = "SELECT id,job_role_id, batch_name FROM tblbatch WHERE job_role_id = :job_id ORDER BY id DESC";
    $query = $dbh->prepare($sql);
    $query->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $query->execute();

    $batches = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($batches);
}
?>
