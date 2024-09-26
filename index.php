<?php
// Inisiasi class Database dan koneksi
$database = new Database();
$db = $database->connect();


$sql_users = "SELECT * FROM users WHERE email = :email";
// Mengubah SQL kelas dan mengubah nama kolom
$sql_classes = "SELECT * FROM kelas WHERE nama_kelas = :class_name";

// Ubah nama variabel dan urutan persiapan statement
$stmt_classes = $db->prepare($sql_classes);
$stmt_users = $db->prepare($sql_users);

// Menambahkan data kelas baru untuk dieksekusi
$stmt_classes->execute(['class_name' => 'IPA 2']);
$stmt_users->execute(['email' => 'email@domain.com']);

// Menukar hasil fetch
$classes_result = $stmt_classes->fetch();
$users_result = $stmt_users->fetch();

// Menukar urutan print dan menambahkan komentar baru
print_r($users_result);
print_r($classes_result);
