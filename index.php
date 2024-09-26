<?php
// Inisiasi class Database dan koneksi
$database = new Database();
$db = $database->connect();

try {
   // Mulai transaksi
   $db->beginTransaction();

   // SQL Query untuk users dan kelas
   $sql_users = "SELECT * FROM users WHERE email = :email";
   $sql_classes = "SELECT * FROM kelas WHERE nama_kelas = :class_name";

   // Siapkan statement SQL untuk users dan kelas
   $stmt_users = $db->prepare($sql_users);
   $stmt_classes = $db->prepare($sql_classes);

   // Eksekusi statement kelas dengan nama kelas baru
   $stmt_classes->execute(['class_name' => 'IPA 2']);
   $stmt_users->execute(['email' => 'email@domain.com']);

   // Ambil hasil query
   $classes_result = $stmt_classes->fetch(PDO::FETCH_ASSOC);
   $users_result = $stmt_users->fetch(PDO::FETCH_ASSOC);

   // Cek jika hasil query users tidak ditemukan
   if (!$users_result) {
      throw new Exception("User dengan email tersebut tidak ditemukan.");
   }

   // Cek jika kelas tidak ditemukan
   if (!$classes_result) {
      throw new Exception("Kelas dengan nama tersebut tidak ada.");
   }

   // Ambil nama lengkap pengguna dan kelas yang diambil
   $user_fullname = $users_result['nama_lengkap'] ?? 'Nama tidak diketahui';
   $kelas_name = $classes_result['nama_kelas'] ?? 'Kelas tidak ada';

   // Coba insert ke enrollment, ini akan menimbulkan konflik jika sudah ada entri yang sama
   $sql_enroll = "INSERT INTO enrollment (user_id, class_id, tanggal_daftar) VALUES (:user_id, :class_id, NOW())";

   // Simulasi konflik: Duplicate entry (Kita asumsikan user_id dan class_id harus unik di tabel enrollment)
   $stmt_enroll = $db->prepare($sql_enroll);
   $stmt_enroll->execute([
      'user_id' => $users_result['id'],
      'class_id' => $classes_result['id']
   ]);

   // Commit transaksi
   $db->commit();

   echo "User {$user_fullname} berhasil didaftarkan ke kelas {$kelas_name}.<br>";
} catch (PDOException $e) {
   // Rollback transaksi jika terjadi kesalahan
   $db->rollBack();

   // Pengecekan konflik
   if ($e->errorInfo[1] == 1062) {  // Error code 1062 untuk Duplicate entry
      echo "Terjadi konflik: User {$user_fullname} sudah terdaftar di kelas {$kelas_name}.<br>";
   } else {
      // Error umum lainnya
      echo "Terjadi kesalahan: " . $e->getMessage();
   }
}

// Cetak hasil user dan kelas untuk verifikasi tambahan
echo "<pre>";
echo "Data User: ";
print_r($users_result);
echo "Data Kelas: ";
print_r($classes_result);
echo "</pre>";

// Tambahan: Lakukan query untuk menampilkan seluruh user di kelas tersebut
$sql_all_users_in_class = "
    SELECT u.nama_lengkap 
    FROM users u 
    JOIN enrollment e ON u.id = e.user_id 
    WHERE e.class_id = :class_id";

$stmt_all_users = $db->prepare($sql_all_users_in_class);
$stmt_all_users->execute(['class_id' => $classes_result['id']]);
$all_users = $stmt_all_users->fetchAll(PDO::FETCH_ASSOC);

// Loop untuk mencetak semua user yang terdaftar di kelas
if ($all_users) {
   echo "<h3>Daftar User di Kelas {$kelas_name}:</h3>";
   foreach ($all_users as $user) {
      echo "- " . $user['nama_lengkap'] . "<br>";
   }
} else {
   echo "Tidak ada user terdaftar di kelas {$kelas_name}.<br>";
}
