<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized'
    ]);
    exit;
}

$conn = new mysqli("localhost", "root", "root", "db_laundry");

if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed'
    ]);
    exit;
}

$user_id = $_SESSION['user']['id'];
$old_password = $_POST['old_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';

if ($old_password === '' || $new_password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Password tidak boleh kosong'
    ]);
    exit;
}

// ambil password lama dari DB
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!password_verify($old_password, $user['password'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Password lama salah'
    ]);
    exit;
}

// hash password baru
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

$update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$update->bind_param("si", $new_hash, $user_id);
$update->execute();

echo json_encode([
    'success' => true,
    'message' => 'Password berhasil diperbarui'
]);
