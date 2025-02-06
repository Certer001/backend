<?php
session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Перенаправление на страницу входа
    exit();
}

// Подключение к базе данных
require 'db.php'; // Подключите файл с настройками базы данных

// Проверка соединения
if (!$pdo) {
    die("Ошибка: соединение с базой данных не установлено.");
}

// Получение информации о пользователе
$user_id = $_SESSION['user_id'];
// $query = "SELECT role FROM employes WHERE id = :id"; // Подготовленный запрос
// $stmt = $pdo->prepare($query); // Подготовка запроса
// $stmt->bindParam(':id', $user_id, PDO::PARAM_INT); // Привязка параметра
// $stmt->execute(); // Выполнение запроса
// $user = $stmt->fetch(PDO::FETCH_ASSOC); // Извлечение ассоциативного массива

// Проверка, есть ли у пользователя роль
// if (!$user || empty($user['role'])) {
//     echo "<h1>Ошибка</h1>";
//     echo "<p>У вас нет прав для доступа к этой странице.</p>";
//     exit();
// }

// Проверка роли
// $isAdmin = ($user['role'] === 'admin');
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
        <a href="news.php" class="button">Управление новостями</a>
     <!-- endif; -->

    <a href="index.php">Вернуться на главную</a>
    <a href="logout.php" class="button">Выйти</a>
</body>
</html>