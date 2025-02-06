<?php
session_start();
include 'db.php'; // Assuming this correctly connects to your database.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone']; // Using phone as the username
    $password = $_POST['password'];

    // Prepare the statement using the phone number.
    $stmt = $pdo->prepare("SELECT * FROM employes WHERE phone = ?");
    $stmt->execute([$phone]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Use FETCH_ASSOC to get an associative array

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        $_SESSION['surname'] = $user['surname'];
        $_SESSION['secondname'] = $user['secondname']; // Store secondname
        $_SESSION['phone'] = $user['phone'];
        header('Location: dashboard.php'); // Redirect to dashboard
        exit();
    } else {
        echo "<p style='color: red;'>Неверный номер телефона или пароль.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Вход</title>
    <style>
        /* Optional: Basic styling for better presentation */
        body { font-family: sans-serif; }
        form { width: 300px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        label, input { display: block; margin-bottom: 10px; }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        a { display: block; text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Вход</h1>
    <form method="POST">
        <label for="phone">Номер телефона:</label>
        <input type="text" name="phone" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit">Войти</button>
    </form>
    <a href="index.php">Назад</a>
</body>
</html>