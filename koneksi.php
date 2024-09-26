<?php
class Database
{
   private $host = "localhost";
   private $db_name = "koneksi_db";
   private $username = "root";
   private $password = "";
   private $conn;

   // Membuat koneksi ke database
   public function connect()
   {
      $this->conn = null;

      try {
         $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
         $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Menangani error
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mengatur fetch mode ke associative array
            PDO::ATTR_EMULATE_PREPARES   => false, // Mencegah emulasi prepared statements
         ];
         $this->conn = new PDO($dsn, $this->username, $this->password, $options);
      } catch (PDOException $e) {
         // Tangani error
         echo "Koneksi gagal: " . $e->getMessage();
      }

      return $this->conn;
   }
}
