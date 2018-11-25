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
    <input type="checkbox" id="expired" onclick="loadDoc('')" checked> don't show expired listings<br>
    Occupation:
    <select id="occ" onchange="loadDoc('')">
        <option value="">Select</option>
        <?php
        require 'connectdb.php';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "SELECT * FROM Occupation ORDER BY Occupation ASC";
            $occ = $conn->query($sql);
            if (isset($occ->num_rows) && $occ->num_rows > 0)
                while ($row = $occ->fetch_assoc())
                    echo '<option value="' . $row["Occupation"] . '">' . $row["Occupation"] . '</option>';
        }
        ?>
    </select>
    Location:
    <select id="loc" onchange="loadDoc('')">
        <option value="">Select</option>
        <?php
        require 'connectdb.php';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "SELECT DISTINCT Location FROM Job ORDER BY Location ASC";
            $loc = $conn->query($sql);
            if (isset($loc->num_rows) && $loc->num_rows > 0)
                while ($row = $loc->fetch_assoc())
                    echo '<option value="' . $row["Location"] . '">' . $row["Location"] . '</option>';
        }
        ?>
    </select>
    Company:
    <select id="comp" onchange="loadDoc('')">
        <option value="">Select</option>
        <?php
        require 'connectdb.php';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "SELECT DISTINCT Company FROM Job ORDER BY Company ASC";
            $comp = $conn->query($sql);
            if (isset($comp->num_rows) && $comp->num_rows > 0)
                while ($row = $comp->fetch_assoc())
                    echo '<option value="' . $row["Company"] . '">' . $row["Company"] . '</option>';
        }
        ?>
    </select>
    Type:
    <select id="type" onchange="loadDoc('')">
        <option value="">Select</option>
        <?php
        require 'connectdb.php';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "SELECT * FROM `Type` ORDER BY `Type`.`Type` ASC";
            $type = $conn->query($sql);
            if (isset($type->num_rows) && $type->num_rows > 0)
                while ($row = $type->fetch_assoc())
                    echo '<option value="' . $row["Type"] . '">' . $row["Type"] . '</option>';
        }
        ?>
    </select>
    <div id="table">
        <?php
        require 'jobtable.php';
        ?>
    </div>
</div>

<script>
    function loadDoc(page) {
        var xhttp;
        var args = "";
        var input = document.getElementById("searchBox").value.trim();
        var exp = document.getElementById("expired").checked.toString();
        var occ = document.getElementById("occ").value;
        var loc = document.getElementById("loc").value;
        var comp = document.getElementById("comp").value;
        var type = document.getElementById("type").value;

        if (window.XMLHttpRequest) {
            // code for modern browsers
            xhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("jobTable").innerHTML = this.responseText;
            }
        };
        if (input.length !== 0)
            args += "&search=" + input;
        if (page.length !== 0)
            args += "&page=" + page;
        if (occ.length !== 0)
            args += "&occ=" + occ;
        if (loc.length !== 0)
            args += "&loc=" + loc;
        if (comp.length !== 0)
            args += "&comp=" + comp;
        if (type.length !== 0)
            args += "&type=" + type;

        xhttp.open("GET", "jobtable.php?exp=" + exp + args, true);
        xhttp.send();
    }

    function unloadDetails() {
        var table = document.getElementById("jobTable");
        var row = document.getElementById("newRow");
        if (row !== null)
            table.deleteRow(row.rowIndex);
    }

    function loadDetails(id) {
        var a = document.getElementById(id);
        var b = document.getElementById("newRow");
        if (b == null || a.rowIndex !== b.rowIndex - 1) {
            unloadDetails();
            var row = document.getElementById(id).rowIndex;
            var table = document.getElementById("jobTable");
            var newRow = table.insertRow(row + 1);
            newRow.id = "newRow";
            var cell = newRow.insertCell(0);
            cell.id = "miniDetails";
            cell.setAttribute("colspan", table.rows[0].cells.length);
            var xhttp;
            if (window.XMLHttpRequest) {
                // code for modern browsers
                xhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("miniDetails").innerHTML = this.responseText;
                }
            };

            xhttp.open("GET", "miniDetails.php?more=" + id, true);
            xhttp.send();
        } else
            unloadDetails();
    }
</script>

</body>
</html>