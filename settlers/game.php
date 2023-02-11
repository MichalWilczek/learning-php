<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] == false) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settlers - Web Game</title>
</head>

<body>
    <?php
    echo "<p>welcome, " . $_SESSION["user"] . "! [<a href='logout.php'>Log out</a>]</p>";

    echo "<p><b>Wood</b>: " . $_SESSION["wood"];
    echo "<b> | Stone</b>: " . $_SESSION["stone"];
    echo "<b> | Wheat</b>: " . $_SESSION["wheat"] . "</p>";

    echo "<p><b>E-mail</b>: " . $_SESSION["email"];
    echo "<br /><b>Date for losing premium account </b>: " . $_SESSION["premiumdays"]. "<br /><br />";

    $current_date = new DateTime("2021-05-01 14:59:12"); // UTC time ;-)
    $user_premium_days_left = DateTime::createFromFormat("Y-m-d H:i:s", $_SESSION["premiumdays"]);
    $time_diff = $current_date->diff($user_premium_days_left);

    if ($current_date < $user_premium_days_left) {
        echo "Premium time left: " . $time_diff->format("%y year(s), %d day(s), %h hour(s), %i minute(s), %s second(s)");
    } else {
        echo "Premium deactivated.";
    }

    // Some notes for date handling in PHP...
    // echo time() . "<br />";
    // echo date("Y-m-d H:i:s"). "<br />";  // local time
    // echo gmdate("Y-m-d H:i:s"). "<br />";  // utc time!!!
    // $time_object = new DateTime();
    // echo $time_object->format("Y-m-d H:i:s"); // local time
    // $day = 26;
    // $month = 7;
    // $year = 1875;
    // if (checkdate($month, $day, $year)) {
    //     echo "<br />Correct date!";
    // } else {
    //     echo "<br />Inorrect date!";
    // }
 
    ?>
</body>

</html>