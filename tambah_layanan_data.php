<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username_admin'])) {
  header("Location: loginadmin.php");
}

// Menginisialisasi variabel
$jenis_layanan = $harga_layanan = $waktu_layanan = $deskripsi_layanan = '';
$error_message = '';

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $jenis_layanan = $_POST['jenis_layanan'];
    $harga_layanan = $_POST['harga_layanan'];
    $waktu_layanan = $_POST['waktu_layanan'];
    $deskripsi_layanan = $_POST['deskripsi_layanan'];

    // Memeriksa jika ada kesalahan validasi
    if (empty($jenis_layanan) || empty($harga_layanan) || empty($waktu_layanan) || empty($deskripsi_layanan)) {
        $error_message = "jenis layanan, harga, waktu layanan dan deksripsi harus diisi";
    } else {
        // Menyimpan data admin ke database
        $sql = "INSERT INTO layanan (jenis_layanan, harga_layanan, waktu_layanan, deskripsi_layanan) VALUES ('$jenis_layanan', '$harga_layanan', '$waktu_layanan', '$deskripsi_layanan')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect ke halaman tampilan data admin
            mysqli_close($conn);
            header("Location: show_data_layanan.php");
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat menambahkan data admin: " . mysqli_error($conn);
        }
    }
}

// Tutup koneksi ke database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Layanan</title>
    
</head>
<body>
    <a href="show_data_layanan.php" class="back-button">&#8592; Kembali</a>
    <h2>Tambah Data Layanan</h2>
    <form method="POST" action="">
        <label>Jenis Layanan:</label>
        <input type="text" name="jenis_layanan" value="<?php echo $jenis_layanan; ?>" required><br>

        <label>Harga Layanan:</label>
        <input type="number" name="harga_layanan" value="<?php echo $harga_layanan; ?>" required><br>

        <label>Waktu Layanan:</label>
        <input type="time" name="waktu_layanan" value="<?php echo $waktu_layanan; ?>" required><br>

        <label>Deskripsi:</label>
        <input type="text" name="deskripsi_layanan" value="<?php echo $deskripsi_layanan; ?>" required><br>

        <input type="submit" value="Tambah">
    </form>

    <?php if (!empty($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
</body>
</html>
