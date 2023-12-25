<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
</head>
<body>
    <h2>Вход на сайт</h2>
    <form method="POST" action="authorization.php">
        <label>E-mail:</label><br>
        <input type="text" name="email"><br><br>
        <label>Пароль:</label><br>
        <input type="password" name="password"><br><br>
        <input type="submit" value="Войти">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $mysqli = new mysqli("localhost", "root", "", "my_db");

        if ($mysqli->connect_error) {
            die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
        }

        $email = mysqli_real_escape_string($mysqli, $email);

        $sql = "SELECT id, name, email, password FROM users WHERE email='$email'";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                echo '<p style="color: green;">Успешный вход. Добро пожаловать, ' . $row['name'] . '!</p>';
            } else {
                echo '<p style="color: red;">Неверный email или пароль</p>';
            }
        } else {
            echo '<p style="color: red;">Пользователь не найден</p>';
        }

        $mysqli->close();
    }
    ?>
</body>
</html>
