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
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $department = $_POST['department'];
    $stmt_check = $connection->prepare("SELECT * FROM employeedeatails WHERE email = :email OR mobile = :mobile");
    $stmt_check->bindParam(':email', $email);
    $stmt_check->bindParam(':mobile', $mobile);
    $stmt_check->execute();
    $result = $stmt_check->fetch(PDO::FETCH_ASSOC);
    $error='';
    if ($result) {
        if ($result['email'] == $email) {
            echo "<script>alert('Email already exists.')</script>";
        } elseif ($result['mobile'] == $mobile) {
            echo "<script>alert('Mobile already exists.')</script>";
        }
    } else {
        $stmt_insert = $connection->prepare("INSERT INTO employeedeatails (first_name, last_name, email, mobile, department) VALUES (:fname, :lname, :email, :mobile, :department)");
        $stmt_insert->bindParam(':fname', $fname);
        $stmt_insert->bindParam(':lname', $lname);
        $stmt_insert->bindParam(':email', $email);
        $stmt_insert->bindParam(':mobile', $mobile);
        $stmt_insert->bindParam(':department', $department);
        $stmt_insert->execute();
        header("Location:employeeform.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Employee Registration Form</title>
<link rel="stylesheet" type="text/css" href="employeeform.css">
</head>
   <style>
   body {
       background-color: #f2f2f2;
       font-family: Arial, Helvetica, sans-serif;
   }
   .container {
       width: 50%;
       margin: 0 auto;
       background-color: #fff;
       padding: 20px;
       box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
       border-radius: 10px;
   }
   h1 {
       text-align: center;
   }

   form {
       display: flex;
       flex-direction: column;
   }

   label {
       margin-top: 10px;
   }
   input[type="text"], input[type="email"], input[type="tel"] {
       padding: 5px;
       border-radius: 5px;
       border: 1px solid #ccc;
   }
   input[type="submit"] {
       background-color: blue;
       color: #fff;
       padding: 10px;
       border-radius: 5px;
       border: none;
       cursor: pointer;
       margin-top: 10px;
   }

   input[type="submit"]:hover {
       opacity: 0.8;
   }
   .view-btn, .logout-btn {
     display: inline-block;
     padding: 10px 20px;
     border-radius: 5px;
     text-decoration: none;
     font-weight: bold;
     color: #ffffff;
     text-align: center;
     margin-top: 10px;
   }
   .view-btn {
     background-color: green;
   }
   .logout-btn {
     background-color: red;
   }
   .view-btn:hover, .logout-btn:hover {
     opacity: 0.8;
   }
   </style>
</head>
<body>
    <div class="container">
        <h1>Employee Registration Form</h1>
            <form method="POST" acttion="">
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" required>
                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="mobile">Mobile:</label>
                <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" required>
                <label for="department">Department:</label>
                <input type="text" id="department" name="department">
                <input type="submit" name="submit" value="Register">
                <a href="employeeviewform.php" class="view-btn">View Details</a>
                <a href="employeeloginform.php" class="logout-btn">Logout</a>
            </form>
     </div>
</body>
</html> 
