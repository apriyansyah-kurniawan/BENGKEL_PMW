<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}
// Function to get id_pelanggan from the database based on the logged-in username
function getIdPelangganFromUsername($conn, $username) {
    $sql = "SELECT id_pelanggan FROM customers WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['id_pelanggan'];
}
$username = $_SESSION['username'];
$id_pelanggan = getIdPelangganFromUsername($conn, $username);
$sql1 = "SELECT p.*, s.harga_sparepart, s.nama_sparepart, NULL AS harga_layanan, NULL AS jenis_layanan
         FROM sparepart AS s
         INNER JOIN pemesanan AS p ON s.id_sparepart = p.id_sparepart
        WHERE p.id_pelanggan = '$id_pelanggan'";
$sql2 = "SELECT t.*, NULL AS harga, NULL AS nama_sparepart, l.harga_layanan, l.jenis_layanan
         FROM layanan AS l 
         INNER JOIN pemesanan AS t ON l.id_layanan = t.id_layanan
        WHERE t.id_pelanggan = '$id_pelanggan'";
        
$sql = "$sql1 UNION $sql2";


$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Data Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url("sage.jpg");
            background-size: cover; /* Menyesuaikan gambar agar mengisi seluruh halaman */
            background-repeat: no-repeat; /* Mencegah gambar diulang pada latar belakang */
            background-position: center center; /* Posisi gambar latar belakang di tengah-tengah */
            background-attachment: fixed; /* Memastikan gambar tetap di posisi yang sama saat menggulir halaman */
        }

        /* Header Styles */
        header {
            background-color: #4CAF50;
            padding: 10px;
            color: white;
            text-align: center;
        }

        /* Footer Styles */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        /* Table Styles */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;background-color: lightblue; 
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: silver;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Button Styles */
        .back-button {
            background-color: grey; /* Warna hijau */
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            position: absolute;
            top: 15px;
            left: 15px;
            border-radius: 5px;
            display: inline-block; /* Tambahkan display: inline-block; */
        }

        .edit-button, .delete-button, .add-pemesanan-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .delete-button {
            background-color: #f44336;
        }

        .add-pemesanan-button {
            background-color: #2196F3;
            float: right;
        }
    </style>
</head>
<body>
    <header>
        <h1>Data Transaksi</h1>
        <a href="index.php" class="back-button">&#8592; Kembali</a>
    </header>
    
    <table>
        <tr>
            <th>ID</th>
            <th>ID Pelanggan</th>
            <th>ID Layanan</th>
            <th>Nama Layanan</th>
            <th>ID Sparepart</th>
            <th>Nama Sparepart</th>
            <th>Tanggal Pemesanan</th>
            <th>Harga Layanan</th>
            <th>Harga Sparepart</th>
            <th>Status</th>
        </tr>
        <?php
        // Periksa hasil query
        if (mysqli_num_rows($result) > 0) {
            // Loop melalui setiap baris data dan tampilkan
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id_pemesanan"] . "</td>";
                echo "<td>" . $row["id_pelanggan"] . "</td>";
                echo "<td>" . $row["id_layanan"] . "</td>";
                echo "<td>" . $row["jenis_layanan"] . "</td>";
                echo "<td>" . $row["id_sparepart"] . "</td>";
                echo "<td>" . $row["nama_sparepart"] . "</td>";
                echo "<td>" . $row["tanggal_pemesanan"] . "</td>";
                echo "<td>" . $row["harga_layanan"] . "</td>";
                echo "<td>" . $row["harga_sparepart"] . "</td>";
                echo "<td>" . $row["status_pemesanan"] . "</td>";
                echo "</tr>";
            }
            
        } else {
            echo "<tr><td colspan='10'>Tidak ada data pemesanan yang ditemukan.</td></tr>";
        }
        ?>
    </table>
    
    <footer>
        &copy; 2023 Wijaya Mandiri. All rights reserved.
    </footer>
</body>
</html>

<?php
// Tutup koneksi ke database
mysqli_close($conn);
?>