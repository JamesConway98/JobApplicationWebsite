<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name + "viewport" content = "width=device-width, initial-scale = 1.0">
    <title>PHP Samples</title>
    <script>
        function checkform(){

            var name = document.forms["create"]["name"];
            var email = document.forms["create"]["email"];
            var password = document.forms["create"]["password"];
            var errs = "";

            if(name.value == null || name.value == "") {
                errs += "Name must not be empty\n";
                name.style.background = "#ff0000";
            }

            if(email.value == null || email.value == "") {
                errs += "Email must not be empty\n";
                email.style.background = "#ff0000";
            }

            if(password.value == null || password.value == "") {
                errs += "Password must not be empty\n";
                password.style.background = "#ff0000";
            }

            if(errs != ""){
                alert("Sorry the following need corrected:\n"+ errs)
            }

            return (errs == "");
        }

    </script>
</head>
<body>

<?php

function safePost($name){
    if(isset($_POST[$name])){
        return strip_tags($_POST[$name]);
    }else{
        return "";
    }
}

$email = safePost("email");
$name = safePost("name");
$password = safePost("password");


$submitbutton= safePost("createaccount");
if(!$submitbutton){
    $createOK = false;
}else{
    $createOK = true;
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

$sql = "SELECT * FROM `User`";
$result = $conn->query($sql);

$duplicateEmail = false;

if($result->num_rows>0) {

//reset password
    while ($row = $result->fetch_assoc()) {
        if ($row["Email"] == $email) {
            $duplicateEmail = true;
        }
    }
}

if($submitbutton && $duplicateEmail){
    echo "<p>This email already has an account</p> <p>Log in to continue</p>";
}else {
    $sql = "INSERT INTO `User` (`Username`, `Password`, `Email`, `ResetCode`) VALUES ('$name', '$password', '$email', '0')";
    $result = $conn->query($sql);
    echo "<p>You have created an account, please login to continue</p>";
}

if(!$createOK) {
    ?>

    <div>
        <form name="create" method="post" onsubmit="return checkform();">
            <p>Please enter details to continue</p>
            <p>Name:<input type="text" name="name"/></p>
            <p>Email:<input type="text" name="email"/></p>
            <p>Password: <input type="password" name="password"/></p>
            <input type="submit" name="createaccount" value="Create Account"/>
        </form>
    </div>

    <?php
}
else {
    ?>

    <form action ="login.php" method ="post">
        <input type = "submit" value = "Back to Login"/>
    </form>

    <?php
}
?>
</body>
</html>