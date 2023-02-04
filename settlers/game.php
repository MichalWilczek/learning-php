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
    echo "<br /><b>Premium days</b>: " . $_SESSION["premiumdays"];

    ?>
</body>

</html>