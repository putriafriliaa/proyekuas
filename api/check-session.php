<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['user'])) {
    echo json_encode([
        'login' => true,
        'user' => $_SESSION['user']
    ]);
} else {
    echo json_encode([
        'login' => false,
        'hash' => password_hash("12345", PASSWORD_DEFAULT)
    ]);
}
?>
