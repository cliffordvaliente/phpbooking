<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Redirect</title>
</head>

<body>
    <p>Du er logget ut! Straks blir du videresendt til forsiden.</p>

    <?php
    // Redirect to index.php after a 3-second delay
    header("refresh:3;url=../index.php");
    exit();
    ?>
</body>

</html>
