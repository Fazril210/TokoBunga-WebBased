<?php
include_once("crud.php");

$pelanggan = array();

if (isset($_GET["id_pelanggan"])) {
    $id_pelanggan = $_GET["id_pelanggan"];
    $pelanggan = tampilPelangganById($id_pelanggan);

    if (!$pelanggan) {
        die("Pelanggan tidak ditemukan.");
    }
} else {
    die("ID Pelanggan tidak diberikan.");
}

if (isset($_POST["edit"])) {
    $id_pelanggan = $_POST["id_pelanggan"];
    $nama_pelanggan = $_POST["nama_pelanggan"];
    $email = $_POST["email"];
    $password= $_POST["password"];
    $alamat = $_POST["alamat"];
    $nomor_telepon = $_POST["nomor_telepon"];

    $data = array(
        'nama_pelanggan' => $nama_pelanggan,
        'email' => $email,
        'password' => $password,
        'alamat' => $alamat,
        'nomor_telepon' => $nomor_telepon
    );

    // Panggil fungsi editPelanggan
    editPelanggan($id_pelanggan, $data);

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
    <title>Edit Pelanggan</title>
</head>

<body>

    <h2>Edit Pelanggan</h2>

    <!-- Form Edit Pelanggan -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nama_pelanggan">Nama Pelanggan:</label>
        <input type="text" name="nama_pelanggan" value="<?= $pelanggan['nama_pelanggan'] ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= $pelanggan['email'] ?> "></input><br>

        <label for="password">Password:</label>
        <input type="password" name="password" value="<?= $pelanggan['password'] ?> "><br>

        <label for=" alamat">Alamat:</label>
        <input type="text" name="alamat" value="<?= $pelanggan['alamat'] ?>" required><br>

        <label for="nomor_telepon">Nomor Telepon:</label>
        <input type="text" name="nomor_telepon" value="<?= $pelanggan['nomor_telepon'] ?> "><br>

        <input type="hidden" name="id_pelanggan" value="<?= $pelanggan['id_pelanggan'] ?>">
        <button type="submit" name="edit">Edit Pelanggan</button>
    </form>

</body>

</html>