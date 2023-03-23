<?php

require __DIR__ .'/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$db_host = $_ENV['host'];
$db_user = $_ENV['user'];
$db_password = $_ENV['password'];
$db_db = $_ENV['db'];
try {
    $connection = new PDO("mysql:host=". $db_host .";dbname=". $db_db, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "database connection problem: " . $e->getMessage();
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM employeedeatails WHERE id = '$id'";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    header("Location:employeeviewform.php");
}
