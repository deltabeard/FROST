function approveVid(id, vidstatus, rmcode) {
    if (id == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(id + "status").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("POST", "dbchanges.php?id=" + id + "&vidstatus=" + vidstatus + "&rmcode=" + rmcode, true);
        xmlhttp.send();
    }
}

function showRmvOpt(id) {
    // Display drop-down list
    document.getElementById(id + "statusDel").style.display = 'block';
}
