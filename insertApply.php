<?php
/**
 * Created by IntelliJ IDEA.
 * User: magyl
 * Date: 22/11/2018
 * Time: 14:09
 */session_start();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <title>Job application confirmation</title>

</head>

<h2>Application confirmation</h2>
<?php
function upload()
{
    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        /***  get the image info. ***/

        $data = file_get_contents($_FILES['userfile']['tmp_name']);
        $type = $_FILES['userfile']['type'];
        $name = $_FILES['userfile']['name'];
        $maxsize = 99999999;


        if ($_FILES['userfile']['size'] < $maxsize) {
            $host = "devweb2018.cis.strath.ac.uK";
            $user = "cs312groupt";
            $pass = "soo7ZaiLaec8";
            $dbname = "cs312groupt";
            $conn = new mysqli($host, $user, $pass, $dbname);


            if ($conn->connect_error) {
                die("Connection failed : " . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO Applications (name,email,phone,CV,message,status,company,occupation,location) VALUES (?,?,?,?,?,?,?,?,?)");


            if (!$stmt->bind_param("sssbsssss", $name, $email, $phone, $data, $message, $status, $company, $occupation, $location)) {
                die("Failed to bind parameter");
            }//FIXME only show error during debugging*/

            if (!$stmt->send_long_data(3, $data)) {
                die("Failed to send long data");
            }//FIXME only show error during debugging
            $name = isset($_POST["name"]) ? $_POST["name"]: "";
            $email = isset($_POST["email"]) ? $_POST["email"]: "";
            $phone = isset($_POST["phone"]) ? $_POST["phone"]: "";
            $message = isset($_POST["message"]) ? $_POST["message"]: "";
            $status = "Application recieved";
            $company = isset($_SESSION['company']) ? $_SESSION['company']: "";
            $occupation = isset($_SESSION['occupation']) ? $_SESSION['occupation']: "";
            $location = isset($_SESSION['location']) ? $_SESSION['location']: "";

            if (!$stmt->execute()) {
                die("Failed to execute query " . $stmt->error);
            }//FIXME only show error during debugging
            //printf("%d Row inserted with ID %d.\n", $stmt->affected_rows, $conn->insert_id);
            $stmt->close();

        }
    }
}
if(!isset($_FILES['userfile'])) {
    echo '<p>Please select a file</p>';
} else {
    upload();
    ?>
    <p><?php echo "Hello ".$_POST["name"].", "?></p>
    <p><?php echo "We have recieved your application for the  ".$_SESSION['occupation']." position at ".$_SESSION['company']." in ".$_SESSION['location']."."?></p>
    <p><?php echo "You have also received a confirmation email.//TO DO//"?></p>
    <form action="joblistings.php" method="get">

        <button name="subject" type="submit" value="login">Back to home page</button>

    </form>
    <?php
}

?>

</body>
</html>