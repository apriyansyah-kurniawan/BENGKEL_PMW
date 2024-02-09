<?php
include 'koneksi.php';

// Menginisialisasi variabel
$nama = $username = $password = $alamat = $nohp = '';
$error_message = '';

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];

    // Memeriksa jika ada kesalahan validasi
    if (empty($nama) || empty($username) || empty($password) || empty($alamat) || empty($nohp)) {
        $error_message = "Nama, Username, dan Password harus diisi";
    } else {
        // Menyimpan data admin ke database
        $sql = "INSERT INTO customers (nama, username, password, alamat, nohp) VALUES ('$nama', '$username', '$password', '$alamat', '$nohp')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect ke halaman tampilan data admin
            mysqli_close($conn);
            header("Location: show_data_customers.php");
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat menambahkan data customers: " . mysqli_error($conn);
        }
    }
}

// Tutup koneksi ke database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Customers</title>
</head>
<body>
    <a href="show_data_customers.php" class="back-button">&#8592; Kembali</a>
    <h2>Tambah Data Customers</h2>
    <form method="POST" action="">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?php echo $nama; ?>" required><br>

        <label>Username:</label>
        <input type="text" name="username" value="<?php echo $username; ?>" required><br>

        <label>Password:</label>
        <input type="password" name="password" value="<?php echo $password; ?>" required><br>

        <label>Alamat:</label>
        <input type="text" name="alamat" value="<?php echo $alamat; ?>" required><br>

        <label>Nomor Hp:</label>
        <input type="text" name="nohp" value="<?php echo $nohp; ?>" required><br>

        <input type="submit" value="Tambah">
    </form>

    <?php if (!empty($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
</body>
</html>
