<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $password])) {
        header('Location: success.php');
        exit();
    } else {
        echo "Ошибка регистрации.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <form method="POST">
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" required>
        
        <label for="password">Пароль:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Зарегистрироваться</button>
    </form>
    <a href="index.php">Назад</a>
</body>
</html>