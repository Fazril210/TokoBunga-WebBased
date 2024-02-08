<?php
include '../koneksi.php';

$id_pesanan = $_GET['id_pesanan'];

$query_order_details = "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan'";
$result_order_details = mysqli_query($koneksi, $query_order_details);
$orderDetails = mysqli_fetch_assoc($result_order_details);

if (!$orderDetails) {
    echo "Pesanan tidak ditemukan.";
    exit();
}

?>

<!-- Kode HTML selanjutnya seperti pada contoh sebelumnya -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Midtrans</title>
    <!-- Tambahkan stylesheet atau script lain yang diperlukan untuk halaman ini -->
</head>

<body>
    <h2>Detail Pesanan</h2>
    <p>Nomor Pesanan: <?php echo $orderDetails['id_pesanan']; ?></p>
    <p>Tanggal Pesanan: <?php echo $orderDetails['tanggal_pesanan']; ?></p>

    <h2>Detail Produk</h2>
    <?php
$query_order_items = "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan'";
$result_order_items = mysqli_query($koneksi, $query_order_items);

if ($result_order_items) {
    while ($orderItem = mysqli_fetch_assoc($result_order_items)) {
        $nama_produk = isset($orderItem['nama_produk']) ? $orderItem['nama_produk'] : 'Nama Produk Tidak Tersedia';
        $harga_produk = isset($orderItem['harga']) ? number_format($orderItem['harga_produk'], 0, ',', '.') : 'Harga Produk Tidak Tersedia';

        echo "<p>" . $nama_produk . " " . $harga_produk . "</p>";
    }
} else {
    echo "Gagal mengambil detail produk.";
}
?>


    <h2>Total Harga</h2>
    <p>Rp. <?php echo number_format($orderDetails['total_harga'], 0, ',', '.'); ?></p>

    <!-- Tambahkan elemen-elemen lain yang diperlukan untuk halaman ini -->

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-4ScSPDQAgX-nF6HS">
    </script>
    <script>
    function initiatePayment() {
        const orderId = '<?php echo $orderDetails['id_pesanan']; ?>';
        const totalPrice = '<?php echo $orderDetails['total_harga']; ?>';

        const snap = Snap({
            clientKey: 'SB-Mid-client-4ScSPDQAgX-nF6HS',
            environment: 'sandbox',
        });

        const paymentOptions = {
            transaction_details: {
                order_id: orderId,
                gross_amount: totalPrice,
            },
            // Tambahkan opsi pembayaran sesuai kebutuhan
        };

        snap.pay(paymentOptions);
    }
    </script>
</body>

</html>