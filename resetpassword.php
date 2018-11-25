<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jobs Site</title>
    <link rel = "stylesheet" type = "text/css" href = "mystyle.css"/>
</head>

<?php

session_start();

function safePost($name){
    if(isset($_POST[$name])){
        return strip_tags($_POST[$name]);
    }else{
        return "";
    }
}

$email = safePost("user");

//Connect to SQL
$host = "devweb2018.cis.strath.ac.uk";
$user = "cs312groupt";
$pass = "soo7ZaiLaec8";
$dbname = "cs312groupt";
$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error){
    die("Connection failed : " .$conn->connect_error);//FIXME Remove when finished
}

//checks what page we are on
$resetbutton= safePost("reset");
$testbutton = safePost("testcode");

//Issue the Query
$sql = "SELECT * FROM `User`";
$result = $conn->query($sql);

if(!$testbutton && !$resetbutton) {
    $resetOK = false;
}else{
    $resetOK = true;
}

$randomCode = rand(10000, 99999);

if($result->num_rows>0 && $resetOK){

    while ($row = $result->fetch_assoc()) {

        if($row["Email"] == $email){
            $sql = "UPDATE `User` SET `ResetCode` = '$randomCode' WHERE `User`.`Email` = '$email'";
            mail($email, "Job Site Password Reset", "Your code to reset your password is " . $randomCode);
            $result = $conn->query($sql);
            $resetOK = true;
            $_SESSION["emailreset"] = $email;
            break;
        }
    }
}

if($resetOK){

    $email = $_SESSION["emailreset"];
    $code = safePost("code");
    $password1 = safePost("password1");
    $password2 = safePost("password2");

    $sql = "SELECT * FROM `User` WHERE `Email` = '$email'";
    $result = $conn->query($sql);

    if($result->num_rows>0){

        //reset password
        while ($row = $result->fetch_assoc()) {
            if($row["Email"] == $email){
                if($row["ResetCode"] == $code && $code !=0){
                    if($password1 == $password2){
                        echo "<h1>Your Password Has Been Updated</h1>";
                        $sql = "UPDATE `User` SET `ResetCode` = '0' WHERE `User`.`Email` = '$email'";
                        $result = $conn->query($sql);
                        $sql = "UPDATE `User` SET `Password` = '$password1' WHERE `User`.`Email` = '$email'";
                        $result = $conn->query($sql);
                        $resetOK = false;
                        break;
                    }
                }
            }
        }
    }


}

?>
<header>
    <img src="Files/Logo.png" alt="Logo"  width = '200px' height = '200px'>
    <?php
    require 'navbar.php';
    ?>
</header>
<body>
<div class="col">
<h2>Reset Password</h2>

<?php
if($resetOK){
    ?>

    <div>
        <p>A code has been sent to <?php echo $email?></p>
        <form name="resetform" method = "post">
            <p>Reset Code:<input type="text" name="code"/>
            <p>New Password:<input type="text" name="password1"/>
            <p>Retype Password:<input type="text" name="password2"/>
                <input type = "submit" name="testcode" value = "Reset"/></p>
        </form>
    </div>

    <div>
        <form action = "login.php" name =  "login">
            <input type = "submit" value ="Back to Login"/>
        </form>
    </div>

    <?php
}else{
    ?>

    <p>Please Enter a Valid Email to reset password</p>

    <div>
        <form name="login" method = "post">
            <p>Email:<input type="text" name="user"/>
                <input type = "submit" name="reset" value = "Reset Password"/></p>
        </form>
    </div>

    <div>
        <form action = "login.php" name =  "login">
            <input type = "submit" value ="Back to Login"/>
        </form>
    </div>

    <?php
}
?>
</div>
</body>
</html>