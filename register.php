 <!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css">
    <title>Registration Page</title>
</head>
<body>
    <h2>Register</h2>
    <form action="registration.php" method="post">
    


    <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="index.php">login here</a></p>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $verificationCode = md5(uniqid(rand(), true)); // Generate a unique verification code

    $conn = new mysqli("localhost", "root", "", "user_authentication");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (username, password, email, verification_code, verified) VALUES ('$username', '$password', '$email', '$verificationCode', 0)";

    if ($conn->query($sql) === TRUE) {
        // Send verification email
        $to = $email;
        $subject = "Account Verification";
        $message = "Click the following link to verify your account: http://yourdomain.com/verify.php?code=$verificationCode";
        $headers = "From: abhikrish85@gmail.com"; // Change this to your email

        mail($to, $subject, $message, $headers);

        echo "Registration successful. An email has been sent to your address for verification.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

