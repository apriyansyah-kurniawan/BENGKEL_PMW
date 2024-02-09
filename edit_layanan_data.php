<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username_admin'])) {
  header("Location: loginadmin.php");
}
// Cek apakah parameter id diterima dari URL
if (isset($_GET['id'])) {
    // Ambil nilai id dari parameter URL
    $id = $_GET['id'];

    // Query untuk mendapatkan data admin berdasarkan id
    $sql = "SELECT * FROM layanan WHERE id_layanan = '$id'";
    $result = mysqli_query($conn, $sql);

    // Periksa apakah data admin ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data admin dari hasil query
        $row = mysqli_fetch_assoc($result);
        $jenis_layanan = $row['jenis_layanan'];
        $harga_layanan = $row['harga_layanan'];
        $waktu_layanan = $row['waktu_layanan'];
        $deskripsi_layanan = $row['deskripsi_layanan'];

        // Cek apakah form submit telah dilakukan
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil nilai input dari form
            $jenisBaru = $_POST['jenis_layanan'];
            $hargaBaru = $_POST['harga'];
            $waktuBaru = $_POST['waktu_layanan'];
            $deskripsiBaru = $_POST['deskripsi'];

            // Query untuk melakukan update data admin
            $updateSql = "UPDATE layanan SET jenis_layanan = '$jenisBaru', harga_layanan = '$hargaBaru', waktu_layanan = '$waktuBaru', deskripsi_layanan = '$deskripsiBaru' WHERE id_layanan = '$id'";
            if (mysqli_query($conn, $updateSql)) {
                // Redirect kembali ke halaman show_data.php setelah berhasil mengubah data
                header("Location: show_data_layanan.php");
                exit;
            } else {
                echo "Gagal mengubah data layanan: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Data layanan tidak ditemukan.";
    }
} else {
    echo "Parameter id tidak ditemukan.";
}

// Tutup koneksi ke database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Layanan Data</title>
</head>
<body>
    <a href="show_data_layanan.php" class="back-button">&#8592; Kembali</a>
    <h2>Edit Layanan Data</h2>
    <form method="POST" action="">
        <label for="jenis_layanan">Jenis layanan:</label><br>
        <input type="text" id="jenis_layanan" name="jenis_layanan" value="<?php echo $jenis_layanan; ?>"><br><br>

        <label for="harga_layanan">Harga layanan:</label><br>
        <input type="number" id="harga_layanan" name="harga" value="<?php echo $harga_layanan; ?>"><br><br>

        <label for="waktu_layanan">Waktu layanan:</label><br>
        <input type="time" id="waktu_layanan" name="waktu_layanan" value="<?php echo $waktu_layanan; ?>"><br><br>

        <label for="deskripsi">Deskripsi:</label><br>
        <input type="text" id="deskripsi" name="deskripsi" value="<?php echo $deskripsi_layanan; ?>"><br><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>
