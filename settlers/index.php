<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    header("Location: game.php");
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

    Only the dead have seen the end of war - Platon <br /><br />
    <form action="login.php" method="post">
        Login: <br><input type="text" name="login" /><br />
        Password: <br><input type="password" name="password" /><br /><br />
        <input type="submit" value="login" />
    </form>

    <?php
    if (isset($_SESSION["error"])) {
        echo $_SESSION["error"];
    }
    ?>

</body>

</html>