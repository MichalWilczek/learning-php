<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piekarnia</title>
</head>
<body>

    <h1>Online order</h1>

    <form action="order.php" method="post">
        How many doughnuts? (2EUR / piece)
        <input type="text" name="doughnuts" /> 
        <br />
        <br />

        How many pancakes? (3EUR / piece)
        <input type="text" name="pancakes" /> 
        <br />
        <br />

        <input type="submit" value="order" />
    </form>

</body>
</html>