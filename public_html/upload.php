<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>FROST - Upload video</title>
</head>

<body>
	<?php
		include 'banner.html';
	?>

	<h2>Upload</h2>
	<form enctype="multipart/form-data" action="upload_file.php" method="POST">
		<!-- Video information -->
		<label for="title">Title: </label><input type="text" name="title"><br>
		<label for="description">Description: </label><textarea maxlength="500" name="description" placeholder="Enter a description of the video here..."></textarea><br>
		<label for="trip_pass">Trip-code password: </label><input type="text" name="trip_pass"><br>
		<input type="checkbox" name="uploadtopomf" value="true"><label for="uploadtopomf">Upload to pomf.se?</label> <br>
		<label for="userfile">Upload:</label><input type="file" name="userfile" data-max-size="50MiB">
		<input type="submit" value="Send File">
	</form>

</body>
</html>
