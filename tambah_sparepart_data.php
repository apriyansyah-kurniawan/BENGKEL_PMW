<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username_admin'])) {
  header("Location: loginadmin.php");
}
// Menginisialisasi variabel
$nama_sparepart = $merk_sparepart = $stok_sparepart = $harga_sparepart = '';
$error_message = '';

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $nama_sparepart = $_POST['nama_sparepart'];
    $merk_sparepart = $_POST['merk_sparepart'];
    $stok_sparepart = $_POST['stok_sparepart'];
    $harga_sparepart = $_POST['harga_sparepart'];

    // Memeriksa jika ada kesalahan validasi
    if (empty($nama_sparepart) || empty($merk_sparepart) || empty($stok_sparepart) || empty($harga_sparepart)) {
        $error_message = "nama sparepart, merk sparepart, stok sparepart dan harga harus diisi";
    } else {
        // Menyimpan data admin ke database
        $sql = "INSERT INTO sparepart (nama_sparepart, merk_sparepart, stok_sparepart, harga) VALUES ('$nama_sparepart', '$merk_sparepart', '$stok_sparepart', '$harga_sparepart')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect ke halaman tampilan data admin
            mysqli_close($conn);
            header("Location: show_data_sparepart.php");
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat menambahkan data sparepart: " . mysqli_error($conn);
        }
    }
}

// Tutup koneksi ke database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Sparepart</title>
</head>
<body>
    <a href="show_data_sparepart.php" class="back-button">&#8592; Kembali</a>
    <h2>Tambah Data Sparepart</h2>
    <form method="POST" action="">
        <label>Nama Sparepart:</label>
        <input type="text" name="nama_sparepart" value="<?php echo $nama_sparepart; ?>" required><br>

        <label>Merk Sparepart:</label>
        <input type="text" name="merk_sparepart" value="<?php echo $merk_sparepart; ?>" required><br>

        <label>Stok Sparepart:</label>
        <input type="text" name="stok_sparepart" value="<?php echo $stok_sparepart; ?>" required><br>

        <label>Harga Sparepart:</label>
        <input type="text" name="harga_sparepart" value="<?php echo $harga_sparepart; ?>" required><br>

        <input type="submit" value="Tambah">
    </form>

    <?php if (!empty($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
</body>
</html>
