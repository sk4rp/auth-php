<?php
session_start();
require 'include/auth.php';

if (!isset($_SESSION['user'])) {
    header('Location: pages/login.php');
    exit;
}

echo "<h1>Добро пожаловать, " . $_SESSION['user']['login'] . "!</h1>";

if (isVkUser()) {
    echo "<p>Вы вошли через VK</p>";
    echo '<img src="images/cat.jpg" alt="Картинка для VK пользователей">';
} else {
    echo "<p>Вы обычный пользователь</p>";
}
?>

<a href="pages/logout.php">Выйти</a>
