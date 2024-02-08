<?php
session_start();
include '../koneksi.php';

$tgl_hari_ini = date('Y-m-d');

$cartIsEmpty = empty($_SESSION['cart']);
$checkoutSuccess = false;
$orderDetails = [];

if (isset($_POST['checkout']) && isset($_SESSION['cart']) && !$cartIsEmpty) {
    $id_pelanggan = 1;

    $total_harga = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $_SESSION['cart']));

    $query_insert_pesanan = "INSERT INTO pesanan (tanggal_pesanan, id_pelanggan, total_harga) VALUES ('$tgl_hari_ini', '$id_pelanggan', '$total_harga')";
    mysqli_query($koneksi, $query_insert_pesanan);

    $id_pesanan = mysqli_insert_id($koneksi);

    foreach ($_SESSION['cart'] as $item) {
        $id_produk = $item['id'];
        $jumlah_produk = $item['quantity'];
        $subtotal = $item['price'] * $jumlah_produk;

        $query_insert_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, subtotal) VALUES ('$id_pesanan', '$id_produk', '$jumlah_produk', '$subtotal')";
        mysqli_query($koneksi, $query_insert_detail);

        $query_update_stok = "UPDATE produk SET stok = stok - '$jumlah_produk' WHERE id_produk = '$id_produk'";
        mysqli_query($koneksi, $query_update_stok);
    }

    unset($_SESSION['cart']);

    // Retrieve the order details for display
    $query_order_details = "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan'";
    $result_order_details = mysqli_query($koneksi, $query_order_details);
    $orderDetails = mysqli_fetch_assoc($result_order_details);

    $checkoutSuccess = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/checkout.css">
    <title>Checkout</title>
</head>

<body>
    <section class="cart-section">
        <?php if (!$checkoutSuccess) { ?>
        <!-- Display the cart content and checkout button if not yet checked out -->
        <?php if (!empty($_SESSION['cart'])) { ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item) { ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $tgl_hari_ini; ?></td>
                    <td>Rp. <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>Rp. <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <p>Total: Rp. <?php echo number_format(array_sum(array_map(function ($item) {
                                    return $item['price'] * $item['quantity'];
                                }, $_SESSION['cart'])), 0, ',', '.'); ?></p>
        <form method="post" action="">
            <button type="submit" name="checkout">Checkout</button>
        </form>
        <?php } else { ?>
        <?php } ?>
        <?php } else { ?>
        <!-- Display the success message and order details -->
        <div class="logo">
            <img src="../assets/images/logo_tokobunga.png" alt="Logo">
        </div>
        <div class="alamat">
            <p>Jl. Raya Siliwangi No.6, RT.001/RW.004, Sepanjang Jaya, Kec. Rawalumbu, Kota Bks, Jawa Barat 17114</p>
        </div>
        <div class="invoice">
            <table>
                <tr>
                    <td>Nomor Pesanan</td>
                    <td>:</td>
                    <td><?php echo $orderDetails['id_pesanan']; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Pesanan</td>
                    <td>:</td>
                    <td><?php echo $orderDetails['tanggal_pesanan']; ?></td>
                </tr>
                <tr>
                    <td>Total Pesanan</td>
                    <td>:</td>
                    <td><?php echo $item['quantity']; ?></td>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td>:</td>
                    <td>Rp. <?php echo number_format($orderDetails['total_harga'], 0, ',', '.'); ?></td>
                </tr>
            </table>
            <br>
            <p>Checkout berhasil. Terima kasih atas pesanannya!</p>
        </div>

        <button class="btncetak" onclick="printReceipt()">Cetak Struk</button>
        <?php } ?>

    </section>

    <script>
    function printReceipt() {
        window.print();
    }
    </script>

</body>

</html>