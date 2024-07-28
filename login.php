<?php
session_start(); 

require 'sdk.php'; 

$appId = "<app_id>";
$secret = "<secret>";
$version = "1.0";

$sdk = new VauthSDK($appId, $secret, $version);

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginResponse = $sdk->login($username, $password);

    // Debugging: Print the login response
    echo '<pre>';
    print_r($loginResponse);
    echo '</pre>';

    if(is_array($loginResponse) && isset($loginResponse['message'])) {
        if($loginResponse['message'] === 'Login successful') {
            $_SESSION['user_details'] = $loginResponse['data'];
            $_SESSION['user_logged_in'] = true;
            header("Location: welcome.php");
            exit; 
        } else {
            $loginMessage = "Login failed. Please try again.";
        }
    } else {
        $loginMessage = "An error occurred. Please try again later.";
    }
}

$loginMessage = isset($loginMessage) ? $loginMessage : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
 
    <?php if(!empty($loginMessage)): ?>
        <p><?php echo $loginMessage; ?></p>
    <?php endif; ?>
    
  
    <form method="post" action="">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>