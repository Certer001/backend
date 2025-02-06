<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Неверное имя пользователя или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Вход</title>
</head>
<body>
    <h1>Вход</h1>
    <form method="POST">
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" required>
        
        <label for="password">Пароль:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Войти</button>
    </form>
    <a href="index.php">Назад</a>
</body>
</html>