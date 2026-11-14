
<?php

session_start();

// Check user session
if (!isset($_SESSION["username"])) {

    header("Location: login.php");
    exit;

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

    <h2>Welcome to Dashboard</h2>

    <p>
        Hello,
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
    </p>

    <p>Session is active.</p>

    <a href="logout.php">Logout</a>

</body>
</html>
