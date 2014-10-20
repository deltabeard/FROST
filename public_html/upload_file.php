<?php // ini_set('display_errors',1); error_reporting(E_ALL); // Display errors
if ((($_FILES["userfile"]["type"] == "video/webm")  /* <-- This is naive since the type can be faked */
|| ($_FILES["userfile"]["type"] == "video/mp4")     /* We should try using finfo_open */
|| ($_FILES["userfile"]["type"] == "video/ogg")
&& ($_FILES["userfile"]["size"] < 50000000)))
{
	if ($_FILES["userfile"]["error"] > 0) {
		// Return an error if file does not meet requirements
		echo "Return Code: " . $_FILES["userfile"]["error"] . "<br>";
	}
    else {
        $addToDb = false;

        // Create/initialise fields for insertion into table
        $title = trim(htmlentities(strip_tags($_POST["title"]), ENT_QUOTES));
        $description = trim(htmlentities(strip_tags($_POST["description"]), ENT_QUOTES));
        $filetype = substr($_FILES["userfile"]["type"], 6);
        $url;
        $host_code;
        $uploader_ip = $_SERVER["REMOTE_ADDR"];

        // Seperate uploader_name and tripcode and legalise the characters.
        $uploader_info = explode("#", $_POST["uploader_name"]);
        $uploader_info[0] == "" ? $uploader_name = null : $uploader_name = $uploader_info[0];
        $uploader_name = trim(htmlentities(strip_tags($uploader_name), ENT_QUOTES));
        $tripcode; // = generate tripcode

        $video_upload_date = date("Y-m-d H:i:s");
		$filename = trim(htmlentities(strip_tags($_FILES["userfile"]["name"]), ENT_QUOTES));

//		if (!array_key_exists(1, $uploader_info)) {
//			$tripcode = null;
//		}
//        else {
//			// Strongly recommended to replace the string used as salt here
//			$tripcode = crypt($_POST["trip_pass"], 'ThIsISs@lt.UFR EW(YY!d<AU&|vueG7NP?J*Ns*Ug+JEClm)D!f>KLOzQb?0;?Z$@]h<7{OQ|');
//		}

		// Display information
		echo "File name on upload: " . $filename . "<br>";
		echo "Title: " . $title . "<br>";
		echo "Description: " . $description . "<br>";
		echo "Type: " . $filetype . "<br>";
		echo "Size: " . ($_FILES["userfile"]["size"] / 1024) . " kB<br>";
        echo "Uploader name: " . $uploader_name . "<br>";
		echo "Temp file: " . $_FILES["userfile"]["tmp_name"] . "<br>";
		echo "Time video completed upload: " . $video_upload_date . "<br>";
		echo "Trip code of uploader: " . $tripcode . "<br>";
		
		if (isset($_POST["uploadtopomf"])) {

			echo "<pre>";
			echo "Loading ...";

			function curl_progress_callback($resource, $download_size, $downloaded, $upload_size, $uploaded)
			{
				if($upload_size > 0) {
					echo $uploaded / $upload_size  * 100 . "%";
					echo " Average upload speed: " . curl_getinfo($resource, CURLINFO_SPEED_UPLOAD) . "B/s<br>";
				}
				ob_flush();
				flush();
			}

			// Increase max execution time to a day
			set_time_limit(86400);

			ob_flush();
			flush();

			// initialise the curl request
			$request = curl_init('http://pomf.se/upload.php');

            // Used for compatibility with PHP 5.6+
            // This allows support for uploading files in CURLOPT_POSTFIELDS using the @ prefix
            curl_setopt($request, CURLOPT_SAFE_UPLOAD, false);  // This will be changed to curlfile at a later date

			// Set options to get progress bar
			curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($request, CURLOPT_PROGRESSFUNCTION, 'curl_progress_callback');
			curl_setopt($request, CURLOPT_NOPROGRESS, false); // needed to make progress function work
			curl_setopt($request, CURLOPT_HEADER, 0);
			curl_setopt($request, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

			// send a file
			curl_setopt($request, CURLOPT_POST, true);
			curl_setopt(
				$request,
				CURLOPT_POSTFIELDS,
				array(
					'files[]' =>
                        '@' 		. $_FILES["userfile"]["tmp_name"]
    					. ';filename='	. $_FILES["userfile"]["name"]
    					. ';type='	. $_FILES["userfile"]["type"]
				));

            // Execute the upload and decode the url it was stored at
            $jsonArray = json_decode(curl_exec($request), true);
            $url = $jsonArray['files'][0]['url'];

			// close the session
			curl_close($request);

			echo "Done<br>";
            $addToDb = true;
			ob_flush();
			flush();

		}
        else {
			if (file_exists("upload/$filename")) {
				echo $filename . " already exists. ";
			}
            else {
				// If requirements of the file are met, move the file from temp to permanent location
				move_uploaded_file($_FILES["userfile"]["tmp_name"],
				"upload/$filename");
				echo "Stored in: " . "upload/$filename";
			}
            $addToDb = true;
            $url = "upload/$filename";
			// Display video
			echo "<br><video controls><source src='upload/" . $filename . "' type='" . $_FILES["userfile"]["type"] . "'>Your browser does not support the video tag.</video>";
		}
        if($addToDb) {
            require_once 'dbconnect.php';
            $dbh = dbconnect();
            $sql = 'INSERT INTO videos
                    (title, description, filetype, url, host_code, uploader_ip, uploader_name, tripcode, upload_date
                    VALUES
                    ';
            echo "Located at: " . $url;
        }
	}
}
else {
	echo "Invalid file - Exceeds file size limits or bad file type";
}
?> 
