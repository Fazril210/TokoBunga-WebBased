<?php
include_once("crud.php");

$produk = array();

if (isset($_GET["id_pesanan"])) {
    $id_pesanan = $_GET["id_pesanan"];
    $pesanan = tampilPesananById($id_pesanan);

    if (!$pesanan) {
        die("Pesanan tidak ditemukan.");
    }
} else {
    die("ID Pesanan tidak diberikan.");
}

if (isset($_POST["edit"])) {
    $id_pesanan = $_POST["id_pesanan"];
    $id_pelanggan = $_POST["id_pelanggan"];
    $tanggal_pesanan = $_POST["tanggal_pesanan"];
    $status_pesanan = $_POST["status_pesanan"];
    $total_harga = $_POST["total_harga"];

    $data = array(
        'id_pesanan' => $id_pesanan,
        'id_pelanggan' => $id_pelanggan,
        'tanggal_pesanan' => $tanggal_pesanan,
        'status_pesanan' => $status_pesanan,
        'total_harga' => $total_harga
    );

    // Panggil fungsi editProduk
    editPesanan($id_pesanan, $data);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <title>Edit Pesanan</title>
</head>

<body>
    <a href="index.php"><i class="fa-solid fa-arrow-left"></i></a>
    <h2>Edit Pesanan</h2>

    <!-- Form Edit Produk -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="id_pesanan">Id Pesanan:</label>
        <input type="text" name="id_pesanan" value="<?= $pesanan['id_pesanan'] ?>" required><br>

        <label for="id_pelanggan">Id Pelanggan:</label>
        <input type="text" name="id_pelanggan" value="<?= $pesanan['id_pelanggan'] ?>" required></input><br>

        <label for="tanggal_pesanan">Tanggal Pesanan:</label>
        <input type="date" name="tanggal_pesanan" value="<?= $pesanan['tanggal_pesanan'] ?>" required><br><br>

        <label for="status_pesanan">Status Pesanan:</label>
        <select name="status_pesanan" required>
            <option value="Belum Lunas" <?= ($pesanan['status_pesanan'] == 'Belum Lunas') ? 'selected' : ''; ?>>Belum
                Lunas</option>
            <option value="Sudah Lunas" <?= ($pesanan['status_pesanan'] == 'Sudah Lunas') ? 'selected' : ''; ?>>Sudah
                Lunas</option>
        </select><br><br>


        <label for="total_harga">Total Harga:</label>
        <input type="number" name="total_harga" value="<?= $pesanan['total_harga'] ?>"><br>

        <input type="hidden" name="id_pesanan" value="<?= $pesanan['id_pesanan'] ?>">
        <button type="submit" name="edit">Edit Pesanan</button>
    </form>

</body>

</html>