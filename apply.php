<?php
/**
 * Created by IntelliJ IDEA.
 * User: magyl
 * Date: 22/11/2018
 * Time: 14:08
 */session_start();
$_SESSION['occupation'] = "";
$_SESSION['company'] = "";
$_SESSION['location'] = "";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">

    <script>
        function validateEmail(text) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(text).toLowerCase());
        }

        function validateForm() {
            var name = document.forms["myform"]["name"].value;
            var phone = document.forms["myform"]["phone"].value;
            var email = document.forms["myform"]["email"].value;
            var errs = "";

            if((name == "" || name == null)){
                errs += "   * Name must not be empty\n";

            }

            if ( (phone==null) || (phone =="")) {
                errs += "   * Phone number must not be empty\n";

            }

            if (isNaN(phone)){
                errs += "   * Phone number must be a number\n";
            }
            if(phone.length !=11){
                errs += "   * Phone number must contain 11 numbers\n";

            }
            if(!validateEmail(email)){
                errs += "   * Email must be valid format\n";
            }


            if (errs!=""){
                alert("Sorry the following need corrected:\n"+errs);
            }



            return (errs=="");
        }
    </script>
    <?php
    $host = "devweb2018.cis.strath.ac.uk";
    $user = "cs312groupt";
    $pass = "soo7ZaiLaec8";
    $dbname = "cs312groupt";
    $conn = new mysqli($host, $user, $pass, $dbname);
    if(!isset($_GET["apply"]) || $conn->connect_error){
        header("Location: joblistings.php");
        die();
    }
    $sql = 'SELECT * FROM `Job` LEFT OUTER JOIN Occupation occ ON Job.Occupation_ID = occ.ID LEFT OUTER JOIN `Type` typ ON `Job`.`Type_ID` = `typ`.`ID` WHERE ' . $_GET["apply"] . '=`Job`.`ID`';
    $job = $conn->query($sql);
    if(isset($job->num_rows) && $job->num_rows > 0){
        $job = $job->fetch_assoc();
        $_SESSION['occupation'] = $job["Occupation"];
        $_SESSION['company'] = $job["Company"];
        $_SESSION['location'] = $job["Location"];
    }else{
        $job = null;
    }
    ?>

    <title><?php if(isset($job))
        {
            echo "Applying for ".$job["Title"];
        }
        else
        {
            echo "Job not found";
        }
        ?>
    </title>
</head>
<header>
    <img src="Files/Logo.png" alt="Logo"  width = '200px' height = '200px'>
    <?php
    require 'navbar.php';
    ?>
</header>
<body>
<div class ="col">
<h2>Apply for a job</h2>

<div>
    <form action="insertApply.php" onsubmit="return validateForm()" method="post" name="myform" enctype="multipart/form-data">

    <div id = jobInfo>
        <p><?php echo $job["Occupation"];?></p>
        <p><?php echo $job["Company"];?></p>
        <p><?php echo $job["Location"];?></p>
    </div>
        <div id = extraSpace>
        <p>
            Name: <input type="text" name="name"/><br/>
            Email: <input type="text" name="email"/><br/>
            Phone number: <input type="text" name="phone"/><br/>
            CV: <input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
            <input name="userfile" type="file"/>
            <br>
            Cover letter (optional):
            <br>
            <textarea name="message" rows="10" cols="30"></textarea>
            <br>
            <button name = "confirm" type="submit" value=<?php $_GET["apply"]?>>Continue</button>
            <button type="button" onclick="history.back();">Back</button>
        </p>
        </div>

    </form>
</div>
</div>
</body>
</html>