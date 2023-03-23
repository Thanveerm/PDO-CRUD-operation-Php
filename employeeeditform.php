<?php
require __DIR__ .'/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$db_host = $_ENV['host'];
$db_user = $_ENV['user'];
$db_password = $_ENV['password'];
$db_db = $_ENV['db'];
try {
    $connection = new PDO("mysql:host=". $db_host .";dbname=". $db_db, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $department = $_POST['department'];
        $stmt_check = $connection->prepare("SELECT * FROM employeedeatails WHERE (email = :email OR mobile = :mobile) AND id != :id");
        $stmt_check->bindParam(':email', $email);
        $stmt_check->bindParam(':mobile', $mobile);
        $stmt_check->bindParam(':id', $id);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if ($result['email'] == $email) {
                echo "<script>alert('Email already exists.')</script>";
            } elseif ($result['mobile'] == $mobile) {
                echo "<script>alert('Mobile already exists.')</script>";
            }
        } else {
            $stmt_update = $connection->prepare("UPDATE employeedeatails SET first_name = :first_name, last_name = :last_name, email = :email, mobile = :mobile, department = :department WHERE id = :id");
            $stmt_update->bindParam(':id', $id);
            $stmt_update->bindParam(':first_name', $first_name);
            $stmt_update->bindParam(':last_name', $last_name);
            $stmt_update->bindParam(':email', $email);
            $stmt_update->bindParam(':mobile', $mobile);
            $stmt_update->bindParam(':department', $department);
            $stmt_update->execute();
            header("Location: employeeviewform.php");
        }
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $connection->prepare("SELECT * FROM employeedeatails WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    echo "Database connection problem: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    form {
        display: flex;
        flex-direction: column;
        background-color: #f2f2f2;
        border-radius: 5px;
        padding: 20px;
        width: 300px;
        margin: 0 auto;
    }
    label {
        font-weight: bold;
        margin-bottom: 10px;
    }
    input {
        padding: 10px;
        border: none;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    input[type=submit] {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }
    input[type=submit]:hover {
        background-color: #3e8e41;
    }
</style>
<form method="POST">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" value="<?= $employee['first_name'] ?? '' ?>">
    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" value="<?= $employee['last_name'] ?? '' ?>">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?= $employee['email'] ?? '' ?>">
    <label for="mobile">Mobile:</label>
    <input type="tel" name="mobile" id="mobile" value="<?= $employee['mobile'] ?? '' ?>">
    <label for="department">Department:</label>
    <input type="text" name="department" id="department" value="<?= $employee['department'] ?? '' ?>">
    <input type="hidden" name="id" value="<?= $employee['id'] ?? '' ?>">
    <input type="submit" name="submit" value="Update">
</form>
</body>
</html>