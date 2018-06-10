<?php
require 'db_L4u6VVFk8xFiag.php';

$errorMsg = '';
$useragent = $_SERVER['HTTP_USER_AGENT'];

if (isset($_POST['email'])) {
    $query = pg_query(
        $conn,
        "SELECT * FROM users WHERE email = '" .
        waf($_POST['email']) .
        "' AND ua = '" .
        custom_enc($useragent) .
        "';"
    ) or die(pg_last_error($conn));

    $accountExists = pg_num_rows($query);

    if (!$accountExists) {
        $errorMsg = "Nope, I don't believe it's you. Did you get a new PC lately?";
    } else {
        $errorMsg = "Welcome back! There's not much around.. ever since we got hacked, we had to clean everything! Hopefully our database is safe now.";
    }
}

?>

<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
    <link rel="stylesheet" href="style.css">
</head>

<h1 class="message">Login</h1>
<?php if ($errorMsg !== '') { ?>
    <h2 class='message errorMessage'><?php echo $errorMsg; ?></h2>
<?php } ?>

<div id="login">
    <form name='form-login' method='POST'>
        <span class="fontawesome-user"></span>
        <input type="email" name="email" id="email" placeholder="Email">
        
        <input type="submit" value="Login">

        <a class='formLink' href="/register.php">Register</a>
    </form>
</div>
