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
    $sql = "SELECT * FROM sparepart WHERE id_sparepart = '$id'";
    $result = mysqli_query($conn, $sql);

    // Periksa apakah data admin ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data admin dari hasil query
        $row = mysqli_fetch_assoc($result);
        $nama_sparepart = $row['nama_sparepart'];
        $merk_sparepart = $row['merk_sparepart'];
        $stok_sparepart = $row['stok_sparepart'];
        $harga_sparepart = $row['harga'];

        // Cek apakah form submit telah dilakukan
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil nilai input dari form
            $jenisBaru = $_POST['nama_sparepart'];
            $merkBaru = $_POST['merk_sparepart'];
            $stokBaru = $_POST['stok_sparepart'];
            $hargaBaru = $_POST['harga_sparepart'];

            // Query untuk melakukan update data admin
            $updateSql = "UPDATE sparepart SET nama_sparepart = '$jenisBaru', merk_sparepart = '$merkBaru', stok_sparepart = '$stokBaru', harga = '$hargaBaru' WHERE id_sparepart = '$id'";
            if (mysqli_query($conn, $updateSql)) {
                // Redirect kembali ke halaman show_data.php setelah berhasil mengubah data
                header("Location: show_data_sparepart.php");
                exit;
            } else {
                echo "Gagal mengubah data sparepart: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Data sparepart tidak ditemukan.";
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
    <title>Edit sparepart Data</title>
</head>
<body>
    <a href="show_data_sparepart.php" class="back-button">&#8592; Kembali</a>
    <h2>Edit sparepart Data</h2>
    <form method="POST" action="">
        <label for="nama_sparepart">Jenis sparepart:</label><br>
        <input type="text" id="nama_sparepart" name="nama_sparepart" value="<?php echo $nama_sparepart; ?>"><br><br>

        <label for="merk_sparepart">Merk sparepart:</label><br>
        <input type="text" id="merk_sparepart" name="merk_sparepart" value="<?php echo $merk_sparepart; ?>"><br><br>

        <label for="stok_sparepart">Stok sparepart:</label><br>
        <input type="text" id="stok_sparepart" name="stok_sparepart" value="<?php echo $stok_sparepart; ?>"><br><br>

        <label for="harga">Harga Sparepart:</label><br>
        <input type="text" id="harga_sparepart" name="harga_sparepart" value="<?php echo $harga_sparepart; ?>"><br><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>
