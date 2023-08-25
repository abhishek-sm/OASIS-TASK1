<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $conn = new mysqli("localhost", "root", "", "user_authentication");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, username, password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                $_SESSION["username"] = $row["username"];
                header("Location: secured_page.php");
            } else {
                echo "Invalid password";
            }
        } else {
            echo "User not found";
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
