<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

    <nav>
        <img src="../assets/images/logo_tokobunga.png" width="250px" height="100px">
        <a href="#"><i class="fa-solid fa-house-user"></i> Dashboard</a>
        <a href="../pelanggan/"><i class="fa-solid fa-users"></i> Pelanggan</a>
        <a href="../penjualan/"><i class="fa-solid fa-cart-shopping"></i> Pesanan</a>
        <a href="../produk/"><i class="fa-solid fa-shop"></i> Produk</a>
        <a href="#" onclick="confirmLogout();"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>

        <script>
        function confirmLogout() {
            var confirmation = confirm("Apakah Anda yakin ingin logout?");
            if (confirmation) {
                window.location.href = 'logout.php';
            }
        }
        </script>

    </nav>

    <div class="title">
        <h1>Selamat Datang di<br><span>Dashboard Admin</span></br></h1>
        <!-- Konten admin dashboard akan ditampilkan di sini -->
    </div>

    <?php include "../koneksi.php"; ?>

    <!--  Row 1 -->
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3">
                    <!-- Pelanggan -->
                    <div class="custom-card-pelanggan">
                        <a href="../pelanggan/" class="custom-link">
                            <div class="custom-card-body-pelanggan">
                                <div class="custom-content-pelanggan">
                                    <?php
                                    $countmember = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pelanggan");
                                    $membercount = mysqli_fetch_assoc($countmember);
                                    ?>
                                    <h5 class="custom-card-title">Total Pelanggan</h5>
                                    <h4 class="custom-card-value"><?= $membercount['total'] ?></h4>
                                </div>
                                <div class="custom-icon-pelanggan">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <!-- Produk -->
                    <div class="custom-card-produk">
                        <a href="../produk/" class="custom-link">
                            <div class="custom-card-body-produk">
                                <div class="custom-content-produk">
                                    <?php
                                    $countmember = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk");
                                    $membercount = mysqli_fetch_assoc($countmember);
                                    ?>
                                    <h5 class="custom-card-title">Total Produk</h5>
                                    <h4 class="custom-card-value"><?= $membercount['total'] ?></h4>
                                </div>
                                <div class="custom-icon-produk">
                                    <i class="fa-solid fa-shop"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <!-- Produk -->
                    <div class="custom-card-pesanan">
                        <a href="../penjualan/" class="custom-link">
                            <div class="custom-card-body-pesanan">
                                <div class="custom-content-pesanan">
                                    <?php
                                    $countmember = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pesanan");
                                    $membercount = mysqli_fetch_assoc($countmember);
                                    ?>
                                    <h5 class="custom-card-title">Total Pesanan</h5>
                                    <h4 class="custom-card-value"><?= $membercount['total'] ?></h4>
                                </div>
                                <div class="custom-icon-pesanan">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <h4>Kritik dan Saran Pelanggan</h4>
    <table id="example" style="top: 100px;">

        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Pelanggan</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Pesan</th>

            </tr>
        </thead>
        <tbody>
            <?php
            include '../koneksi.php';
            $query = mysqli_query($koneksi, "SELECT * FROM kontak ORDER BY nama ASC");
            $no = 1;

            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['nomor_telepon']; ?></td>
                <td><?php echo $row['pesan']; ?></td>
            </tr>
            <?php
                $no++;  // Tingkatkan nilai $no untuk nomor urut berikutnya
            }
            ?>

        </tbody>
    </table>