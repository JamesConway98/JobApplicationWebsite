<?php
require 'connectdb.php';
if (!isset($_GET["more"]) || $conn->connect_error) {
    die();
}
$sql = 'SELECT * FROM `Job` LEFT OUTER JOIN Occupation occ ON Job.Occupation_ID = occ.ID LEFT OUTER JOIN `Type` typ ON `Job`.`Type_ID` = `typ`.`ID` WHERE ' . $_GET["more"] . '=`Job`.`ID`';
$job = $conn->query($sql);
if (isset($job->num_rows) && $job->num_rows > 0) {
    $job = $job->fetch_assoc();
} else {
    $job = null;
}
?>
<?php
if (isset($job)) {
    echo '<div class="col">';
    echo "<h2>" . $job["Title"] . "</h2>";
    echo $job["Description"];
    echo '<form action="apply.php" method="get">'
        . '<table>'
        . '<tr><td>Company:</td><td>' . $job["Company"] . '</td></tr>'
        . '<tr><td>Location:</td><td>' . $job["Location"] . '</td></tr>'
        . '<tr><td>Deadline:</td><td>' . $job["Deadline"] . '</td></tr>'
        . '<tr><td>Occupation:</td><td>' . $job["Occupation"] . '</td></tr>'
        . '<tr><td>Type:</td><td>' . $job["Type"] . '</td></tr>'
        . '<tr><td colspan="2">'
        . '<button name="apply" type="submit" align="center" value="' . $_GET["more"] . '">Apply</button>'
        . '</td></tr>'
        . '</table>'
        . '</form>';
    echo '</div>';
} else {
    echo "<p>404 - Job not found.</p>";
}
?>