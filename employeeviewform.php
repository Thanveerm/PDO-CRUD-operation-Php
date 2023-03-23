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
    $connection = new PDO("mysql:host=". $db_host .";dbname = " . $db_db, $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "database connection problem: " . $e->getMessage();
}
$stmt = $connection->prepare("SELECT * FROM employeedeatails");
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin: 20px 0;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .back-btn {
  display: inline-block;
  padding: 10px 20px;
  border-radius: 5px;
  text-decoration: none;
  background-color: #3b3b3b;
  color: #ffffff;
  font-weight: bold;
  text-align: center;
  transition: background-color 0.3s ease;
}

.back-btn:hover {
  background-color: #5c5c5c;
}
.edit-btn {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        background-color: #4CAF50;
        color: #ffffff;
        font-weight: bold;
        text-align: center;
        transition: background-color 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .edit-btn:hover {
        background-color: #3e8e41;
    }
</style>
<a href="employeeform.php" class="edit-btn">Back</a>
<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Department</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($records as $record):?>
            <tr>
                <td><?= $record['first_name'] ?></td>
                <td><?= $record['last_name'] ?></td>
                <td><?= $record['email'] ?></td>
                <td><?= $record['mobile'] ?></td>
                <td><?= $record['department'] ?></td>
                <td><button class="edit-btn" onclick="location.href='employeeeditform.php?id= <?= $record['id'] ?>'">Edit</button></td>
                <td>
                    <form method="POST" action="employeeformdelete.php">
                        <input type="hidden" name="id" value="<?= $record['id'] ?>">
                        <button type="submit" class="edit-btn">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
