<?php
session_start();

require 'connectdb.php';

$saved = false;

if(isset($_POST["save"])){
    if(!isset($_SESSION["sessionuserid"])){
        header("Location: login.php");
        die();
    }
    $saved = true;
    $userid = $_SESSION['sessionuserid'];
    $jobid = $_SESSION["key"];
    $sql = "INSERT INTO `SavedJobs` (`UserID`, `JobID`, `SavedJobID`) VALUES ('$userid', '$jobid', NULL)";
    $result =  $conn->query($sql);
}

if ((!isset($_GET["more"]) || $conn->connect_error) && !isset($_POST["savejob"])) {
    header("Location: joblistings.php");
    die();
}

$_SESSION['key'] = $_GET["more"];
$_SESSION['details'] = "";

$sql = 'SELECT * FROM `Job` LEFT OUTER JOIN Occupation occ ON Job.Occupation_ID = occ.ID LEFT OUTER JOIN `Type` typ ON `Job`.`Type_ID` = `typ`.`ID` WHERE ' . $_GET["more"] . '=`Job`.`ID`';
$job = $conn->query($sql);
if (isset($job->num_rows) && $job->num_rows > 0) {
    $job = $job->fetch_assoc();
} else {
    $job = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="mystyle.css">
<head>
    <meta charset="UTF-8">
    <title><?php if (isset($job)) {
            echo $job["Title"];
        } else {
            echo "Job not found";
        } ?></title>
</head>
<header>
    <img src="Files/Logo.png" alt="Logo"  width = '200px' height = '200px'>
    <?php
    require 'navbar.php';
    ?>
</header>
<body>
<?php
if (isset($job)) {
    $disabled = "";
    if (strtotime($job["Deadline"]) - strtotime(date("Ymd")) < 0) {
        $disabled = "disabled";
    }

    echo '<div class="col">';
    echo "<h2>" . $job["Title"] . "</h2>";
    echo $job["Description"];
    if(isset($_SESSION["sessionuser"])){

        echo '<form action="apply.php" method="get">';
    }
    else{

        echo '<form action="login.php" method="get">';
        $_SESSION['details'] = $_SERVER['REQUEST_URI'];
    }
        echo '<table>'
        . '<tr><td>Company:</td><td>' . $job["Company"] . '</td></tr>'
        . '<tr><td>Location:</td><td>' . $job["Location"] . '</td></tr>'
        . '<tr><td>Deadline:</td><td>' . $job["Deadline"] . '</td></tr>'
        . '<tr><td>Occupation:</td><td>' . $job["Occupation"] . '</td></tr>'
        . '<tr><td>Type:</td><td>' . $job["Type"] . '</td></tr>'
        . '<tr><td colspan="2">'
        . '<button name="apply" type="submit" align="center" value="' . $_GET["more"] . '" ' . $disabled . '>Apply</button>'
        . '</form>';

        if(!$saved) {
            echo '<form name = "savejob" method="post">'
            . '<button name="save" type="submit" align="center" value="' . $_GET["more"] . '" ' . $disabled . '>Save Job</button>';
        }

        echo '</td></tr>'
        . '</table>'
        . '</form>';
    echo '</div>';

} else {
    echo "<p>404 - Job not found.</p>";
}
?>
</body>
</html>