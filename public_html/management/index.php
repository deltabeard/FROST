<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FROST - Management Interface</title>
    <link rel="stylesheet" type="text/css" href="../styles/master.css">
    <link rel="stylesheet" type="text/css" href="../styles/management.css">
    <script src="dbchanges.js"></script>
</head>

<body>
<?php
include 'banner-mgmt.html';
?>
This is the FROST Management Interface.<br>


<?php
// Connect to database
require_once '../dbconnect.php';
$dbh = dbconnect();

$sql_command = 'SELECT * FROM videos';

if (isset($_GET["show_all_vid"])) {
    if ($_GET["show_all_vid"] != "True") {
        $sql_command .= " WHERE video_status = 1";
        echo "Showing only unmoderated videos<br>";
    }
} else {
    $sql_command .= " WHERE video_status = 1";
    echo "Showing only unmoderated videos<br>";
}

if (isset($_GET["sort"])) {
    if ($_GET["sort"] == "desc") {
        $sql_command .= " ORDER BY id DESC";
        echo "Sorted by ID descending.<br>";
    }
}

echo "Debug: Running command: " . $sql_command;

$query = $dbh->prepare(
    $sql_command
);

$results = $query->execute();

// Get working directory
$cwd = ("http://" . $_SERVER['HTTP_HOST'] . getwd() . "/");

?>

<form action="index.php" method="get">
    Sort ID by:
    <select name="sort">
        <option value="asc">Ascending</option>
        <option value="desc">Descending</option>
    </select>
    <input type="checkbox" id="show_all_vid" name="show_all_vid" value="True">
    <label for="show_all_vid">Show All Videos</label>
    <input type="submit">
</form>

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
    <?php while ($row = $query->fetch()) : ?>
        <tr>
            <td><?php
                $id = $row['id'];
                echo $id;
                ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo (NULL == $row['description']) ? "<i>NULL</i>" : $row['description']; ?></td>
            <td><?php echo $row['filetype']; ?></td>
            <td><?php echo $row['upload_date']; ?></td>
            <td><?php echo $row['uploader_ip']; ?></td>
            <td><?php echo(($row['uploader_name'] == null ? "<i>Anonymous</i>" : $row['uploader_name']) . ($row['tripcode'] == null ? "" : ("!" . $row['tripcode']))); ?></td>
            <td><?php
                if ($row['host_code'] == 1) {
                    echo("<a href='" . $cwd . $row['url'] . "'>Hosted locally</a>");
                } elseif ($row['host_code'] == 2) {
                    echo("<a href='http://a.pomf.se/" . $row['url'] . "'>Hosted on pomf.se</a>");
                } else {
                    echo("Hosted elsewhere: " . $row['url']);
                }
                ?>
            </td>
            <td>
                <?php
                echo "<div id='" . $id . "status'>";
                if ($row['video_status'] == 1) {
                    echo("Unmoderated <a href='#' onclick='approveVid($id, 2, null);return false;' class='button'>Approve</a><a  href='#' onclick='showRmvOpt($id);return false;' class='button'>Delete</a>");
                } elseif ($row['video_status'] == 2) {
                    echo("Approved <a href='#' onclick='approveVid($id, 1, null);return false;' class='button'>Unapprove</a><a  href='#' onclick='approveVid($id, 3, 1);return false;' class='button' id='warnBtn'>Delete</a>");
                } elseif ($row['video_status'] == 3) {
                    echo("Deleted. Reason: " . $row['removal_code']);
                } else {
                    echo("Error: video_status of " . $row['video_status'] . " is unacceptable");
                }
                ?>
                <form action="#" onsubmit="approveVid(<?php echo $id; ?>, 3, rmvCode.value);return false;" id='<?php echo $id . "statusDel"; ?>' style="display: none">
                    Select removal code:
                    <select id="rmvCode">
                        <option value="1">Copyright violation</option>
                        <option value="2">Adult content is currently prohibited</option>
                        <option value="3">Content is against the law where server is located</option>
                    </select>
                    <input type="submit" id="warnBtn" value="Confirm Delete" />
                </form>
                </div>
            </td>
        </tr>
    <?php endwhile;
    // Closing connection to database
    $dbh = null;
    ?>
</table>

</body>
</html>
