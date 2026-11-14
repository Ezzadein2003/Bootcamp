
<?php

// Secure session configuration
ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);

session_set_cookie_params([
    "lifetime" => 0,
    "path" => "/",
    "secure" => !empty($_SERVER["HTTPS"]),
    "httponly" => true,
    "samesite" => "Lax"
]);

session_start();

$message = "";

// Demo login credentials
$correct_username = "admin";
$correct_password = "123456";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if (
        $username === $correct_username &&
        $password === $correct_password
    ) {

        // Prevent session fixation
        session_regenerate_id(true);

        $_SESSION["username"] = $username;

        // Secure cookie example
        setcookie("user_status", "logged_in", [
            "expires" => 0,
            "path" => "/",
            "secure" => !empty($_SERVER["HTTPS"]),
            "httponly" => true,
            "samesite" => "Lax"
        ]);

        header("Location: dashboard.php");
        exit;

    } else {

        $message = "Invalid username or password.";

    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Login</title>
</head>
<body>

    <h2>Login System</h2>

    <form method="POST">

        <input type="text" name="username"
               placeholder="Username" required>

        <br><br>

        <input type="password" name="password"
               placeholder="Password" required>

        <br><br>

        <button type="submit">Login</button>

    </form>

    <p><?php echo htmlspecialchars($message); ?></p>

</body>
</html>
