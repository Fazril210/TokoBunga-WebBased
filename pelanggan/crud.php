<?php
// Lakukan koneksi ke database (gantilah dengan konfigurasi database Anda)
include_once '../koneksi.php';

// Fungsi Create (Tambah)
function tambahPelanggan($data)
{
    global $koneksi;

    $nama_pelanggan = $data['nama_pelanggan'];
    $email = $data['email'];
    $password = md5($data['password']); // Hash the password using MD5
    $alamat = $data['alamat'];
    $nomor_telepon = $data['nomor_telepon'];

    // Use single quotes for string values
    $query = "INSERT INTO pelanggan (nama_pelanggan, email, password, alamat, nomor_telepon) VALUES ('$nama_pelanggan', '$email', '$password', '$alamat', '$nomor_telepon')";
    
    $result = mysqli_query($koneksi, $query);

    return $result;
}



// Fungsi Read (Tampil)
function tampilPelanggan()
{
    global $koneksi;

    $query = "SELECT * FROM pelanggan";
    $result = mysqli_query($koneksi, $query);

    $pelanggan = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $pelanggan[] = $row;
    }

    return $pelanggan;
}


// Fungsi Update (Edit)
function editPelanggan($id_pelanggan, $data)
{
    global $koneksi;

    $nama_pelanggan = isset($data['nama_pelanggan']) ? $data['nama_pelanggan'] : '';
    $email = isset($data['email']) ? $data['email'] : '';
    $password = isset($data['password']) ? md5($data['password']) : ''; // Hash the password using MD5
    $alamat = isset($data['alamat']) ? $data['alamat'] : '';
    $nomor_telepon = isset($data['nomor_telepon']) ? $data['nomor_telepon'] : '';

    // Use single quotes for string values
    $query = "UPDATE pelanggan SET nama_pelanggan='$nama_pelanggan', email='$email', password='$password', alamat='$alamat', nomor_telepon='$nomor_telepon' WHERE id_pelanggan=$id_pelanggan";

    // Execute the query
    $result = mysqli_query($koneksi, $query);

    return $result;
}




// Fungsi Read (Tampil) berdasarkan ID
function tampilPelangganById($id_pelanggan)
{
    global $koneksi;

    $query = "SELECT * FROM pelanggan WHERE id_pelanggan = $id_pelanggan";
    $result = mysqli_query($koneksi, $query);

    // Check if a product is found
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null; // or handle this case as needed
    }
}


// Fungsi Delete (Hapus)
function hapusPelanggan($id_pelanggan)
{
    global $koneksi;
    

    $query = "DELETE FROM pelanggan WHERE id_pelanggan=$id_pelanggan";
    $result = mysqli_query($koneksi, $query);

    return $result;
}
?>