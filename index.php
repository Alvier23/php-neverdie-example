<?php
// Inisiasi class Database dan koneksi
$database = new Database();
$db = $database->connect();

// Contoh query menggunakan prepared statements
$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $db->prepare($sql);
$stmt->execute(['email' => 'email@example.com']);
$result = $stmt->fetch();

print_r($result);
