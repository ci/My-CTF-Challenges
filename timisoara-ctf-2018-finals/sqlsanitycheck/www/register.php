<?php
require 'db_L4u6VVFk8xFiag.php';

if (isset($_POST['email'])) {
    $email = addslashes($_POST['email']);
    pg_query(
        $conn,
        "INSERT INTO users (ua, email) VALUES ('" .
            waf(custom_enc($_SERVER['HTTP_USER_AGENT'])) .
        "', '" .
            waf($_POST['email']) .
        "');");

    header('Location: login.php');
}

?>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
    <link rel="stylesheet" href="style.css">
</head>

<h1 class="message">Register</h1>

<div id="login">
    <form name='form-login' method='POST'>
        <span class="fontawesome-user"></span>
        <input type="email" name='email' placeholder="Email">
        
        <input type="submit" value="Register">

        <a class='formLink' href="/login.php">Login</a>
    </form>
</div>
