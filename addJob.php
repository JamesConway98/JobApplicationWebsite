<!DOCTYPE html>
<html>
<head>
    <title>Job adding in HTML and PHP - Add job</title>

</head>
<body>
<div class="">
    <h2>Compaines/Employees - Add job</h2>
</div>

<form method="post" action="addJob.php">


    <div class="">
        <label>Job Title</label>
        <input type="text" name="job_title" >
    </div>
    <div class="">
        <label>Company</label>
        <input type="text" name="company_name" >
    </div>
    <div class="">
        <label>Description</label>
        <input type="text" name="job_description" >
    </div>
    <div class="">
        <label>Deadline</label>
        <input type="date" name="deadline">
    </div>
    <div class="">
        <label>Location</label>
        <input type="text" name="location">
    </div>
    <div class="">
        <label>Occupation Id</label>
        <input type="number" name="occupationID">
    </div>
    <div class="">
        <label>Type Id</label>
        <input type="number" name="typeID">
    </div>
    <div class="">
        <button type="submit" name="add_job"> + Add Job to jobs lists</button>
    </div>
</form>
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

            if (empty($title)) {
                echo "<br>Error! Job title required";
            }
            if (empty($company)) {
                echo "<br>Error! Company name required";
            }
            if (empty($description)) {
                echo "<br>Error! Job description required";
            }
            if (empty($deadline)) {
                echo "<br>Error! Application deadline required";
            }
            if (empty($occupation_id)) {
                echo "<br>Error! Occupation id required";
            }
            if (empty($type_id)) {
                echo "<br>Error! Type id required";
            }
        }

    $db->close();



}
?>

<body>

</body>