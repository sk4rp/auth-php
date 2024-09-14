<?php
$client_id = '52307774';
$client_secret = 'bmnDZWGhmlJX24Lyp13S';
$redirect_uri = 'http://localhost/auth/src/pages/vk_callback.php';

$auth_url = "https://oauth.vk.com/authorize?client_id=$client_id&redirect_uri=$redirect_uri&response_type=code&scope=offline,email";

header('Location: ' . $auth_url);
exit;
