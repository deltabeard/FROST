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
		Title: <input type="text" name="title"><br>
		Description:  <textarea maxlength="500" name="description">Enter a description of the video here...</textarea><br>
		Trip-code password: <input type="text" name="trip_pass"><br>
		<input type="checkbox" name="uploadtopomf" value="true">Upload to pomf.se? <br>
		Upload: <input type="file" name="userfile" data-max-size="50MiB">
		<input type="submit" value="Send File">
	</form>

</body>
</html>
