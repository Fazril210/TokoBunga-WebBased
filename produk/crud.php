<?php
// Lakukan koneksi ke database (gantilah dengan konfigurasi database Anda)
include_once '../koneksi.php';

// Fungsi Create (Tambah)
function tambahProduk($data)
{
    global $koneksi;

    $nama_produk = $data['nama_produk'];
    $deskripsi = $data['deskripsi'];
    $harga = $data['harga'];
    $stok = $data['stok'];

    $gambar_produk = $_FILES['gambar_produk']['name'];
    $tmp_gambar = $_FILES['gambar_produk']['tmp_name'];
    $lokasi_gambar = "../assets/images/produk/" . $gambar_produk;

    move_uploaded_file($tmp_gambar, $lokasi_gambar);

    $query = "INSERT INTO produk (nama_produk, deskripsi, harga, stok, gambar_produk) VALUES ('$nama_produk', '$deskripsi', $harga, $stok, '$lokasi_gambar')";
    $result = mysqli_query($koneksi, $query);

    return $result;
}

// Fungsi Read (Tampil)
function tampilProduk()
{
    global $koneksi;

    $query = "SELECT * FROM produk";
    $result = mysqli_query($koneksi, $query);

    $produk = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $produk[] = $row;
    }

    return $produk;
}


// Fungsi Update (Edit)
function editProduk($id_produk, $data)
{
    global $koneksi;

    $nama_produk = isset($data['nama_produk']) ? $data['nama_produk'] : '';
    $deskripsi = isset($data['deskripsi']) ? $data['deskripsi'] : '';
    $harga = isset($data['harga']) ? $data['harga'] : 0;
    $stok = isset($data['stok']) ? $data['stok'] : 0;

    // Check if a new image is uploaded
    if (isset($_FILES['gambar_produk']['name']) && $_FILES['gambar_produk']['name'] != '') {
        $gambar_produk = $_FILES['gambar_produk']['name'];
        $tmp_gambar = $_FILES['gambar_produk']['tmp_name'];
        $lokasi_gambar = "../assets/images/produk/" . $gambar_produk;

        move_uploaded_file($tmp_gambar, $lokasi_gambar);

        // Include the new image in the update query
        $result = mysqli_query($koneksi, "UPDATE produk SET nama_produk='$nama_produk', deskripsi='$deskripsi', harga=$harga, stok=$stok, gambar_produk='$lokasi_gambar' WHERE id_produk=$id_produk");
    } else {
        // If no new image is uploaded, update without changing the existing image
        $result = mysqli_query($koneksi, "UPDATE produk SET nama_produk='$nama_produk', deskripsi='$deskripsi', harga=$harga, stok=$stok WHERE id_produk=$id_produk");
    }

    return $result;
}



// Fungsi Read (Tampil) berdasarkan ID
// Fungsi Read (Tampil) berdasarkan ID
function tampilProdukById($id_produk)
{
    global $koneksi;

    $query = "SELECT * FROM produk WHERE id_produk = $id_produk";
    $result = mysqli_query($koneksi, $query);

    // Check if a product is found
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null; // or handle this case as needed
    }
}

// Fungsi Delete (Hapus)
function hapusProduk($id_produk)
{
    global $koneksi;

    // Hapus terlebih dahulu data di tabel anak (detail_pesanan)
    $query_delete_detail = "DELETE FROM detail_pesanan WHERE id_produk=$id_produk";
    $result_delete_detail = mysqli_query($koneksi, $query_delete_detail);

    // Hapus data di tabel utama (produk) jika penghapusan di tabel anak berhasil
    if ($result_delete_detail) {
        $query_delete_produk = "DELETE FROM produk WHERE id_produk=$id_produk";
        $result_delete_produk = mysqli_query($koneksi, $query_delete_produk);

        return $result_delete_produk;
    } else {
        return false;
    }
}

?>