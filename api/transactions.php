<?php
session_start();
header('Content-Type: application/json');
$conn = new mysqli("localhost","root","root","db_laundry");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $q = $conn->query("SELECT * FROM laundry_transactions ORDER BY id DESC");
  echo json_encode($q->fetch_all(MYSQLI_ASSOC));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $conn->prepare(
    "INSERT INTO laundry_transactions 
    (customer_name, customer_phone, weight, price, created_by)
    VALUES (?,?,?,?,?)"
  );
  $stmt->bind_param(
    "ssddi",
    $_POST['customer_name'],
    $_POST['customer_phone'],
    $_POST['weight'],
    $_POST['price'],
    $_SESSION['user']['id']
  );
  $stmt->execute();
  echo json_encode(['success'=>true]);
}
