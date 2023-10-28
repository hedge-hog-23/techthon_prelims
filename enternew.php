<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <form action="resetpass.php" method="post">
    
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
        <label for="otp">enter code:</label><br>
        <input type="text" name="otp" required><br><br>
        <label for="new-password">New Password:</label><br>
        <input type="password" name="new-password" required><br><br>
        <label for="confirm-password">Confirm Password:</label><br>
        <input type="password" name="confirm-password" required><br><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
