<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Главная страница</title>
</head>
<body>
    <header class="header">
        <div class="logo"><!--просто название или лого хуй знает--></div>
        <div class="auth-buttons">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="button">Регистрация</a>
                <a href="login.php" class="button">Вход</a>
            <?php else: ?>
                <a href="dashboard.php" class="button">Личный кабинет</a>
                <a href="logout.php" class="button">Выход</a>
            <?php endif; ?>
        </div>
    </header>
    

    <div class="news">
        <h1 class="news-title">Новости</h1>
            <?php
            $query = "SELECT id, created_at, title, body FROM news";
            $stmt = $pdo->prepare($query);
            $stmt->execute(); 
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            
            if ($results) {
                foreach ($results as $row) {
            ?>
                    <div class="news-container">
            <?php
                    echo "<h2 class='news_title'>" . htmlspecialchars($row['title']) . "</h2>";
                    echo "<p class='news_date'><strong>Дата:</strong> " . htmlspecialchars($row['created_at']) . "</p>"; 
                    echo "<p class='news_body'>" . nl2br(htmlspecialchars($row['body'])) . "</p>"; 
            ?>
                    </div>
            <?php
                }
            } else {
                echo "<h3>Нет новостей для отображения</h3>";
            }
            ?>
    </div>
</body>
</html>