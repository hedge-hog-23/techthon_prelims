<?php
session_start();

include_once "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $sql = "SELECT * FROM userdetails WHERE USERNAME = ? and PASSWORD1 = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            echo "Sign-in successful.";
            $_SESSION['username'] = $user;
            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid username or password. Please recheck your credentials.";
        }
    } else {
        echo $stmt->error;
    }
    $stmt->close();
}
?>
