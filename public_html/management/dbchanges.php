<?php
/**
 * Called by index.php using AJAX to make changes to the database,
 * such as approving a video.
 */

$approveid = $_REQUEST["approveid"];
$vidstatus = $_REQUEST["vidstatus"];
$rmcode = $_REQUEST["rmcode"];

// Connect to database
require_once '../dbconnect.php';
$dbh = dbconnect();

$sql_command = "UPDATE videos SET video_status = :vidstatus WHERE id = :id ;";

if ($vidstatus == 3) {
    $sql_command = "UPDATE videos SET video_status = :vidstatus, removal_code = :rmcode WHERE id = :id ;";
    $query = $dbh->prepare(
        $sql_command
    );
    $results = $query->execute(array('vidstatus' => $vidstatus, 'rmcode' => $rmcode, 'id' => $approveid));
    echo "Video deleted";
} else {
    $query = $dbh->prepare(
        $sql_command
    );

    $results = $query->execute(array('vidstatus' => $vidstatus, 'id' => $approveid));
    echo "Video status changed";
}

