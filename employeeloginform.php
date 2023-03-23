<?php
require __DIR__ .'/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$username = $_ENV['username'];
$password = $_ENV['psw'];
$_SESSION['username'] = $username;
$_SESSION['psw'] = $password;
if (isset($_POST['submit'])) {
    if ($username =$username && $psw =$password) {
        header("Location: employeeloginform.php");
        exit();
    } else {
        echo "Invalid login credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<style>
    .container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}
h1 {
    font-size: 36px;
    margin-bottom: 20px;
    text-align: center;
}
form {
    display: flex;
    flex-direction: column;
}
label {
    font-size: 20px;
    margin-bottom: 10px;
}
input[type="text"],
input[type="password"],
input[type="submit"] {
    padding: 10px;
    font-size: 20px;
    border: none;
    border-radius: 5px;
    margin-bottom: 20px;
}
input[type="submit"] {
    background-color: #008CBA;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.2s;
}
input[type="submit"]:hover {
    background-color: #0077b3;
}
.container {
    animation: fadeIn 0.5s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="post" action="employeeformhtml.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="psw"><br><br>
            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</body>
</html>
