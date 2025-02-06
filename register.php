<?php
include 'db.php'; // Assuming this connects to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input (VERY IMPORTANT)
    $surname = htmlspecialchars(trim($_POST['surname'])); // Surname
    $secondname = htmlspecialchars(trim($_POST['secondname'])); // Second name
    $phone = htmlspecialchars($_POST['phone']); // Phone number (only digits)
    $enrollment = intval($_POST['enrollment']); // Enrollment year (convert to integer)
    $branch = htmlspecialchars(trim($_POST['branch'])); // Branch
    $password = $_POST['password'];

    // Basic Validation
    $errors = [];

    if (empty($surname)) {
        $errors[] = "Пожалуйста, введите фамилию.";
    }
    if (empty($secondname)) {
        $errors[] = "Пожалуйста, введите имя.";
    }
    if (empty($phone) || strlen($phone) < 10 || strlen($phone) > 15) {
        $errors[] = "Пожалуйста, введите корректный номер телефона."; // Adjust length as needed
    }
    if (empty($enrollment) || $enrollment < 2000 || $enrollment > (int)date("Y") + 5) { // Reasonable year range.
        $errors[] = "Пожалуйста, введите корректный год поступления.";
    }
    if (empty($branch)) {
        $errors[] = "Пожалуйста, введите название филиала.";
    }
    if (empty($password) || strlen($password) < 8) { //Minimum password length
        $errors[] = "Пожалуйста, введите пароль (минимум 8 символов).";
    }

    if (empty($errors)) {
        // Check if phone number already exists (avoid duplicates)
        $stmt_check = $pdo->prepare("SELECT phone FROM employes WHERE phone = ?");
        $stmt_check->execute([$phone]);
        if ($stmt_check->fetch()) { // if a row is returned the phone already exists
            $errors[] = "Пользователь с таким номером телефона уже зарегистрирован.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the INSERT statement
            $stmt = $pdo->prepare("INSERT INTO employes (surname, secondname, phone, enrollment, branch, password) VALUES (?, ?, ?, ?, ?, ?)");
            try { // Wrap in a try...catch to handle potential database errors
                if ($stmt->execute([$surname, $secondname, $phone, $enrollment, $branch, $hashed_password])) {
                    header('Location: success.php'); // Redirect on success
                    exit();
                } else {
                    $errors[] = "Ошибка регистрации. Пожалуйста, попробуйте позже.";
                    // Log the error for debugging (optional)
                    error_log("Registration error: " . print_r($stmt->errorInfo(), true)); // Log the detailed error.
                }
            } catch (PDOException $e) {
                $errors[] = "Ошибка базы данных: " . $e->getMessage();
                error_log("Database error during registration: " . $e->getMessage());
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Регистрация</title>
    <style>
        /* Basic Styling (Optional) */
        body { font-family: sans-serif; }
        form { width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        label, input, select { display: block; margin-bottom: 10px; }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .error { color: red; margin-bottom: 10px; }
        a { display: block; text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Регистрация</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label for="surname">Фамилия:</label>
        <input type="text" name="surname" required>

        <label for="secondname">Имя:</label>
        <input type="text" name="secondname" required>

        <label for="number">Номер телефона:</label>
        <input type="tel" name="phone" required>

        <label for="enrollment">Год поступления:</label>
        <input type="number" name="enrollment" required>

        <label for="branch">Филиал:</label>
        <input type="text" name="branch" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required>

        <button type="submit">Зарегистрироваться</button>
    </form>
    <a href="index.php">Назад</a>
</body>
</html>