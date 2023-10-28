<?php
session_start();
include("dbconfig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredOTP = $_POST["otp"];
    $email = $_POST['email'];
    $email = substr($email, 1, -1);
    // echo $enteredOTP;
    // echo $email;
    $sql = "SELECT otp FROM userdetails WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $savedOTP = $row["otp"];
            
            if ($enteredOTP == $savedOTP) {
                $newPassword = $_POST["new-password"];
                $updateSql = "UPDATE userdetails SET PASSWORD1 = ? WHERE username = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ss", $newPassword, $email);
                
                if ($updateStmt->execute()) {
                    // ok
                    echo '<script>alert("Password reset successfully")</script>';
                    echo '<script>window.location.href = "welcome.php"</script>';
                    exit();
                } else {
                    // error
                    echo 'Error updating the password: ' . $updateStmt->error;
                }
            } else {
                // incorrect OTP
                echo 'Incorrect OTP. Please try again.';
            }
        } else {
            echo "User not found or no OTP associated with this email.";
        }
    } else {
        echo 'Error executing the SQL query: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
