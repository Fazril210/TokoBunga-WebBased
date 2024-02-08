<?php
session_start();
include '../koneksi.php';

// Fetch product data from the database
$dataProduk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama_produk ASC");

// Initialize cart in the session if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the product is added to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = isset($_POST['id_produk']) ? $_POST['id_produk'] : '';
    $quantity = 1; // Set default quantity to 1

    // Get product details from the database
    $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$product_id'");
    $product = mysqli_fetch_assoc($query);

    if ($product && $product['stok'] >= $quantity) {
        // Add product to the cart session
        $cart_item = [
            'id' => $product['id_produk'],
            'name' => $product['nama_produk'],
            'price' => $product['harga'],
            'quantity' => $quantity,
            'stok' => $product['stok'],
        ];

        $_SESSION['cart'][] = $cart_item;

        // Decrease stock in the database
        $updated_stok = $product['stok'] - $quantity;
        mysqli_query($koneksi, "UPDATE produk SET stok = '$updated_stok' WHERE id_produk = '$product_id'");
    }
}

// Update quantity in the cart
if (isset($_POST['update_cart'])) {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['stok'] = isset($item['stok']) ? $item['stok'] : 0;

            // Check if there is sufficient stock to update
            $updated_stok = $item['stok'] + $item['quantity'] - $quantity;
            if ($updated_stok >= 0) {
                mysqli_query($koneksi, "UPDATE produk SET stok = '$updated_stok' WHERE id_produk = '$product_id'");
                $item['quantity'] = $quantity;
            }
            break;
        }
    }

    // Redirect to checkout page after updating the cart
    header("Location: cart.php");
    exit();
}


// Remove item from the cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            // Return stock to the database
            $removed_quantity = $item['quantity'];
            $product_id = $item['id'];
            $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$product_id'");
            $product = mysqli_fetch_assoc($query);

            $updated_stok = $product['stok'] + $removed_quantity;
            mysqli_query($koneksi, "UPDATE produk SET stok = '$updated_stok' WHERE id_produk = '$product_id'");

            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your Flower Shop</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
</head>

<body>
    <div class="header">
        <a href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>
    </div>
    <!-- Inside the product section -->
    <section class="products" id="products">
        <h1 class="heading">Daftar Produk <span>dan Keranjang</span></h1>

        <div class="box-container">
            <?php while ($row = mysqli_fetch_assoc($dataProduk)) { ?>
            <div class="box">
                <form method="post" action="">
                    <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>" />
                    <input type="hidden" name="stok" value="<?php echo $row['stok']; ?>" />
                    <div class="image">
                        <img src="<?php echo $row['gambar_produk']; ?>" alt="" />
                        <div class="icons">
                            <button type="submit" name="add_to_cart" class="cart-btn">Pesan</button>
                        </div>
                    </div>
                    <div class="content">
                        <h3><?php echo $row['nama_produk']; ?></h3>
                        <div class="price">Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></div>
                        <div class="stok">Stok: <?php echo $row['stok'] ?></div>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </section>


    <!-- Display the cart -->
    <section class="cart-section">
        <h2>Your Cart</h2>
        <?php if (!empty($_SESSION['cart'])) { ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item) { ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>Rp. <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>" />
                            <input type="hidden" name="stok" value="<?php echo $item['stok']; ?>" />
                            <input type="hidden" name="update_cart" />
                            <div class="quantity-container">
                                <button type="button" class="quantity-btn"
                                    onclick="decrementQuantity(<?php echo $item['id']; ?>)">-</button>
                                <input type="number" name="quantity" id="quantity_<?php echo $item['id']; ?>"
                                    value="<?php echo $item['quantity']; ?>" min="1"
                                    onchange="updateTotal(<?php echo $item['id']; ?>)"
                                    data-product-id="<?php echo $item['id']; ?>"
                                    style="max-width: 50px; width: 100%;" />

                                <button type="button" class="quantity-btn"
                                    onclick="incrementQuantity(<?php echo $item['id']; ?>)">+</button>
                            </div>
                        </form>

                    </td>
                    <td>Rp. <span
                            id="total_<?php echo $item['id']; ?>"><?php echo number_format(intval($item['price']) * intval($item['quantity']), 0, ',', '.'); ?></span>
                    </td>
                    <td>
                        <a href="?remove=<?php echo $item['id']; ?>">Remove</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <p>Total: Rp. <span id="cartTotal"><?php echo number_format(array_sum(array_map(function ($item) {
                return intval($item['price']) * intval($item['quantity']);
            }, $_SESSION['cart'])), 0, ',', '.'); ?></span></p>
        <a href="checkout.php">Checkout</a>
        <?php } else { ?>
        <p>Your cart is empty</p>
        <?php } ?>
    </section>

    <script>
    function updateTotal(productId) {
        var quantityInput = document.getElementById('quantity_' + productId);
        var totalSpan = document.getElementById('total_' + productId);
        var price = <?php echo $item['price']; ?>;
        var quantity = parseInt(quantityInput.value);


        if (quantity !== parseInt(quantityInput.getAttribute('data-previous-quantity'))) {
            var total = price * quantity;
            totalSpan.innerHTML = total.toLocaleString();

            quantityInput.setAttribute('data-previous-quantity', quantity);

            recalculateCartTotal();
        }
    }


    function incrementQuantity(productId) {
        var quantityInput = document.getElementById('quantity_' + productId);
        quantityInput.value = parseInt(quantityInput.value) + 1;
        updateTotal(productId);
        quantityInput.form.submit();
    }

    function decrementQuantity(productId) {
        var quantityInput = document.getElementById('quantity_' + productId);
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            updateTotal(productId);
            quantityInput.form.submit();
        }
    }


    function recalculateCartTotal() {
        var cartTotalSpan = document.getElementById('cartTotal');
        var cartTotal = 0;

        <?php foreach ($_SESSION['cart'] as $item) { ?>
        var productId = <?php echo $item['id']; ?>;
        var quantityInput = document.getElementById('quantity_' + productId);
        var price = <?php echo $item['price']; ?>;
        var quantity = parseInt(quantityInput.value);
        var total = price * quantity;

        cartTotal += total;
        <?php } ?>

        cartTotalSpan.innerHTML = cartTotal.toLocaleString();
    }
    </script>
</body>

</html>