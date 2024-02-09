<?php
include 'koneksi.php';

// Cek apakah parameter id diterima dari URL
if (isset($_GET['id'])) {
    // Ambil nilai id dari parameter URL
    $id = $_GET['id'];

    // Query untuk mendapatkan data admin berdasarkan id_admin
    $sql = "SELECT * FROM admin WHERE id_admin = '$id'";
    $result = mysqli_query($conn, $sql);

    // Periksa apakah data admin ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data admin dari hasil query
        $row = mysqli_fetch_assoc($result);
        $namaAdmin = $row['nama_admin'];
        $usernameAdmin = $row['username_admin'];
        $passwordAdmin = $row['password_admin'];

        // Cek apakah form submit telah dilakukan
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil nilai input dari form
            $namaAdminBaru = $_POST['nama_admin'];
            $usernameAdminBaru = $_POST['username_admin'];
            $passwordAdminBaru = $_POST['password_admin'];

            // Query untuk melakukan update data admin
            $updateSql = "UPDATE admin SET nama_admin = '$namaAdminBaru', username_admin = '$usernameAdminBaru', password_admin = '$passwordAdminBaru' WHERE id_admin = '$id'";
            if (mysqli_query($conn, $updateSql)) {
                // Redirect kembali ke halaman show_admin_data.php setelah berhasil mengubah data
                header("Location: show_data_admin.php");
                exit;
            } else {
                echo "Gagal mengubah data admin: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Data admin tidak ditemukan.";
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
    <title>Edit Admin Data</title>
</head>
<body>
    <a href="show_data_admin.php" class="back-button">&#8592; Kembali</a>
    <h2>Edit Admin Data</h2>
    <form method="POST" action="">
        <label for="nama_admin">Nama Admin:</label><br>
        <input type="text" id="nama_admin" name="nama_admin" value="<?php echo $namaAdmin; ?>"><br><br>
        <label for="username_admin">Username Admin:</label><br>
        <input type="text" id="username_admin" name="username_admin" value="<?php echo $usernameAdmin; ?>"><br><br>
        <label for="password_admin">Password Admin:</label><br>
        <input type="password" id="password_admin" name="password_admin" value="<?php echo $passwordAdmin; ?>"><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
