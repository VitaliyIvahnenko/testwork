<?php
    require_once 'config.php';

    // Подключение к базе данных
    $conn = mysqli_connect($host, $user, $password, $dbname);

    // Получаем значения полей email и password из формы
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // Обработка запроса на авторизацию
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['login'])) {

            $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=? AND password=?");
            mysqli_stmt_bind_param($stmt, "ss", $email, $password);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            // Проверка, успешен ли запрос
            if(mysqli_num_rows($result) == 1){

                // Авторизация прошла успешно, сохраняем данные пользователя в сессии
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['userid'] = $row['id'];

                // Перенаправляем пользователя на домашнюю страницу
                header('Location: index.php');
                exit();

            }else{

                // Авторизация не удалась, выводим сообщение об ошибке
                 die("Неверный логин или пароль");
            }
        }

        // Обработка запроса на выход из учётной записи
        if(isset($_POST['logout'])){
            session_start();
            // разрушаем сессию
            session_unset();
            session_destroy();
            // перенаправляем пользователя на домашнюю страницу
            header('Location: index.php');
            exit();
        }

    // Обработка запроса на регистрацию
    if (isset($_POST['register'])) {

        // Проверяем, есть ли уже пользователь с таким email в базе данных
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
        // Если есть, выводим сообщение об ошибке
        echo "Пользователь с таким email уже зарегистрирован";
        } else {

        // Если нет, добавляем нового пользователя в базу данных
        $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        mysqli_query($conn, $query);

        // Выводим сообщение об успешной регистрации
         echo "Вы успешно зарегистрировались";
        }
    }
}
?>