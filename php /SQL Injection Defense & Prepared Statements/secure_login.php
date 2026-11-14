
<?php

$host = "localhost";
$dbname = "security_demo";
$username = "root";
$password = "";

try {

    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $user = $_POST["username"] ?? "";

        // Prepared Statement
        $sql = "SELECT * FROM users WHERE username = :username";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ":username" => $user
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {

            echo "User found: " . htmlspecialchars($result["username"]);

        } else {

            echo "User not found.";

        }
    }

} catch (PDOException $e) {

    echo "Database connection error.";

}

?>

<form method="POST">
    <h3>User Search</h3>

    <input
        type="text"
        name="username"
        placeholder="Enter username"
        required
    >

    <button type="submit">Search</button>
</form>
