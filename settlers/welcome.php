<?php
session_start();
if (!isset($_SESSION["successful_registration"])) {
    header("Location: index.php");
    exit();
} else {
    unset($_SESSION["successful_registration"]);
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
    Thank you for registration! You can log in to your account, now! <br /><br />
    <a href="index.php">Log in to your account!</a><br /><br />
</body>

</html>