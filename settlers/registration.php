<?php
session_start();

if (isset($_POST["email"])) {
    $validated = true;

    // Checks for 'nick'
    $nick = $_POST["nick"];
    if (strlen($nick) < 3 || strlen($nick) > 20) {
        $validated = false;
        $_SESSION["error_nick"] = "Your nick must contain 3-20 signs.";
    }
    if (ctype_alnum($nick) == false) {
        $validated = false;
        $_SESSION["error_nick"] = "Your nick must only contain alphanumeric elements (in English).";
    }

    // Checks for 'email'
    $email = $_POST["email"];
    $sanitised_email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($sanitised_email, FILTER_VALIDATE_EMAIL) == false || $email != $sanitised_email) {
        $validated = false;
        $_SESSION["error_email"] = "Your email must only contain acceptable letters.";
    }

    // Checks for password
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    if (strlen($password1) < 8 || strlen($password1) > 20) {
        $validated = false;
        $_SESSION["error_password"] = "Password must contain 8-20 signs.";
    }
    if ($password1 != $password2) {
        $validated = false;
        $_SESSION["error_password"] = "The given passwords are not identical.";
    }
    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

    // Acceptance of terms and conditions
    if (!isset($_POST["terms_conditions"])) {
        $validated = false;
        $_SESSION["error_terms_conditions"] = "Accept terms and conditions first.";
    }

    // Bot or not
    $secret = "6LfJyl8kAAAAAPnOPOoOhZnpJAMT0oNEhOrNQUMu";
    $captcha_check = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $_POST["g-recaptcha-response"]);
    $answer = json_decode($captcha_check);
    if ($answer->success == false) {
        $validated = false;
        $_SESSION["error_bot"] = "Confirm you are not a bot.";
    }

    // Remember typed in registration elements.
    $_SESSION["reg_form_nick"] = $nick;
    $_SESSION["reg_form_email"] = $email;
    $_SESSION["reg_form_password1"] = $password1;
    $_SESSION["reg_form_password2"] = $password2;
    if (isset($_POST["terms_conditions"])) {
        $_SESSION["reg_form_terms_conditions"] = true;
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $connection = new mysqli($host, $db_user, "", $db_name);
        if ($connection->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            // Does email already exist?
            $query_result = $connection->query("SELECT id FROM users WHErE email='$email'");
            if (!$query_result) {
                throw new Exception($connection->error);
            }
            $mail_number = $query_result->num_rows;
            if ($mail_number > 0) {
                $validated = false;
                $_SESSION["error_email"] = "E-mail assigned to another account.";
            }

            // Does nick already exist?
            $query_result = $connection->query("SELECT id FROM users WHErE user='$nick'");
            if (!$query_result) {
                throw new Exception($connection->error);
            }
            $nick_number = $query_result->num_rows;
            if ($nick_number > 0) {
                $validated = false;
                $_SESSION["error_nick"] = "There is already a player with the proposed nick.";
            }

            // All tests passed. The user can be added to the database.
            if ($validated == true) {

                if (
                    $connection->query(
                        "INSERT INTO users VALUES (NULL, '$nick', '$hashed_password', '$email', 100, 100, 100, 14)"
                    )
                ) {
                    $_SESSION["successful_registration"] = true;
                    header("Location: welcome.php");
                } else {
                    throw new Exception($connection->error);
                }
                exit();
            }
            $connection->close();
        }
    } catch (Exception $error) {
        echo "<span style='color:red;'>Server error! Apologies for inconvenience. Please, register at another time.</span>";
        echo "<br /> Developer info: " . $error;
    }
}

// We delete the variables which the form remembers after wrong typing.
if (isset($_SESSION["reg_form_nick"])) {
    unset($_SESSION["reg_form_nick"]);
}
if (isset($_SESSION["reg_form_email"])) {
    unset($_SESSION["reg_form_email"]);
}
if (isset($_SESSION["reg_form_password1"])) {
    unset($_SESSION["reg_form_password1"]);
}
if (isset($_SESSION["reg_form_password2"])) {
    unset($_SESSION["reg_form_password2"]);
}
if (isset($_SESSION["reg_form_terms_conditions"])) {
    unset($_SESSION["reg_form_terms_conditions"]);
}

// We delete registration errors.
if (isset($_SESSION["error_nick"])) {
    unset($_SESSION["error_nick"]);
}
if (isset($_SESSION["error_email"])) {
    unset($_SESSION["error_email"]);
}
if (isset($_SESSION["error_password1"])) {
    unset($_SESSION["error_password1"]);
}
if (isset($_SESSION["error_password2"])) {
    unset($_SESSION["error_password2"]);
}
if (isset($_SESSION["error_terms_conditions"])) {
    unset($_SESSION["error_terms_conditions"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settlers - create free account!</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        .error {
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <form method="post">

        Nickname: <br /><input type="text" value="<?php
        if (isset($_SESSION['reg_form_nick'])) {
            echo $_SESSION['reg_form_nick'];
            unset($_SESSION['reg_form_nick']);
        } ?>" name="nick">
        <br />
        <?php
        if (isset($_SESSION["error_nick"])) {
            echo "<div class='error'>" . $_SESSION["error_nick"] . "</div>";
            unset($_SESSION["error_nick"]);
        }
        ?>

        E-mail: <br /><input type="text" value="<?php
        if (isset($_SESSION['reg_form_email'])) {
            echo $_SESSION['reg_form_email'];
            unset($_SESSION['reg_form_email']);
        } ?>" name="email"><br />
        <?php
        if (isset($_SESSION["error_email"])) {
            echo "<div class='error'>" . $_SESSION["error_email"] . "</div>";
            unset($_SESSION["error_email"]);
        }
        ?>

        Password: <br /><input type="password" value="<?php
        if (isset($_SESSION['reg_form_password1'])) {
            echo $_SESSION['reg_form_password1'];
            unset($_SESSION['reg_form_password1']);
        } ?>" name="password1"><br />
        <?php
        if (isset($_SESSION["error_password"])) {
            echo "<div class='error'>" . $_SESSION["error_password"] . "</div>";
            unset($_SESSION["error_password"]);
        }
        ?>

        Repeated password: <br /><input type="password" value="<?php
        if (isset($_SESSION['reg_form_password2'])) {
            echo $_SESSION['reg_form_password2'];
            unset($_SESSION['reg_form_password2']);
        } ?>" name="password2"><br />

        <label><input type="checkbox" name="terms_conditions" <?php
        if (isset($_SESSION["reg_terms_conditions"])) {
            echo "checked";
            unset($_SESSION["reg_terms_conditions"]);
        } ?>> I accept terms and conditions</label>
        <?php
        if (isset($_SESSION["error_terms_conditions"])) {
            echo "<div class='error'>" . $_SESSION["error_terms_conditions"] . "</div>";
            unset($_SESSION["error_terms_conditions"]);
        }
        ?>

        <div class="g-recaptcha" data-sitekey="6LfJyl8kAAAAALSqi2Lr_wvB5XzKNDvkq714tuN4"></div><br />
        <?php
        if (isset($_SESSION["error_bot"])) {
            echo "<div class='error'>" . $_SESSION["error_bot"] . "</div>";
            unset($_SESSION["error_bot"]);
        }
        ?>

        <input type="submit" value="register">
        </script>
    </form>
</body>

</html>