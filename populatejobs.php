<?php
require 'connectdb.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    for($i = 0; $i < 98; $i++) {
        $title = array("title_for_best_job", "jobA", "yes");
        $company = array("companyA", "Space Unlimited", "companyB", "C company");
        $description = array("We might or might not be hiring some new employees.", "This is a job listing.", "There is no real description needed.");
        $deadline = rand(2018, 2019) . "-" . rand(1, 12) . "-" . rand(1, 28);
        $location = array("Glasgow", "London", "Edinburgh", "Birmingham", "Manchester");
        $occupation_id = rand(1,3);
        $type_id = rand(1,3);
        $sql = 'INSERT INTO `Job` (`ID`, `Title`, `Company`, `Description`, `Deadline`, `Location`, `Occupation_ID`, `Type_ID`) VALUES (NULL, \''.$title[array_rand($title)].'\', \''.$company[array_rand($company)].'\', \''.$description[array_rand($description)].'\', \''.$deadline.'\', \''.$location[array_rand($location)].'\', \''.$occupation_id.'\', \''.$type_id.'\')';
        $jobs = $conn->query($sql);
    }
}
header("Location: joblistings.php");
die();