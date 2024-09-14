<?php
session_start();
require '../include/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (login($login, $password)) {
        header('Location: ../index.php');
        exit;
    }

    echo 'Неверный логин или пароль';
}
?>

<form method="POST">
    Логин: <label>
        <input type="text" name="login" required>
    </label>
    Пароль: <label>
        <input type="password" name="password" required>
    </label>
    <button type="submit">Войти</button>
</form>

<a href="register.php">Регистрация</a>
<a href="vk_login.php">Авторизоваться через VK</a>


