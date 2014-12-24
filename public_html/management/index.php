<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>FROST - Management Interface</title>
	<link rel="stylesheet" type="text/css" href="../styles/master.css">
</head>

<body>
  <?php
	include 'banner-mgmt.html';
  ?>
  This is the FROST Management Interface.<br>
  
  List of all videos:<br>
  
  <?php
	// Connect to database
	require_once '../dbconnect.php';
	$dbh = dbconnect();
	
	$query = $dbh->prepare(
		"SELECT * FROM videos"
	);
	
	$results = $query->execute();
	
	// Get working directory
	$cwd = ("http://" . $_SERVER['HTTP_HOST'] . getwd() . "/")
  ?>
  
  <table>
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Description</th>
		<th>File type</th>
		<th>Upload Date</th>
		<th>IP address of Uploader</th>
		<th>Uploader Name and Tripcode</th>
		<th>URL</th>
		<th>Status</th>
	</tr>
	<?php while($row = $query->fetch()) : ?>
	<tr>
		<td><?php echo $row['id']; ?></td>
		<td><?php echo $row['title']; ?></td>
		<td><?php echo ( NULL == $row['description'] ) ? "<i>NULL</i>" : $row['description']; ?></td>
		<td><?php echo $row['filetype']; ?></td>
		<td><?php echo $row['upload_date']; ?></td>
		<td><?php echo $row['uploader_ip']; ?></td>
		<td><?php echo ($row['uploader_name'] . "!" . $row['tripcode']); ?></td>
		<td><?php
			if ( $row['host_code'] == 1 ) {
				echo ("<a href='" . $cwd . $row['url'] . "'>Hosted locally</a>");
			} elseif ( $row['host_code'] == 2 ) {
				echo ("<a href='http://a.pomf.se/" . $row['url'] . "'>Hosted on pomf.se</a>");
			} else {
				echo ("Hosted elsewhere: " . $row['url']);
			}
			?>
		</td>
		<td><?php 
			if ( $row['video_status'] == 1 ) {
				echo "Unmoderated";
				echo ("<a href='index.php' class='button' id='uploadBtn'>Approve</a>");
			} elseif ( $row['video_status'] == 2 ) {
				echo "Approved";
			} elseif ( $row['video_status'] == 3 ) {
				echo ("Deleted. Reason: " . $row['removal_code']);
			} else {
				echo ("Error: video_status of " . $row['video_status'] . " is unacceptable");
			}
			?>
		</td>
	</tr>
	<?php endwhile; ?>
  </table>

  
<?php

echo ("http://" . $_SERVER['HTTP_HOST'] . getwd());

?>

  
</body>
</html>
