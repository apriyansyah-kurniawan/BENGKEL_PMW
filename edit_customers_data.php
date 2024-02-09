<?php
include 'koneksi.php';

// Cek apakah parameter id diterima dari URL
if (isset($_GET['id'])) {
    // Ambil nilai id dari parameter URL
    $id = $_GET['id'];

    // Query untuk mendapatkan data admin berdasarkan id
    $sql = "SELECT * FROM customers WHERE id_pelanggan = '$id'";
    $result = mysqli_query($conn, $sql);

    // Periksa apakah data admin ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data admin dari hasil query
        $row = mysqli_fetch_assoc($result);
        $nama = $row['nama'];
        $username = $row['username'];
        $password = $row['password'];
        $alamat = $row['alamat'];
        $nohp = $row['nohp'];

        // Cek apakah form submit telah dilakukan
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil nilai input dari form
            $namaBaru = $_POST['nama'];
            $usernameBaru = $_POST['username'];
            $passwordBaru = $_POST['password'];
            $alamatBaru = $row['alamat'];
            $nohpBaru = $row['nohp'];
            // Query untuk melakukan update data admin
            $updateSql = "UPDATE customers SET nama = '$namaBaru', username = '$usernameBaru', password = '$passwordBaru', alamat = '$alamatBaru', nohp = '$nohpBaru' WHERE id_pelanggan = '$id'";
            if (mysqli_query($conn, $updateSql)) {
                // Redirect kembali ke halaman show_data.php setelah berhasil mengubah data
                header("Location: show_data_customers.php");
                exit;
            } else {
                echo "Gagal mengubah data customer: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Data customers tidak ditemukan.";
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
    <title>Edit Customers Data</title>
</head>
<body>
    <a href="show_data_customers.php" class="back-button">&#8592; Kembali</a>
    <h2>Edit Customers Data</h2>
    <form method="POST" action="">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>"><br><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>"><br><br>

        <label for="alamat">Alamat:</label><br>
        <input type="text" id="alamat" name="alamat" value="<?php echo $alamat; ?>"><br><br>

        <label for="nohp">Nomor Hp:</label><br>
        <input type="text" id="nohp" name="nohp" value="<?php echo $nohp; ?>"><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
