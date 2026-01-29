<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost","root","root","db_laundry");

if ($_SERVER['REQUEST_METHOD']==='GET') {
  $q = $conn->query("SELECT * FROM laundry_transactions");
  echo json_encode($q->fetch_all(MYSQLI_ASSOC));
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $id = $_POST['transaction_id'];
  $conn->query("UPDATE laundry_transactions SET status='done' WHERE id=$id");
  echo json_encode(['success'=>true]);
}?>
