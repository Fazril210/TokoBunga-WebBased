<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/produk_tambah.css" rel="stylesheet">
    <title>Tambah Pelanggan</title>
</head>

<body>

    <?php
    include_once("crud.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["tambah"])) {
            tambahPelanggan($_POST);

            header("Location: index.php");
            exit();
        }
    }
    ?>

    <h2>Tambah Pelanggan</h2>

    <!-- Form Tambah Pelanggan -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nama_pelanggan">Nama Pelanggan:</label>
        <input type="text" name="nama_pelanggan" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="alamat">Alamat:</label>
        <textarea name="alamat" required></textarea><br>

        <label for="nomor_telepon">Nomor Telepon:</label>
        <input type="text" name="nomor_telepon" required><br>

        <button type="submit" name="tambah">Tambah Pelanggan</button>
    </form>
</body>

</html>