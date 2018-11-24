<?php
require 'connectdb.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    if (isset($_GET["page"]) && !($_GET["page"] < 1)) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $page_size = 15;
    $start_from = ($page - 1) * $page_size;

    $condition = "";
    if (!isset($_GET["exp"]) || $_GET["exp"] === "true")
        $condition = " WHERE Job.Deadline >= " . date("Ymd");
    if (isset($_GET["search"]))
        if(strlen($condition) > 0)
            $condition .= " AND Job.Title LIKE \"%" . $_GET["search"] . "%\"";
        else
            $condition = " WHERE Job.Title LIKE \"%" . $_GET["search"] . "%\"";

    $sql = 'SELECT Job.ID, Job.Title, Job.Company, Job.Deadline, Job.Location, `occ`.`Occupation`, `typ`.`Type` FROM `Job` LEFT OUTER JOIN Occupation occ ON Job.Occupation_ID = occ.ID LEFT OUTER JOIN `Type` typ ON `Job`.`Type_ID` = `typ`.`ID` ' . $condition . ' ORDER BY Deadline ASC, Title ASC, Job.ID ASC LIMIT ' . $start_from . ', ' . $page_size;
    $jobs = $conn->query($sql);
    if (isset($jobs->num_rows) && $jobs->num_rows > 0) {
        echo '<table id="table">';
        echo "<tr><th>Title</th><th>Company</th><th>Deadline</th><th>Location</th><th>Occupation</th><th>Type</th><th></th></tr>";
        while ($row = $jobs->fetch_assoc()) {
            echo "<tr><td>" . $row["Title"] . "</td><td>" . $row["Company"] . "</td><td>" . $row["Deadline"] . "</td><td>" . $row["Location"] . "</td><td>" . $row["Occupation"] . "</td><td>" . $row["Type"] . "</td><td><form action='details.php' method='get'><button name='more' type='submit' value='" . $row["ID"] . "'>+</button> </form></td></tr>";
        }
        echo "</table>";
        echo "<div>";
        if ($page - 1 > 0) {
            echo "<button type='button' onclick='loadDoc(" . ($page - 1) . ")'><</button>  ";
        }
        $sql = "SELECT COUNT(ID) as `count` FROM `Job` " . $condition;
        $num_rows = $conn->query($sql)->fetch_assoc()["count"];
        if ($page + 1 <= ceil($num_rows / $page_size)) {
            echo "<button type='button' onclick='loadDoc(" . ($page + 1) . ")'>></button>";
        }
        echo "</div>";
    } else {
        echo '<p>No job listings available.</p>';
    }
}