<?php
session_start();
require '../include/auth.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $client_id = '52307774';
    $client_secret = 'bmnDZWGhmlJX24Lyp13S';
    $redirect_uri = 'http://localhost/auth/src/pages/vk_callback.php';

    $token_url = "https://oauth.vk.com/access_token?client_id=$client_id&client_secret=$client_secret&redirect_uri=$redirect_uri&code=$code";
    $response = file_get_contents($token_url);
    $data = json_decode($response, true);

    if (isset($data['access_token'])) {
        $accessToken = $data['access_token'];

        $user_url = "https://api.vk.com/method/users.get?access_token=$accessToken&v=5.131";
        $userResponse = file_get_contents($user_url);
        $userData = json_decode($userResponse, true);

        if (isset($userData['response'][0]['id'])) {
            $vk_id = $userData['response'][0]['id'];

            if (vkLogin($vk_id)) {
                header('Location: ../index.php');
                exit;
            }

            echo 'Ошибка при входе в систему. Попробуйте снова';
        } else {
            echo 'Не удалось получить данные о пользователе';
        }
    } else {
        echo 'Ошибка получения токена: ' . htmlspecialchars($data['error_description'] ?? 'Неизвестная ошибка');
    }
} else {
    echo 'Ошибка: отсутствует код авторизации';
}
