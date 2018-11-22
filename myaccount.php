<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jobs Site</title>
    <link rel = "stylesheet" type = "text/css" href = "mystyle.css"/>
</head>
<body>

<?php

session_start();

if(isset($_SESSION["sessionuser"]) && !(isset($_POST["logoutsubmit"]))){
    $email = $_SESSION["sessionuser"];
    $sessionuser = $_SESSION["sessionuser"];
    $loggedin = true;
}else{
    $sessionuser = "";
    unset($_SESSION['sessionuser']);
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
    <h1> <?php echo $username; ?>'s Account</h1>
</div>

<h2>Your Saved Jobs</h2>

<?php

$sql = "SELECT Job.ID, Job.Title FROM Job INNER JOIN SavedJobs ON Job.ID = SavedJobs.JobID WHERE SavedJobs.UserID = '$userID'";
$result = $conn->query($sql);

echo"<table> <tr> <th>Job Id</th> <th>Title</th> </tr>";

if($result->num_rows>0){
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["ID"] . "</td>";
        echo "<td>" . $row["Title"] . "</td></tr>";
    }
}
echo "</table>";
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

</body>


</html>