<?php
/**
 * Called by management/index.php using AJAX to make changes to the database,
 * such as approving a video.
 */

$id = $_REQUEST["id"];
$vidstatus = $_REQUEST["vidstatus"];
$rmcode = $_REQUEST["rmcode"];
$host_code = $_REQUEST["host_code"];
$file_location = $_REQUEST["file_location"];

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
    if ($host_code == 1){
        // If hosted on local server, delete file
        // Get file name from database
        $sql_command = "SELECT * FROM `videos` WHERE `id` = :id;";
        $query = $dbh->prepare(
            $sql_command
        );
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        $file_name = $row['url'];
        // Add check to see if another database record links to the file.
        $delete_success = unlink(".." . DIRECTORY_SEPARATOR . "upload" . DIRECTORY_SEPARATOR ."$file_name");
        echo ($delete_success == TRUE ? 'File Deleted.' : 'File could not be deleted.');
    } elseif ($host_code == 2){
        echo "File hosted on pomf.se";
    } else{
        echo "Error - Incorrect host code: " . $host_code;
    }
    echo "Deleted. Reason: " . $rmcode;
} elseif ($vidstatus == 2) {
    $query = $dbh->prepare(
        $sql_command
    );
    $results = $query->execute(array('vidstatus' => $vidstatus, 'id' => $id));
    echo("Approved <a href='#' onclick='approveVid($id, 1, null, null, null);return false;' class='button'>Unapprove</a><a  href='#' onclick='approveVid($id, 3, 1, null, null);return false;' class='button' id='warnBtn'>Delete</a>");
} elseif ($vidstatus == 1) {
    $query = $dbh->prepare(
        $sql_command
    );
    $results = $query->execute(array('vidstatus' => $vidstatus, 'id' => $id));
    echo("Unmoderated <a href='#' onclick='approveVid($id, 2, null, null, null);return false;' class='button'>Approve</a><a  href='#' onclick='approveVid($id, 3, 1, null, null);return false;' class='button' id='warnBtn'>Delete</a>");
}

