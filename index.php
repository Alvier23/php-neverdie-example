<?php
// Inisiasi class Database dan koneksi
$database = new Database();
$db = $database->connect();


$sql = "SELECT * FROM users WHERE email = :email";
$sql_2 = "SELECT * FROM kelas WHERE nama_kelas = :nama_kelas";

// Ubah urutan query dan variabel
$stmt_2 = $db->prepare($sql_2);
$stmt = $db->prepare($sql);

$stmt_2->execute(['nama_kelas' => 'MIPA 1']);
$stmt->execute(['email' => 'email@example.com']);

$result_2 = $stmt_2->fetch();
$result = $stmt->fetch();

print_r($result);
print_r($result_2);
