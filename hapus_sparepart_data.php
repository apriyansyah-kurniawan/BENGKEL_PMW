<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username_admin'])) {
  header("Location: loginadmin.php");
}
// Periksa apakah parameter ID telah diberikan
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data admin berdasarkan ID
    $sql = "DELETE FROM sparepart WHERE id_sparepart = $id";
    $result = mysqli_query($conn, $sql);

    if($result) {
        mysqli_close($conn);
        header("Location: show_data_sparepart.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat menghapus data sparepart: " . mysqli_error($conn);
    }
} else {
    echo "ID sparepart tidak ditemukan.";
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
