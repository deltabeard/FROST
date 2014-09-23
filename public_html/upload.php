<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="styles/banner.css">
	<title>FROST - Upload video</title>
</head>

<body>
	<div id="site-header">
		<div id="site-header-container">
			<div id="nav">
				FROST
			</div>
		</div>
	</div>

	<h2>Upload</h2>
	<!-- The data encoding type, enctype, MUST be specified as below -->
	<form enctype="multipart/form-data" action="upload_file.php" method="POST">
		<!-- MAX_FILE_SIZE must precede the file input field -->
		<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
		<!-- Name of input element determines name in $_FILES array -->
		Send this file: <input name="userfile" type="file" />
		<input type="submit" value="Send File" />
	</form>

</body>
</html>
