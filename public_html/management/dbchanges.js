function approveVid(id, vidstatus, rmcode, host_code, file_location) {
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
        if (vidstatus == 3){
            document.getElementById(id + "_delete_form").style.display = 'none';
        }
        xmlhttp.open("POST", "dbchanges.php?id=" + id + "&vidstatus=" + vidstatus + "&rmcode=" + rmcode + "&host_code=" + host_code + "&file_location=" + file_location, true);
        xmlhttp.send();
    }
}

function showRmvOpt(id) {
    // Used by /libs/delete_button.php
    // Display drop-down list
    document.getElementById(id + "_delete_form").style.display = 'block';
    document.getElementById(id + "_delete_button").style.display = 'none';
}

function cancel_delete(id) {
    // Hide drop-down list, and display delete button
    document.getElementById(id + "_delete_form").style.display = 'none';
    document.getElementById(id + "_delete_button").style.display = 'inline';
}
