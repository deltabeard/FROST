<?php
if ((($_FILES["userfile"]["type"] == "video/webm")
|| ($_FILES["userfile"]["type"] == "video/mp4")
|| ($_FILES["userfile"]["type"] == "video/ogg")
&& ($_FILES["userfile"]["size"] < 50000000)))
{
	if ($_FILES["userfile"]["error"] > 0) {
		// Return an error if file does not meet requirements
		echo "Return Code: " . $_FILES["userfile"]["error"] . "<br>";
	} else {

		// Remove HTML and special characters from filename
		// Strip HTML Tags
		// Clean up things like &amp;
		// Strip out any url-encoded stuff
		// Replace non-AlNum characters with space
		// Replace Multiple spaces with single space
		// Trim the string of leading/trailing space
		$filename = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9. ]/', ' ', urldecode(html_entity_decode(strip_tags($_FILES["userfile"]["name"]))))));
		$description = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9. ]/', ' ', urldecode(html_entity_decode(strip_tags($_POST["description"]))))));
		$title = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($_POST["title"]))))));

		$video_upload_date = date("Y-m-d H:i:s");
		$video_serial = hash('sha256', $title . $video_upload_date);

		if (empty($_POST["trip_pass"])) {
			$trip = "Anonymous";
		} else {
			// Strongly recommended to replace the string used as salt here
			$trip = crypt($_POST["trip_pass"], 'ThIsISs@lt.UFR EW(YY!d<AU&|vueG7NP?J*Ns*Ug+JEClm)D!f>KLOzQb?0;?Z$@]h<7{OQ|');
		}

		// Display information
		echo "File name on upload: " . $_FILES["userfile"]["name"] . "<br>";
		echo "Title: " . $title . "<br>";
		echo "Description: " . $description . "<br>";
		echo "Type: " . $_FILES["userfile"]["type"] . "<br>";
		echo "Size: " . ($_FILES["userfile"]["size"] / 1024) . " kB<br>";
		echo "Temp file: " . $_FILES["userfile"]["tmp_name"] . "<br>";
		echo "Time video completed upload: " . $video_upload_date . "<br>";
		echo "Unique video serial: " . $video_serial . "<br>";
		echo "Trip code of uploader: " . $trip . "<br>";
		
		if (file_exists("upload/$filename")) {
			echo $filename . " already exists. ";
		} else {
			// If requirements of the file are met, move the file from temp to permanent location
			move_uploaded_file($_FILES["userfile"]["tmp_name"],
			"upload/$filename");
			echo "Stored in: " . "upload/$filename";
		}
		// Display video
		echo "<br><video controls><source src='upload/" . $filename . "' type='" . $_FILES["userfile"]["type"] . "'>Your browser does not support the video tag.</video>";
	}
} else {
	echo "Invalid file - Exceeds file size limits or bad file type";
}
?> 
