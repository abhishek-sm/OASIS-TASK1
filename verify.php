<?php
if (isset($_GET["code"])) {
    $verificationCode = $_GET["code"];

    $conn = new mysqli("localhost", "root", "", "user_authentication");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, verified FROM users WHERE verification_code='$verificationCode'";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row["verified"] == 0) {
            $updateSql = "UPDATE users SET verified = 1 WHERE verification_code='$verificationCode'";
            if ($conn->query($updateSql) === TRUE) {
                echo "Account verified successfully!";
            } else {
                echo "Error verifying account: " . $conn->error;
            }
        } else {
            echo "Account already verified.";
        }
    } else {
        echo "Invalid verification code.";
    }

    $conn->close();
}
?>
