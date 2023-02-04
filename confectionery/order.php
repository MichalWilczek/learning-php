<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
</head>

<body>
    <?php
    $doughnuts = $_POST["doughnuts"];
    $pancakes = $_POST["pancakes"];
    $sum = $doughnuts * 2 + $pancakes * 4;
    echo <<<END
    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <td>Doughnuts (2 EUR / piece)</td>
            <td>$doughnuts</td>
        </tr>
        <tr>
            <td>Pancakes (4 EUR / piece)</td>
            <td>$pancakes</td>
        </tr>
        <tr>
            <td>Sum</td>
            <td>$sum EUR</td>
        </tr>
    </table>
    <br>
    <a href="index.php">Return to main page</a>
END;
    ?>
</body>

</html>