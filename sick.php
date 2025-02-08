<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'db.php'; 

if (!$pdo) {
    die("Ошибка: соединение с базой данных не установлено.");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = $_POST['start_date']; 
    $endDate = $_POST['end_date'];     
    $user_id = $_SESSION['user_id'];  


    if (empty($startDate) || empty($endDate) || empty($user_id)) {
        echo "<p style='color: red;'>Не все поля заполнены.</p>";
        exit(); 
    }


    $stmt = $pdo->prepare("INSERT INTO sick (`start date`, `end date`, `user_id`) VALUES (:start_date, :end_date, :user_id)");

    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);  

    try { 
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Данные успешно добавлены.</p>";

        } else {
            echo "<p style='color: red;'>Ошибка при добавлении данных.</p>";

            error_log("Error inserting sick record: " . print_r($stmt->errorInfo(), true));
        }

    } catch (PDOException $e) {
        echo "<p style='color: red;'>Ошибка базы данных: " . $e->getMessage() . "</p>";
        error_log("Database error: " . $e->getMessage());  
    }
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
<body>
<form method="POST">
    <label for="start_date">Дата начала:</label>
    <input type="date" id="start_date" name="start_date" required><br><br>

    <label for="end_date">Дата окончания:</label>
    <input type="date" id="end_date" name="end_date" required><br><br>

    <button type="submit">Отправить</button>
</form>
</body>
</html>