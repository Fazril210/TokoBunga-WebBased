<?php
include_once("crud.php");

$produk = array();

if (isset($_GET["id_produk"])) {
    $id_produk = $_GET["id_produk"];
    $produk = tampilProdukById($id_produk);

    if (!$produk) {
        die("Produk tidak ditemukan.");
    }
} else {
    die("ID Produk tidak diberikan.");
}

if (isset($_POST["edit"])) {
    $id_produk = $_POST["id_produk"];
    $nama_produk = $_POST["nama_produk"];
    $deskripsi = $_POST["deskripsi"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];

    $data = array(
        'nama_produk' => $nama_produk,
        'deskripsi' => $deskripsi,
        'harga' => $harga,
        'stok' => $stok
    );

    // Panggil fungsi editProduk
    editProduk($id_produk, $data);

    // Redirect atau sesuaikan dengan kebutuhan Anda
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/edit_produk.css">
    <title>Edit Produk</title>
</head>

<body>

    <h2>Edit Produk</h2>

    <!-- Form Edit Produk -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nama_produk">Nama Produk:</label>
        <input type="text" name="nama_produk" value="<?= $produk['nama_produk'] ?>" required><br>

        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" required><?= $produk['deskripsi'] ?></textarea><br>

        <label for="harga">Harga:</label>
        <input type="number" name="harga" value="<?= $produk['harga'] ?>" required><br>

        <label for="stok">Stok:</label>
        <input type="number" name="stok" value="<?= $produk['stok'] ?>" required><br>

        <label for="gambar_produk">Gambar Produk:</label>
        <input type="file" name="gambar_produk"><br>

        <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
        <button type="submit" name="edit">Edit Produk</button>
    </form>

</body>

</html>