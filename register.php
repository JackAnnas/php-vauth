<?php
session_start(); 

require 'sdk.php'; 

$appId = "<app_id>";
$secret = "<secret>";
$version = "1.0";

$sdk = new VauthSDK($appId, $secret, $version);

if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $token = $_POST['token'];
    $email = $_POST['email'];

    $registrationResponse = $sdk->register($username, $password, $token, $email);

    if(is_array($registrationResponse) && isset($registrationResponse['message'])) {
        if($registrationResponse['message'] === 'Registration successful') {
            $_SESSION['user_details'] = $registrationResponse['data'];
            $_SESSION['user_logged_in'] = true;
            header("Location: welcome.php");
            exit;
        } else {
            $registrationMessage = "Registration failed. " . $registrationResponse['message'];
        }
    } else {
        $registrationMessage = "An error occurred. Please try again later.";
    }
}

$registrationMessage = isset($registrationMessage) ? $registrationMessage : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if(!empty($registrationMessage)): ?>
        <p><?php echo $registrationMessage; ?></p>
    <?php endif; ?>
    
    <form method="post" action="">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        Token: <input type="text" name="token" required><br>
        Email: <input type="email" name="email" required><br>
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>