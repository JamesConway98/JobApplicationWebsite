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
        return "Default";
    }
}

$username = "";

if(isset($_SESSION["sessionuser"])){
    $email = $_SESSION["sessionuser"];
    $sessionuser = $_SESSION["sessionuser"];
    $password = "";
}else{
    $sessionuser = "";
    $email = safePost("user");
    $password = safePost("pass");
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
$sql = "SELECT * FROM `User`";
$result = $conn->query($sql);

$loginOK = false;

if($result->num_rows>0){

    while ($row = $result->fetch_assoc()) {

        if($row["Email"] == $email){
            if($row["Password"] == $password){
                $loginOK = true;
                $username = $row["Username"];
            }
            if($sessionuser == $row["Email"]){
                $loginOK = true;
                $username = $row["Username"];
            }
        }
    }
}

if($loginOK){
    $_SESSION["sessionuser"] = $email;
}

?>
<header>
    <h1>Jobs</h1>
    <?php
    require 'navbar.php';
    ?>
</header>
<body>
<div class="col">
<?php
if($loginOK){
    ?>

    <div>
        <h1>Logged in</h1>
        <p>Welcome Back <?php echo $username  ?></p>
        <p><a href = "myaccount.php">Go to My Account</a></p>
        <p><a href = "joblistings.php">Go to All Jobs</a></p>
    </div>

    <?php
}else{
    ?>

    <div>
        <form name="login" method = "post">
            <p>Please login to continue</p>
            <p>Email:<input type="text" name="user"/>
                Password: <input type="password" name="pass"/>
                <input type = "submit" name="login" value = "Login"/></p>
        </form>
    </div>

    <div>
        <form action = "joblistings.php" name =  "login">
            <input type = "submit" value ="Continue Without Logging in"/>
        </form>
    </div>

    <div>
        <form action = "resetpassword.php" name =  "reset">
            <input type = "submit" value ="Reset Password"/>
        </form>
    </div>

    <div>
        <form action = "createaccount.php" name =  "create">
            <input type = "submit" value ="Create Account"/>
        </form>
    </div>

    <?php
}
?>
</div>
</body>

</html>

