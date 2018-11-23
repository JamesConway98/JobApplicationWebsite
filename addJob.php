<!DOCTYPE html>
<html>
<head>
    <link rel = "stylesheet" type = "text/css" href = "mystyle.css"/>
    <title>Job adding in HTML and PHP - Add job</title>
</head>
<header>
    <h1>Jobs</h1>
    <?php
    require 'navbar.php';
    ?>
</header>
<body>
<div class="col">
    <h2>Add a Job</h2>
<form method="post" action="addJob.php">

<div class="input-group">
        <label>Job Title</label>
        <input type="text" name="job_title"><br>


        <label>Company</label>
        <input type="text" name="company_name"><br>


        <label>Description</label>
        <input type="text" name="job_description"><br>


        <label>Deadline</label>
        <input type="date" name="deadline"><br>


        <label>Location</label>
        <input type="text" name="location"><br>


        <label>Occupation Id</label>
        <input type="number" name="occupationID"><br>


        <label>Type Id</label>
        <input type="number" name="typeID"><br>
    </div>

        <button class="btn" type="submit" name="add_job"> + Add Job </button>
        <a href="">Job Lists</a>
        <a href="login.php">Sign Out</a>


</form>
</div>
</body>
</html>


<?php


// call the register() function if register_btn is clicked
if (isset($_POST['add_job'])) {
    addJob();


}

// REGISTER USER
/**
 *
 */
function addJob(){

// connect to database
    $host = "devweb2018.cis.strath.ac.uk" ;
    $user_sql = "cs312groupt" ;
    $password_sql = "soo7ZaiLaec8" ;
    $db_mysql = "cs312groupt" ;
    $db = new mysqli($host, $user_sql, $password_sql, $db_mysql);


    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

            $title = ($_POST['job_title']);
            $company = ($_POST['company_name']);
            $description = ($_POST['job_description']);
            $deadline = ($_POST['deadline']);
            $location = ($_POST['location']);
            $occupation_id = ($_POST['occupationID']);
            $type_id = ($_POST['typeID']);

        $sql = "INSERT INTO Job (Title, Company, Description, Deadline, Location, Occupation_ID, Type_ID)
					  VALUES ('$title', '$company', '$description', '$deadline','$location','$occupation_id','$type_id')";

        if($db->query($sql) === TRUE){
            echo "New job created successfully";
        }else {

            echo "<small>";
            if (empty($title)) {
                echo "<br><div class='error'>Error! Job title required</div>";
            }
            if (empty($company)) {
                echo "<br><div class='error'>Error! Company name required</div>";
            }
            if (empty($description)) {
                echo "<br><div class='error'>Error! Job description required</div>";
            }
            if (empty($deadline)) {
                echo "<br><div class='error'>Error! Application deadline required</div>";
            }
            if (empty($occupation_id)) {
                echo "<br><div class='error'>Error! Occupation id required</div>";
            }
            if (empty($type_id)) {
                echo "<br><div class='error'>Error! Type id required</div>";
            }
            echo "</small>";
        }

    $db->close();

}
?>
