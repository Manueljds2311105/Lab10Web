<?php
/**
 * File konfigurasi aplikasi
 */

// Konfigurasi Database - Gunakan define agar bisa diakses global
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'latihan1');

// Untuk backward compatibility, tetap sediakan array $config
$config = array(
    'host' => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PASS,
    'db_name' => DB_NAME
);

// Konfigurasi Path
define('BASE_URL', 'http://localhost/lab10_php_oop/');
define('BASE_PATH', __DIR__ . '/');

// Konfigurasi Upload
define('UPLOAD_PATH', BASE_PATH . 'gambar/');
define('MAX_FILE_SIZE', 2097152); // 2MB dalam bytes
define('ALLOWED_EXTENSIONS', array('jpg', 'jpeg', 'png', 'gif'));

?>