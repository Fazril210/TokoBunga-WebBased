<?php
session_start();

include 'koneksi.php';


$dataProduk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY nama_produk ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $nomor_telepon = $_POST["nomor_telepon"];
    $pesan = $_POST["pesan"];

    // Validasi atau pemrosesan lainnya dapat ditambahkan di sini

    // Simpan data ke dalam basis data (contoh menggunakan MySQLi)
    $sql = "INSERT INTO kontak (nama, email, nomor_telepon, pesan) VALUES ('$nama', '$email', '$nomor_telepon', '$pesan')";

    if ($koneksi->query($sql) === TRUE) {
        echo "Pesan berhasil dikirim!";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>🌸Florist🌸</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <link rel="stylesheet" href="assets/css/style.css" />

</head>

<body>
    <!-- Header section starts -->
    <header>
        <input type="checkbox" name="" id="toggler" />
        <label for="toggler" class="fas fa-bars"></label>

        <a href="#" class="logo">Harmony <span>Blossom.</span></a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#about">tentang</a>
            <a href="#products">produk</a>
            <a href="#review">ulasan</a>
            <a href="#contact">kontak</a>
        </nav>
        <div class="icons">
            <a href="icons/cart.php" class="fas fa-shopping-cart" id="cart"></a>
            <?php
            if (isset($_SESSION['customer_name'])) {
                // Jika pelanggan sudah login, tampilkan nama pelanggan dan menu dropdown untuk logout
                echo '<div class="dropdown" onclick="toggleDropdown()">';
                echo '<a href="#" class="fas fa-user"><span style="font-size: 16px; margin-left:8px;">' . $_SESSION['customer_name'] . '</span></a>';
                echo '<div class="dropdown-content" id="userDropdown">';
                echo '<a href="#" onclick="confirmLogout();" style="font-size: 16px;">Logout</a>';
                echo '</div>';
                echo '</div>';
            } else {
                // Jika belum login, tampilkan tautan login
                echo '<a href="icons/login.php" class="fas fa-user"></a>';
            }
            ?>
        </div>

        <script>
        function toggleDropdown() {
            var userDropdown = document.getElementById("userDropdown");
            userDropdown.classList.toggle("show");
        }

        function confirmLogout() {
            var confirmation = confirm("Apakah Anda yakin ingin logout?");
            if (confirmation) {
                window.location.href = 'logout.php';
            }
        }
        </script>

    </header>
    <!-- Header section ends -->

    <!-- home section starts -->
    <section class="home" id="home">
        <div class="content">
            <h3>Blossom Bliss</h3>
            <span>Keindahan Alam Terbangkit</span>
            <p>Manjakan diri dengan daya tarik menawan dari kreasi alam terbaik. Benamkan diri Anda dalam dunia di mana
                bunga-bunga segar menampakkan pesonanya yang memesona, setiap kelopak membisikkan kisah keanggunan dan
                keanggunan.</p>
            <a href="icons/cart.php" class="btn">belanja sekarang</a>
        </div>
    </section>
    <!-- home section ends -->

    <!-- about section starts -->
    <section class="about" id="about">
        <h1 class="heading"><span> Tentang </span> Kami</h1>

        <div class="row">
            <div class="video-container">
                <video src="assets/videos/tulip.mp4" loop autoplay muted></video>
                <h3>penjual bunga terbaik</h3>
            </div>

            <div class="content">
                <h3>Mengapa memilih kami?</h3>
                <p>Kami menawarkan koleksi bunga yang dipilih dengan cermat untuk memastikan keindahan dan kualitas
                    terbaik. Setiap rangkaian bunga dirancang untuk memenuhi standar estetika tertinggi.</p>
                <p>Tim pelayanan pelanggan kami siap membantu Anda setiap saat. Dengan layanan pelanggan yang ramah dan
                    responsif, kami berkomitmen untuk menjawab pertanyaan dan menangani kebutuhan Anda dengan cepat.</p>
                <a href="#" class="btn">pelajari lebih lanjut</a>
            </div>
        </div>
    </section>
    <!-- about section ends -->

    <!-- icons section starts -->
    <section class="icons-container">
        <div class="icons">
            <img src="assets/images/icon-1.png" alt="" />
            <div class="info">
                <h3>pengiriman gratis</h3>
                <span>untuk semua pesanan</span>
            </div>
        </div>

        <div class="icons">
            <img src="assets/images/icon-2.png" alt="" />
            <div class="info">
                <h3>Pengembalian 10 Hari</h3>
                <span>Jaminan Uang Kembali</span>
            </div>
        </div>

        <div class="icons">
            <img src="assets/images/icon-3.png" alt="" />
            <div class="info">
                <h3>Penawaran & Hadiah</h3>
                <span>pada semua pesanan</span>
            </div>
        </div>

        <div class="icons">
            <img src="assets/images/icon-4.png" alt="" />
            <div class="info">
                <h3>Pembayaran Aman</h3>
                <span>dilindungi oleh OVO</span>
            </div>
        </div>
    </section>
    <!-- icons section ends -->

    <!-- product section starts -->
    <section class="products" id="products">
        <h1 class="heading">daftar <span>produk</span></h1>

        <div class="box-container">

            <div class="box">
                <span class="discount">- 46,7%</span>
                <div class="image">
                    <img src="assets/images/pot1.jpg" alt="" />
                    <div class="icons">
                        <a href="icons/cart.php" class="cart-btn">Pesan</a>
                    </div>
                </div>
                <div class="content">
                    <h3>bunga tulip</h3>
                    <div class="price">Rp. 159.900 <span>Rp. 299.900</span></div>
                </div>
            </div>

            <div class="box">
                <span class="discount">- 40%</span>
                <div class="image">
                    <img src="assets/images/pot2.png" alt="" />
                    <div class="icons">
                        <a href="icons/cart.php" class="cart-btn">Pesan</a>
                    </div>
                </div>
                <div class="content">
                    <h3>bunga mawar</h3>
                    <div class="price">Rp. 299.900<span>Rp. 499.900</span></div>
                </div>
            </div>

            <div class="box">
                <span class="discount">- 12,5%</span>
                <div class="image">
                    <img src="assets/images/pot3.png" alt="" />
                    <div class="icons">

                        <a href="icons/cart.php" class="cart-btn">Pesan</a>

                    </div>
                </div>
                <div class="content">
                    <h3>Bunga Spanish Oyster</h3>
                    <div class="price">Rp. 699.900 <span>Rp. 799.900</span></div>
                </div>
            </div>

            <div class="box">
                <span class="discount">- 18,77%</span>
                <div class="image">
                    <img src="assets/images/pot4.png" alt="" />
                    <div class="icons">

                        <a href="assets/icons/cart.php" class="cart-btn">Pesan</a>

                    </div>
                </div>
                <div class="content">
                    <h3>Bunga Mawar
                        <div class="price">Rp. 129.900 <span>Rp. 159.900</span></div>
                </div>
            </div>

            <div class="box">
                <span class="discount">- 33,34%</span>
                <div class="image">
                    <img src="assets/images/pot5 (2).png" alt="" />
                    <div class="icons">

                        <a href="icons/cart.php" class="cart-btn">Pesan</a>

                    </div>
                </div>
                <div class="content">
                    <h3>Bunga Mawar</h3>
                    <div class="price">Rp. 399.900<span>Rp. 599.900</span></div>
                </div>
            </div>

            <div class="box">
                <span class="discount">- 66,69%</span>
                <div class="image">
                    <img src="assets/images/pot6.png" alt="" />
                    <div class="icons">

                        <a href="icons/cart.php" class="cart-btn">Pesan</a>

                    </div>
                </div>
                <div class="content">
                    <h3>Bunga Mawar</h3>
                    <div class="price">Rp. 299.900<span>Rp. 499.900</span></div>
                </div>
            </div>

            <div class="box">
                <span class="discount">- 25,02%</span>
                <div class="image">
                    <img src="assets/images/pot7.jpg" alt="" />
                    <div class="icons">

                        <a href="icons/cart.php" class="cart-btn">Pesan</a>

                    </div>
                </div>
                <div class="content">
                    <h3>Bunga Verbascum</h3>
                    <div class="price">Rp. 599.900 <span>Rp. 799.900</span></div>
                </div>
            </div>

            <div class="box">
                <span class="discount">- 18,77%</span>
                <div class="image">
                    <img src="assets/images/pot8.png" alt="" />
                    <div class="icons">

                        <a href="icons/cart.php" class="cart-btn">Pesan</a>

                    </div>
                </div>
                <div class="content">
                    <h3>Bunga Anyelir</h3>
                    <div class="price">Rp. 129.900 <span>Rp.159.900</span></div>
                </div>
            </div>

            <div class="box">
                <span class="discount">- 33,34%</span>
                <div class="image">
                    <img src="assets/images/pot9.jpg" alt="" />
                    <div class="icons">

                        <a href="icons/cart.php" class="cart-btn">Pesan</a>

                    </div>
                </div>
                <div class="content">
                    <h3>Bunga Tulip</h3>
                    <div class="price">Rp. 399.900 <span>Rp. 599.900</span></div>
                </div>
            </div>

            <div class="box">
                <span class="discount">- 14,29%</span>
                <div class="image">
                    <img src="assets/images/pot10.jpg" alt="" />
                    <div class="icons">

                        <a href="icons/cart.php" class="cart-btn">Pesan</a>

                    </div>
                </div>
                <div class="content">
                    <h3>Bunga Mawar</h3>
                    <div class="price">Rp. 599.900<span>Rp. 699.900</span></div>
                </div>
            </div>
        </div>
    </section>
    <!-- product section ends -->

    <!-- review section starts -->
    <section class="review">
        <h1 class="heading" id="review">ulasan <span>pelanggan</span></h1>

        <div class="box-container">
            <div class="box">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>Toko Bunga Online ini luar biasa! Saya sangat senang dengan pengalaman berbelanja di sini. Koleksi
                    bunga yang ditawarkan sangat indah dan berkualitas tinggi. Pesanan saya tiba tepat waktu dan sesuai
                    dengan gambar yang ditampilkan di situs. Layanan pelanggan mereka sangat responsif dan membantu saya
                    dengan pertanyaan saya. </p>
                <div class="user">
                    <img src="assets/images/customer1.jpg" alt="" />
                    <div class="user-info">
                        <h3>Fazril Mantovani</h3>
                        <span>pelanggan Indonesia</span>
                    </div>
                </div>
                <span class="fas fa-quote-right"></span>
            </div>

            <div class="box">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>Toko Bunga yang sangat bagus. Saya sangat senang dengan pengalaman berbelanja di sini. Koleksi
                    bunga yang ditawarkan sangat indah dan berkualitas tinggi. Pesanan saya tiba tepat waktu dan sesuai
                    dengan gambar yang ditampilkan di situs. Layanan pelanggan mereka sangat responsif dan membantu saya
                    dengan pertanyaan saya.
                </p>
                <div class="user">
                    <img src="assets/images/customer2.jpg" alt="" />
                    <div class="user-info">
                        <h3>Suwandi</h3>
                        <span>Pelanggan Indonesia</span>
                    </div>
                </div>
                <span class="fas fa-quote-right"></span>
            </div>

            <div class="box">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>Very nice flower shop. I am very happy with my shopping experience here. Collection
                    The flowers offered are very beautiful and of high quality. My order arrived on time and as
                    described
                    with the images displayed on the site. Their customer service was very responsive and helpful to me
                    with my question.</p>
                <div class="user">
                    <img src="assets/images/customer3.jpeg" alt="" />
                    <div class="user-info">
                        <h3>Ahmad Baddar</h3>
                        <span>pelanggan Singapura</span>
                    </div>
                </div>
                <span class="fas fa-quote-right"></span>
            </div>
        </div>
    </section>
    <!-- review section ends -->

    <!-- contact section starts -->
    <section class="contact" id="contact">
        <h1 class="heading"><span>kontak </span> kami</h1>

        <div class="row">
            <form action="" method="POST">
                <input type="text" name="nama" placeholder="nama" class="box" />
                <input type="email" name="email" placeholder="email" class="box" />
                <input type="number" name="nomor_telepon" placeholder="nomor telepon" class="box" />
                <textarea name="pesan" class="box" placeholder="pesan" id="" cols="30" rows="10"></textarea>
                <input type="submit" value="kirim pesan" class="btn" />
            </form>
            <div class="image">
                <img src="assets/images/contact1.svg" alt="" />
            </div>
        </div>
    </section>
    <!-- contact section ends -->

    <!-- footer section starts -->

    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>tautan langsung</h3>
                <a href="#home">home</a>
                <a href="#about">tentang</a>
                <a href="#products">produk</a>
                <a href="#review">ulasan</a>
                <a href="#contact">kontak</a>
            </div>

            <div class="box">
                <h3>tautan tambahan</h3>
                <a href="#">my account</a>
                <a href="#">my order</a>
            </div>

            <div class="box">
                <h3>lokasi</h3>
                <a href="#">Indonesia</a>
                <a href="#">Japan</a>
                <a href="#">China</a>
                <a href="#">Iraq</a>
            </div>

            <div class="box">
                <h3>info kontak</h3>
                <a href="#">+62-865-3764-9827</a>
                <a href="#">HarmonyBlossom@gmail.com</a>
                <a href="#">Jl. Raya Pekayon No.60-77, RT.005/RW.001, Pekayon Jaya, Kec. Bekasi Sel., Kota Bks, Jawa
                    Barat 17148</a>
                <img src="assets/images/payments.png" alt="" />
            </div>
        </div>
    </section>
    <!-- footer section ends -->
</body>

</html>