<?php
session_start();
header('Content-Type: application/json');

require 'koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Username dan password wajib diisi'
    ]);
    exit;
}

/* Prepare query */
$stmt = mysqli_prepare($conn, "SELECT id, username, password, full_name, role FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo json_encode([
        'success' => false,
        'message' => 'User tidak ditemukan'
    ]);
    exit;
}

/* Verifikasi password */
if (!password_verify($password, $user['password'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Password salah'
    ]);
    exit;
}

/* Simpan data ke session */
$_SESSION['user'] = [
    'id'        => $user['id'],
    'username'  => $user['username'],
    'full_name' => $user['full_name'],
    'role'      => $user['role']
];

echo json_encode([
    'success' => true,
    'user'    => $_SESSION['user']
]);
