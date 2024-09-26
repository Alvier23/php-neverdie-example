<?php
// Inisiasi class Database dan koneksi
$database = new Database();
$db = $database->connect();


$sql_users = "SELECT * FROM users WHERE email = :email";
$sql_classes = "SELECT * FROM kelas WHERE nama_kelas = :nama_kelas";

// Ubah nama variabel
$stmt_users = $db->prepare($sql_users);
$stmt_classes = $db->prepare($sql_classes);

$stmt_users->execute(['email' => 'email@example.com']);
$stmt_classes->execute(['nama_kelas' => 'MIPA 1']);

$users_result = $stmt_users->fetch();
$classes_result = $stmt_classes->fetch();

// Ubah urutan print
print_r($classes_result);
print_r($users_result);
