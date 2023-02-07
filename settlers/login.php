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
    session_start();
    if (!isset($_POST["login"]) || !isset($_POST["password"])) {
        header("Location: index.php");
        exit();
    }

    require_once "connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0) {
        echo "Error: " . $connection->connect_errno;
    } else {
        $login = $_POST["login"];
        $password = $_POST["password"];

        // Convert quotes to html entities to avoid SQL injection for getting the user passwords
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        if (
            // 'mysqli_real_escape_string' also prevents SQL injections
            $result = @$connection->query(
                sprintf(
                    "SELECT * FROM users WHERE user='%s'",
                    mysqli_real_escape_string($connection, $login)
                )
            )
        ) {
            $users_amount = $result->num_rows;
            if ($users_amount > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row["pass"]) == true) {
                    $_SESSION["logged_in"] = true;
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["user"] = $row["user"];
                    $_SESSION["wood"] = $row["wood"];
                    $_SESSION["stone"] = $row["stone"];
                    $_SESSION["wheat"] = $row["wheat"];
                    $_SESSION["email"] = $row["email"];
                    $_SESSION["premiumdays"] = $row["premiumdays"];
                    $password = $row["pass"];
                    header("Location: game.php");
                    $result->free_result();
                } else {
                    unset($_SESSION["error"]);
                    $_SESSION["error"] = "<span style='color:red;'>Incorrect login or password</span>";
                    header("Location: index.php");
                }
            } else {
                unset($_SESSION["error"]);
                $_SESSION["error"] = "<span style='color:red;'>Incorrect login or password</span>";
                header("Location: index.php");
            }
        }
        $connection->close();
    }
    ?>
</body>

</html>