<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jobs Site</title>
    <link rel = "stylesheet" type = "text/css" href = "mystyle.css"/>
</head>
<header>
    <img src="Files/Logo.png" alt="Logo"  width = '200px' height = '200px'>
    <?php
    require 'navbar.php';
    ?>
</header>
<body>
<div class="col">
<?php

session_start();

if(isset($_SESSION["sessionuser"]) && !(isset($_POST["logoutsubmit"]))){
    $email = $_SESSION["sessionuser"];
    $sessionuser = $_SESSION["sessionuser"];
    $loggedin = true;
}else{
    $sessionuser = "";
    unset($_SESSION['sessionuser']);
    unset($_SESSION['sessionuserid']);
    $loggedin = false;
    header("Location: login.php");
}

//Connect to SQL
$host = "devweb2018.cis.strath.ac.uk";
$user = "cs312groupt";
$pass = "soo7ZaiLaec8";
$dbname = "cs312groupt";
$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error){
    die("Connection failed : " .$conn->connect_error);//FIXME Remove when finished
}

//Issue the Query
$sql = "SELECT * FROM `User` WHERE `Email` = '$email'";
$result = $conn->query($sql);

if($result->num_rows>0){

    while ($row = $result->fetch_assoc()) {
        $username = $row["Username"];
        $userID = $row["ID"];
    }
}

?>

<div>
    <h2> <?php echo $username; ?>'s Account</h2>
</div>

<h3>Your Saved Jobs</h3>

<?php

$sql = "SELECT Job.ID, Job.Company, Job.Title, Job.Location, Job.Deadline FROM Job INNER JOIN SavedJobs ON Job.ID = SavedJobs.JobID WHERE SavedJobs.UserID = '$userID'";
$result = $conn->query($sql);

echo"<form action = 'details.php' name=\"more\" method=\"get\">";
echo "<table cellspacing=\"15\"> <tr> <th>Company</th> <th>Title</th> <th>Location</th> <th>Deadline</th> <th>Apply</th></tr>";

if($result->num_rows>0){
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Company"] . "</td>";
        echo "<td>" . $row["Title"] . "</td>";
        echo "<td>" . $row["Location"] . "</td>";
        echo "<td>" . $row["Deadline"] . "</td>";
        echo "<td><button name='more' value='" . $row['ID'] . "' type='submit'>+</button></td></tr>";
    }
}
echo "</table></form>";
?>

<div>
    <form name="logout" method="post">
        <input type="submit" name="logoutsubmit" value="Logout"/>
    </form>
</div>

<div>
    <form action = "joblistings.php" name="alljobs" method="post">
        <input type="submit" name="alljob" value="All Jobs"/>
    </form>
</div>
</div>
</body>
</html>