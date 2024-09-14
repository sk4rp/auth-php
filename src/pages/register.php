<?php
session_start();
require '../include/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = $_POST['login'];
    $password = $_POST['password'];

    if (register($login, $password)) {
        header('Location: login.php');
    } else {
        echo 'Ошибка при регистрации';
    }
}
?>

<form method="POST">
    Логин: <label>
        <input type="text" name="login" required>
    </label>
    Пароль: <label>
        <input type="password" name="password" required>
    </label>
    <button type="submit">Зарегистрироваться</button>
</form>
<a href="login.php">Войти</a>
