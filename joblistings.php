<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="mystyle.css">
<head>
    <meta charset="UTF-8">
    <title>Job Listings</title>
</head>
<header>
    <h1>Jobs</h1>
    <?php
    require 'navbar.php'
    ?>
</header>
<body>
<div class="col">
    <input type="text" id="searchBox" onkeyup="loadDoc()" placeholder="Search for job.." title="Type in a job">
    <div id="table">
<?php
require 'jobtable.php';
?>
    </div>
</div>

<script>
    function loadDoc() {
        var xhttp;
        var input = document.getElementById("searchBox").value.trim();
        if (window.XMLHttpRequest) {
            // code for modern browsers
            xhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        if(input.length !== 0)
            xhttp.open("GET", "jobtable.php?search=" + input, true);
        else
            xhttp.open("GET", "jobtable.php", true);
        xhttp.send();
    }
</script>

</body>
</html>