<?php
session_start();

include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    // Pengecualian untuk admin1 atau admin2
    if (($email === 'admin1@gmail.com' && $password === '12345') || ($email === 'admin2@gmail.com' && $password === '67890')) {
        // Redirect ke halaman dashboard_admin.php di folder admin
        header("Location: ../admin/dashboard.php");
        exit();
    }

    // Query untuk mendapatkan data user berdasarkan email
    $sql = "SELECT * FROM pelanggan WHERE email=?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query error: " . mysqli_error($koneksi));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Memeriksa kecocokan password
        if (password_verify($password, $row['password'])) {
            // Jika password cocok, buat sesi login
            $_SESSION['email'] = $row['email'];
            $_SESSION['customer_name'] = $row['nama_pelanggan'];
            $_SESSION['status'] = "login";

            // Pengecualian untuk admin1 atau admin2
            if ($email === 'admin1@gmail.com' || $email === 'admin2@gmail.com') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            $error_message = "Email atau password Anda salah. Silakan coba lagi!";
        }
    } else {
        $error_message = "Email atau password Anda salah. Silakan coba lagi!";
    }
}

// Pengecekan pesan sukses atau pesan error
if (isset($_SESSION['message'])) {
    echo '<div class="custom-alert success">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
} elseif (isset($_SESSION['error'])) {
    echo '<div class="custom-alert warning">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']); // Hapus pesan setelah ditampilkan
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login User</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/css/login.css">
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div> <?php if (isset($error_message)): ?>
    <div class="login_gagal"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <h3><a href="../index.php"><i class="fas fa-arrow-left"></i></a> Halaman Login</h3>
        <hr>
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Masukkan email" id="email">

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Masukkan kata sandi" id="password">

        <button type="submit" name="submit">Masuk</button>
        <div class="social">
            <p>Anda tidak memiliki akun?<a href="../icons/register.php">
                    <h4> Daftar</h4>
                </a>
            </p>
        </div>
    </form>
</body>

</html>