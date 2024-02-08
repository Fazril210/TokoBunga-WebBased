<?php
// Lakukan koneksi ke database (gantilah dengan konfigurasi database Anda)
include_once '../koneksi.php';

// Fungsi Create (Tambah)
function tambahPesanan($data)
{
    global $koneksi;

    $id_pelanggan = $data['id_pesanan'];
    $tanggal_pesanan = $data['tanggal_pesanan'];
    $status_pesanan = $data['status_pesanan'];
    $total_harga = $data['total_harga'];

    $query = "INSERT INTO pesanan (id_pesanan, tanggal_pesanan, status_pesanan, total_harga) VALUES ($id_pelanggan, '$tanggal_pesanan', '$status_pesanan', $total_harga)";
    
    $result = mysqli_query($koneksi, $query);

    return $result;
}

// Fungsi Read (Tampil)
function tampilPesanan()
{
    global $koneksi;

    $query = "SELECT * FROM pesanan";
    $result = mysqli_query($koneksi, $query);

    $pesanan = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $pesanan[] = $row;
    }

    return $pesanan;
}

// Fungsi Update (Edit)
function editPesanan($id_pesanan, $data)
{
    global $koneksi;

    $status_pesanan = $data['status_pesanan'];

    $query = "UPDATE pesanan SET status_pesanan='$status_pesanan' WHERE id_pesanan=$id_pesanan";
    $result = mysqli_query($koneksi, $query);

    return $result;
}



// Fungsi Read (Tampil) berdasarkan ID
function tampilPesananById($id_pesanan)
{
    global $koneksi;

    $query = "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan";
    $result = mysqli_query($koneksi, $query);

    // Check if a product is found
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null; // or handle this case as needed
    }
}

// Fungsi Delete (Hapus)
function hapusPesanan($id_pesanan)
{
    global $koneksi;

    // First, delete related records in the detail_pesanan table
    $query_delete_detail_pesanan = "DELETE FROM detail_pesanan WHERE id_pesanan=$id_pesanan";
    $result_delete_detail_pesanan = mysqli_query($koneksi, $query_delete_detail_pesanan);

    // Then, delete the record in the pesanan table
    $query_delete_pesanan = "DELETE FROM pesanan WHERE id_pesanan=$id_pesanan";
    $result_delete_pesanan = mysqli_query($koneksi, $query_delete_pesanan);

    return $result_delete_pesanan;
}