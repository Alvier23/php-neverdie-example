<?php
// Inisiasi class Database dan koneksi
$database = new Database();
$db = $database->connect();


$sql = "SELECT * FROM users WHERE email = :email";
$sql_2 = "SELECT * FROM kelas WHERE nama_kelas = :nama_kelas";
$stmt = $db->prepare($sql);
$stmt_2 = $db->prepare($sql_2);

$stmt->execute(['email' => 'email@example.com']);

$stmt_2->execute(['nama_kelas' => 'XII 1']);
$result = $stmt->fetch();
$result_2 = $stmt_2->fetch();


print_r($result_2);
print_r($result);
