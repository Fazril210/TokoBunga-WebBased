<?php
session_start();
include '../koneksi.php';

// Dapatkan data user dari form register
$user = [
    'email' => $_POST['email'],
    'nama_pelanggan' => $_POST['nama_pelanggan'],
    'password' => $_POST['password'],
    'password_konfirmasi' => $_POST['password_konfirmasi'],
    'alamat' => $_POST['alamat'],
    'nomor_telepon' => $_POST['nomor_telepon'],
];

// Validasi jika password & password_confirmation sama
if ($user['password'] != $user['password_konfirmasi']) {
    $_SESSION['error'] = 'Password yang Anda masukkan tidak sama dengan password konfirmasi.';
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['nama_pelanggan'] = $_POST['nama_pelanggan'];
    header("Location: register.php");
    exit();
}

// Check apakah user dengan email tersebut ada di tabel pelanggan
$query = "SELECT * FROM pelanggan WHERE email = ? LIMIT 1";
$stmt = $koneksi->stmt_init();
$stmt->prepare($query);
$stmt->bind_param('s', $user['email']);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

$row = $result->fetch_array(MYSQLI_ASSOC);

// Jika email sudah ada, kembali ke halaman register
if ($row != null) {
    $_SESSION['error'] = 'Email: ' . $user['email'] . ' yang Anda masukkan sudah ada di database.';
    $_SESSION['nama_pelanggan'] = $_POST['nama_pelanggan'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['password_konfirmasi'] = $_POST['password_konfirmasi'];
    header("Location: register.php");
    exit();
} elseif (strlen($user['password']) < 5) {
    $_SESSION['error'] = 'Panjang password minimal harus 5 karakter.';
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['nama_pelanggan'] = $_POST['nama_pelanggan'];
    header("Location: register.php");
    exit();
} else {
    // Hash password
    $password = password_hash($user['password'], PASSWORD_DEFAULT);

    // Email unik. Simpan di tabel pelanggan.
    $query = "INSERT INTO pelanggan (email, nama_pelanggan, password, alamat, nomor_telepon) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->stmt_init();
    $stmt->prepare($query);
    $stmt->bind_param('sssss', $user['email'], $user['nama_pelanggan'], $password, $user['alamat'], $user['nomor_telepon']);
    $stmt->execute();

    if (!$stmt) {
        die("Query error: " . mysqli_error($koneksi));
    }

    $_SESSION['message']  = 'Berhasil register ke dalam sistem. Silakan login dengan email dan password yang sudah dibuat.';
    header("Location: login.php");
    exit();

    session_destroy();
}
?>