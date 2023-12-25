<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрационная форма</h2>
    <form method="POST" action="registration.php">
        <label>Имя:</label><br>
        <input type="text" name="name"><br><br>
        <label>E-mail:</label><br>
        <input type="text" name="email"><br><br>
        <label>Пароль:</label><br>
        <input type="password" name="password"><br><br>
        <input type="submit" value="Регистрация">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($name) || empty($email) || empty($password)) {
            echo '<p style="color: red;">Все поля должны быть заполнены</p>';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<p style="color: red;">Некорректный формат e-mail</p>';
        } else {
            $mysqli = new mysqli("localhost", "root", "", "my_db");
            if ($mysqli->connect_error) {
                die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
            }

            $name = mysqli_real_escape_string($mysqli, $name);
            $email = mysqli_real_escape_string($mysqli, $email);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

            if ($mysqli->query($sql) === TRUE) {
                echo '<p style="color: green;">Регистрация прошла успешно</p>';
            } else {
                echo '<p style="color: red;">Ошибка при регистрации: ' . $mysqli->error . '</p>';
            }

            $mysqli->close();
        }
    }
    ?>
</body>
</html>
