<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/produk_tambah.css" rel="stylesheet">
    <title>Tambah Produk</title>
</head>

<body>

    <?php
    include_once("crud.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["tambah"])) {
            tambahProduk($_POST);

            header("Location: index.php");
            exit();
        }
    }
    ?>

    <h2>Tambah Produk</h2>

    <!-- Form Tambah Produk -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nama_produk">Nama Produk:</label>
        <input type="text" name="nama_produk" required><br>

        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" required></textarea><br>

        <label for="harga">Harga:</label>
        <input type="number" name="harga" required><br>

        <label for="stok">Stok:</label>
        <input type="number" name="stok" required><br>

        <label for="gambar_produk">Gambar Produk:</label>
        <input type="file" name="gambar_produk" required><br>

        <button type="submit" name="tambah">Tambah Produk</button>
    </form>

</body>

</html>