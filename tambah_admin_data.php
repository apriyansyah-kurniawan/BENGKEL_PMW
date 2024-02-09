<?php
include 'koneksi.php';

// Menginisialisasi variabel
$nama_admin = $username_admin = $password_admin = '';
$error_message = '';

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $nama_admin = $_POST['nama_admin'];
    $username_admin = $_POST['username_admin'];
    $password_admin = $_POST['password_admin'];

    // Memeriksa jika ada kesalahan validasi
    if (empty($nama_admin) || empty($username_admin) || empty($password_admin)) {
        $error_message = "Nama, Username, dan Password harus diisi";
    } else {
        // Menyimpan data admin ke database
        $sql = "INSERT INTO admin (nama_admin, username_admin, password_admin) VALUES ('$nama_admin', '$username_admin', '$password_admin')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect ke halaman tampilan data admin
            mysqli_close($conn);
            header("Location: show_data_admin.php");
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
    <title>Tambah Data Admin</title>
</head>
<body>
    <a href="show_data_admin.php" class="back-button">&#8592; Kembali</a>
    <h2>Tambah Data Admin</h2>
    <form method="POST" action="">
        <label>Nama:</label>
        <input type="text" name="nama_admin" value="<?php echo $nama_admin; ?>" required><br>

        <label>Username:</label>
        <input type="text" name="username_admin" value="<?php echo $username_admin; ?>" required><br>

        <label>Password:</label>
        <input type="password" name="password_admin" value="<?php echo $password_admin; ?>" required><br>

        <input type="submit" value="Tambah">
    </form>

    <?php if (!empty($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
</body>
</html>
