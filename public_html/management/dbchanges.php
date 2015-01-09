<?php
/**
 * Called by index.php using AJAX to make changes to the database,
 * such as approving a video.
 */

$approveid = $_REQUEST["approveid"];
$vidstatus = $_REQUEST["vidstatus"];

$output = "";

if(isset($approveid)){
    echo $approveid;
}

// Connect to database
require_once '../dbconnect.php';
$dbh = dbconnect();

$sql_command =  "UPDATE videos SET video_status = :vidstatus WHERE id = :id ;";

if($vidstatus == 3){
    $sql_command =  "UPDATE videos SET video_status = :vidstatus, removal_code = :rmcode WHERE id = :id ;";
    $query = $dbh->prepare(
        $sql_command
    );
    $results = $query->execute(array('vidstatus' => $vidstatus, 'rmcode' => '1', 'id' => $approveid));
} else {
    $query = $dbh->prepare(
        $sql_command
    );

    $results = $query->execute(array('vidstatus' => $vidstatus, 'id' => $approveid));
}

