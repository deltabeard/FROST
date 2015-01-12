<?php
/**
 * Called by management/index.php using AJAX to make changes to the database,
 * such as approving a video.
 */

$id = $_REQUEST["id"];
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
    $results = $query->execute(array('vidstatus' => $vidstatus, 'rmcode' => $rmcode, 'id' => $id));
    echo "Deleted. Reason: " . $rmcode;
} elseif ($vidstatus == 2) {
    $query = $dbh->prepare(
        $sql_command
    );
    $results = $query->execute(array('vidstatus' => $vidstatus, 'id' => $id));
    echo("Approved <a href='#' onclick='approveVid($id, 1, null);return false;' class='button'>Unapprove</a><a  href='#' onclick='approveVid($id, 3, 1);return false;' class='button' id='warnBtn'>Delete</a>");
} elseif ($vidstatus == 1) {
    $query = $dbh->prepare(
        $sql_command
    );
    $results = $query->execute(array('vidstatus' => $vidstatus, 'id' => $id));
    echo("Unmoderated <a href='#' onclick='approveVid($id, 2, null);return false;' class='button'>Approve</a><a  href='#' onclick='approveVid($id, 3, 1);return false;' class='button' id='warnBtn'>Delete</a>");
}

