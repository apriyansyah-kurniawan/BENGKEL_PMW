<?php
include 'koneksi.php';

// Periksa apakah parameter ID telah diberikan
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data admin berdasarkan ID
    $sql = "DELETE FROM customers WHERE id_pelanggan = $id";
    $result = mysqli_query($conn, $sql);

    if($result) {
        mysqli_close($conn);
        header("Location: show_data_customers.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat menghapus data customers: " . mysqli_error($conn);
    }
} else {
    echo "ID customers tidak ditemukan.";
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
