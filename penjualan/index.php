<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/pelanggan.css" type="text/css">
    <link rel="stylesheet" href="../assets/DataTables/datatables.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" type="text/css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../assets/DataTables/DataTables-1.13.8/js/jquery.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../assets/DataTables/datatables.min.js"></script>

    <title>CRUD Pemesanan</title>
</head>

<body>

    <?php
    include_once("crud.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["hapus"])) {
            $id_pesanan = $_POST["id_pesanan"];
            hapusPesanan($id_pesanan);
        } elseif (isset($_POST["edit"])) {
            $id_pesanan = $_POST["id_pesanan"];
            $status_pesanan = $_POST["status_pesanan"];
            editPesanan($id_pesanan, $_POST);
        }
    }
    ?>
    <div class="header">
        <a href="../admin/dashboard.php"><i class="fa-solid fa-arrow-left"></i></a>
        <h2>Data Pesanan</h2>
    </div>
    <a class="tambah" href="tambah.php"><i class="fas fa-plus-circle" style="margin-right: 5px;"></i>Tambah Pesanan</a>
    <a style='background-color: #e84393; color: white; 
    padding: 10px 20px; 
    text-decoration: none; 
    display: inline-block;
    font-size: 16px;
    margin-bottom: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 30px;' onClick='cetak()'><i class="fas fa-print" style="margin-right: 5px;"></i>Cetak Data</a>
    <!-- Tabel Tampil Pesanan -->
    <table id="example" style="background-color: #FFC0CB;  
                               border-radius: 3px;
                               box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                               overflow: hidden; " border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Id Pesanan</th>
                <th>Id Pelanggan</th>
                <th>Tanggal Pesanan</th>
                <th>Status Pesanan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../koneksi.php';
            $query = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY id_pesanan ASC");
            $no = 1;

            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $row['id_pesanan']; ?></td>
                <td><?php echo $row['id_pelanggan']; ?></td>
                <td><?php echo $row['tanggal_pesanan']; ?></td>
                <td><?php echo $row['status_pesanan']; ?></td>
                <td><?php echo 'Rp. ' . number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td>
                    <form action='' method='post' onsubmit='return konfirmasiHapus()'>
                        <input type='hidden' name='id_pesanan' value='<?php echo $row['id_pesanan']; ?>'>
                        <a class='edit' href='edit.php?id_pesanan=<?php echo $row['id_pesanan']; ?>' name='edit'><i
                                class="fas fa-edit" style="margin-right: 5px;"></i>Edit</a>
                        <button class='hapus' type='submit' name='hapus'><i class="fas fa-trash-alt"
                                style="margin-right: 5px;"></i>Hapus</button>
                    </form>
                </td>
            </tr>
            <?php
                $no++;  // Tingkatkan nilai $no untuk nomor urut berikutnya
            }
            ?>
        </tbody>
    </table>
    <script>
    function konfirmasiHapus() {
        var konfirmasi = confirm("Apakah Anda yakin ingin menghapus pesanan?");
        return konfirmasi;
    }

    function cetak() {
        window.print();
    }

    $(document).ready(function() {
        $('#example').DataTable();
    });
    </script>

</body>

</html>