<?php
session_start();
require '../include/auth.php';

logout();
header('Location: login.php');
