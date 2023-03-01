<?php

require_once 'config.php';
require_once 'models/User.php';
require_once 'controllers/AuthController.php';

$conn = mysqli_connect($host, $user, $password, $dbname);

$authController = new AuthController($conn);

// Обработка запроса на регистрацию
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Проверяем, есть ли уже пользователь с таким email в базе данных
    if ($auth->userExists($email)) {
        // Если есть, выводим сообщение об ошибке
        echo "Пользователь с таким email уже зарегистрирован";
    } else {
        // Если нет, добавляем нового пользователя в базу данных
        $auth->registerUser($email, $password);
        // Выводим сообщение об успешной регистрации
        echo "Вы успешно зарегистрировались";
    }
}

// Обработка запроса на выход из учётной записи
if (isset($_POST['logout'])) {
    $auth = new Auth($conn);
    $auth->logoutUser();
}
?>