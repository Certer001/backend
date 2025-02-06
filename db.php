<?php
$host = 'localhost'; // Адрес сервера
$db = 'main'; // Имя базы данных
$user = 'root'; // Имя пользователя
$pass = ''; // Пароль

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>