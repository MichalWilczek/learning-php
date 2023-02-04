<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
require_once "connect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: ".$connection->connect_errno;
} else {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $query_string = "SELECT * FROM uzytkownicy WHERE user='$login' AND pass='$password'";

    if ($result = @$connection->query($query_string)) {
        $users_amount = $result->num_rows;
        if ($users_amount > 0) {
            $row = $result->fetch_assoc();
            $user = $row["user"];
            $password = $row["pass"];
            echo $password;
            // header("Location: game.php");
            $result->free_result();
        } else {

        }
    } else {

    }

    $connection->close();    
}
?>


</body>
</html>