<?php
session_start();
require 'koneksi.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error'=>'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    if ($_SESSION['user']['role'] !== 'Admin') {
        http_response_code(403);
        echo json_encode(['error'=>'Forbidden']);
        exit;
    }

    $result = $conn->query("SELECT id, username, full_name, role, phone FROM users");
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);
    exit;
}


if ($method === 'POST') {

    if ($_SESSION['user']['role'] !== 'Admin') {
        http_response_code(403);
        echo json_encode(['error'=>'Forbidden']);
        exit;
    }

    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role     = $_POST['role'];
    $phone    = trim($_POST['phone']);

    if (!$username || !$password || !$full_name) {
        echo json_encode(['error'=>'Data tidak lengkap']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['error'=>'Username sudah ada']);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users(username,full_name,password,role,phone) VALUES(?,?,?,?,?)");
    if (!$stmt) {
        echo json_encode(['error'=>'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("sssss",$username,$full_name,$hash,$role,$phone);
    if (!$stmt->execute()) {
        echo json_encode(['error'=>'Execute failed: ' . $stmt->error]);
        exit;
    }

    echo json_encode(['success'=>'User ditambahkan']);
    exit;
}


if ($method === 'PUT') {
    if ($_SESSION['user']['role'] !== 'Admin') {
        http_response_code(403); exit;
    }

    $id = $_GET['id'];
    parse_str(file_get_contents("php://input"), $_PUT);

    if (!empty($_PUT['password'])) {
        $hash = password_hash($_PUT['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username=?, full_name=?, role=?, phone=?, password=? WHERE id=?");
        $stmt->bind_param("sssssi", $_PUT['username'], $_PUT['full_name'], $_PUT['role'], $_PUT['phone'], $hash, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username=?, full_name=?, role=?, phone=? WHERE id=?");
        $stmt->bind_param("ssssi", $_PUT['username'], $_PUT['full_name'], $_PUT['role'], $_PUT['phone'], $id);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Data user berhasil diperbarui']);
    } else {
        echo json_encode(['error' => 'Gagal memperbarui data']);
    }
    exit;
}


if ($method === 'DELETE') {
    if ($_SESSION['user']['role'] !== 'Admin') {
        http_response_code(403);
        echo json_encode(['error'=>'Forbidden']);
        exit;
    }

    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo json_encode(['error'=>'ID tidak ditemukan']);
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success'=>'User dihapus']);
    } else {
        echo json_encode(['error'=>'Gagal hapus user']);
    }
    exit;
}
