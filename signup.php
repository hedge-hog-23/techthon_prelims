<?php
include_once "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $sql = "INSERT INTO userdetails (USERNAME, PASSWORD1) 
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass); 

    if ($stmt->execute()) {
        echo "User registration successful.";
        
    } else {
        echo $stmt->error;
    }

    $stmt->close();
}
?>
