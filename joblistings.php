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
    <input type="text" id="searchBox" onkeyup="loadDoc('')" placeholder="Search for job.." title="Type in a job">
    <input type="checkbox" id="expired" value="exp" checked> don't show expired listings<br>
    <div id="table">
        <?php
        require 'jobtable.php';
        ?>
    </div>
</div>

<script>
    function loadDoc(page) {
        var xhttp;
        var input = document.getElementById("searchBox").value.trim();
        if (window.XMLHttpRequest) {
            // code for modern browsers
            xhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("table").innerHTML = this.responseText;
            }
        };
        var exp = document.getElementById("expired").checked.toString();
        if (input.length !== 0)
            input = "&search=" + input;
        if (page.length !== 0)
            page = "&page=" + page;
        xhttp.open("GET", "jobtable.php?exp=" + exp + input + page, true);
        xhttp.send();
    }
</script>

</body>
</html>