<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register User</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" type="text/css" href="../assets/css/register.css">
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <?php
    if (isset($_SESSION['error'])) {
    ?>
    <div class="alert alert-warning" role="alert">
        <?php echo $_SESSION['error'] ?>
    </div>
    <?php
    }
    ?>
    <?php
    if (isset($_SESSION['message'])) {
    ?>
    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION['message'] ?>
    </div>
    <?php
    }
    ?>
    <form method="post" action="register_proses.php">
        <h3><a href="login.php"><i class="fas fa-arrow-left"></i></a> Register Form</h3>
        <hr>
        <div class="isi">

            <label for="nama_pelanggan">Nama Pelanggan</label>
            <input type="text" placeholder="Enter your username" id="username" name="nama_pelanggan" required>

            <label for="email">Email</label>
            <input type="email" placeholder="Enter your email address" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" placeholder="Enter your password" id="password" name="password" required>

            <label for="password">Password Confirmation</label>
            <input type="password" placeholder="Enter password confirmation" id="password" name="password_konfirmasi"
                required>

            <label for="alamat">Alamat</label>
            <input type="text" placeholder="Enter your address" id="alamat" name="alamat" required>

            <label for="no_telpon">Nomor Telepon</label>
            <input type="text" placeholder="Enter your phone number" id="nomor" name="nomor_telepon" required>

            <button type="submit">Register</button>
        </div>
    </form>

</body>
<?php
session_destroy();
?>

</html>