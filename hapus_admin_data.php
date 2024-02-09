<?php
include 'koneksi.php';

// Periksa apakah parameter ID telah diberikan
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data admin berdasarkan ID
    $sql = "DELETE FROM admin WHERE id_admin = $id";
    $result = mysqli_query($conn, $sql);

    if($result) {
        mysqli_close($conn);
        header("Location: show_data_admin.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat menghapus data admin: " . mysqli_error($conn);
    }
} else {
    echo "ID admin tidak ditemukan.";
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
