<?php
include('includes/config.php');

if (isset($_POST['job_id'])) {
    $job_id = intval($_POST['job_id']);

    // Example Query: Adjust according to your actual database schema
    $sql = "SELECT id,job_roll_id, batch_name FROM tblbatch WHERE job_roll_id = :job_id ORDER BY id DESC";
    $query = $dbh->prepare($sql);
    $query->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $query->execute();

    $batches = $query->fetchAll(PDO::FETCH_ASSOC);

    //print_r($batches);

    echo json_encode($batches);
}


if (isset($_POST['training_center'])) {
    $training_center = intval($_POST['training_center']);

    $sql_s = "SELECT * FROM tblassignscheme WHERE trainingcenter_id = :training_center ORDER BY id DESC";
    $query_s = $dbh->prepare($sql_s);
    $query_s->bindParam(':training_center', $training_center, PDO::PARAM_INT);
    $query_s->execute();

    $sch_s = $query_s->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sch_s as $row5) {
    	$scheme_id = $row5['scheme_id'];

    	// Example Query: Adjust according to your actual database schema
	    $sql = "SELECT SchemeId, SchemeName FROM tblscheme WHERE SchemeId = :scheme_id ORDER BY id DESC";
	    $query = $dbh->prepare($sql);
	    $query->bindParam(':scheme_id', $scheme_id, PDO::PARAM_INT);
	    $query->execute();

	    $training_center = $query->fetchAll(PDO::FETCH_ASSOC);

	    //print_r($training_center);

	    echo json_encode($training_center);

    }

    //print_r($sch_s[0]['scheme_id']);

    exit();
}
?>
