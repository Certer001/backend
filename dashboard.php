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

// Получение информации о пользователе
$user_id = $_SESSION['user_id'];
// $query = "SELECT role FROM employes WHERE id = :id"; 
// $stmt = $pdo->prepare($query); // Подготовка запроса
// $stmt->bindParam(':id', $user_id, PDO::PARAM_INT); 
// $stmt->execute(); а
// $user = $stmt->fetch(PDO::FETCH_ASSOC);



// 
// if (!$user || empty($user['role'])) {
//     echo "<h1>Ошибка</h1>";
//     echo "<p>У вас нет прав для доступа к этой странице.</p>";
//     exit();
// }

// 
// $isAdmin = ($user['role'] === 'admin');


// Получение информации о пользователе
$user_id = $_SESSION['user_id'];

$query = "SELECT id, surname, secondname, phone, enrollment, branch FROM employes WHERE id = :id"; 
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Личный кабинет</title>
</head>
<body>
    <h1>Добро пожаловать в ваш личный кабинет!</h1>
    <p>Вы успешно вошли в систему.</p>

    <!-- // if ($isAdmin): -->
        <!-- <a href="news.php" class="button">Управление новостями</a> -->
     <!-- endif; -->

    <?php print_r($user); ?>

    <a href="index.php">Вернуться на главную</a>
    <a href="logout.php" class="button">Выйти</a>
</body>
</html>