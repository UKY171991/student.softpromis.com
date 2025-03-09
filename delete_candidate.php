<?php
include('includes/config.php');

if(isset($_POST['ids'])) {
    $ids = implode(",", $_POST['ids']); // Convert array to comma-separated string

    $sql = "DELETE FROM tblcandidate WHERE CandidateId IN ($ids)";
    $query = $dbh->prepare($sql);
    if ($query->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "no_ids";
}
?>
