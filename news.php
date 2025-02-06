<?php
session_start();

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Перенаправление на страницу входа
    exit();
}

// Подключение к базе данных
require 'db.php'; // Подключите файл с настройками базы данных

// Получение информации о пользователе
$user_id = $_SESSION['user_id'];
$query = "SELECT role FROM users WHERE id = :id"; // Подготовленный запрос
$stmt = $pdo->prepare($query); // Подготовка запроса
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT); // Привязка параметра
$stmt->execute(); // Выполнение запроса
$user = $stmt->fetch(PDO::FETCH_ASSOC); // Извлечение ассоциативного массива

// Проверка роли
if ($user['role'] !== 'admin') {
    echo "<h1>Ошибка доступа</h1>";
    echo "<p>У вас нет прав для доступа к этой странице.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Управление новостями</title>
</head>
<body>
    <h1>Управление новостями</h1>
    <p>Здесь вы можете управлять новостями.</p>
    <a href="dashboard.php">Вернуться в личный кабинет</a>
    <a href="logout.php" class="button">Выйти</a>
    
    <h2>Добавить новость</h2>
    <form method="POST">
        <label for="title">Заголовок новости:</label>
        <input type="text" name="title" required>
        
        <label for="body">Тело новости:</label>
        <textarea name="body" required></textarea>
        
        <button type="submit">Добавить новость</button>
    </form>
    
    <?php
    // Обработчик формы
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $body = $_POST['body'];
        
        // Подготовка запроса для добавления новости
        $query = "INSERT INTO news (title, body, created_at) VALUES (:title, :body, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->execute();
        
        // Проверка результата
        if ($stmt->rowCount() === 1) {
            echo "<p>Новость добавлена successfully!</p>";
        } else {
            echo "<p>Ошибка добавления новости.</p>";
        }
    }
    ?>
</body>
</html>