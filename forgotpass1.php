<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'C:\xampp\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\PHPMailer-master\src\SMTP.php';
require 'C:\xampp\PHPMailer-master\src\Exception.php';

include("dbconfig.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    $sql = "SELECT * FROM userdetails WHERE username = ?"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            
            $randomNumber = strval(random_int(100000, 999999));

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Use a Gmail App Password generated in your Google account settings
                $mail->Username = 'xero.prints231@gmail.com';
                $mail->Password = 'omhr ybjs wxyk ktvj'; // App Password

                $mail->setFrom('xero.prints231@gmail.com', 'XERO');
                $mail->addAddress($email, 'Recipient Name');

                $mail->Subject = 'VERIFICATION CODE - OTP from XERO!';
                $mail->Body = "Hello! Recipient Name \n\nHere's your reset code: $randomNumber \n\nIf you didn't request this, please ignore this email. \n\nSENTHIL\nTeam XERO :)";

                $mail->send();
                
                
                $insertSql = "UPDATE userdetails SET otp = ? WHERE username = ?";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bind_param("ss", $randomNumber, $email);
                if ($insertStmt->execute()) {
                    
                    header("Location: enternew.php?email='$email'");
                };
                $insertStmt->close();
            } catch (Exception $e) {
                echo 'Email could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        } else {
            
            echo '<script>alert("Email not found in the database. Please check your email address.");</script>';
            echo '<script>window.location.href = "forgotpassword.html";</script>';
            exit(); 
        }
    } else {
        echo 'Error: ' . $sql . '<br>' . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
