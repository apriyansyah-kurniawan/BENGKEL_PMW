<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}
// Query untuk mendapatkan data admin
$sql = "SELECT * FROM layanan";
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Modify the SQL query to include the search condition
    $sql = "SELECT * FROM layanan WHERE 
            jenis_layanan LIKE '%$searchTerm%' OR 
            waktu_layanan LIKE '%$searchTerm%' OR 
            deskripsi_layanan LIKE '%$searchTerm%' OR 
            harga_layanan LIKE '%$searchTerm%'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Data Layanan</title>
    <style>
        /* Gaya untuk tabel */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .content {
            
            padding: 40px;
            background-color: grey;
            height: 500px; 
        }

        /* Gaya untuk tombol Edit */
        .back-button {
            position: fixed;
            top: 70px; 
            left: 60px; 
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 10px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #2980b9;
        }

        /* Gaya untuk tombol Tambah Admin */
        .add-pemesanan-button {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin: 4px 2px;
            cursor: pointer;
            float: right;
        }

        /* Gaya untuk judul halaman */
        .page-header {
            text-align: center;
            background-color: lightblue; /* Warna hijau */
            color: white;
            padding: 30px;
            font-size: 24px;
            margin-top: 0;
        }

        /* Gaya untuk form pencarian */
        .search-form {
            text-align: center;
            margin-top: 20px;
        }

        .search-form input[type="text"] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-form input[type="submit"] {
            background-color: #32CD32; /* Warna hijau */
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-left: 10px; /* Tambahkan margin kiri agar tombol berjarak dari input field */
        }

        .search-form input[type="submit"]:hover {
            background-color: #2E8B57; /* Warna hijau tua saat hover */
        }
        
        footer {
            background-color: #000;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 97.5%;
            height: 100px; /* Sesuaikan tinggi footer sesuai kebutuhan */
            background-image: url("picfoot3.jpg");
            background-size: cover;
            background-position: center;
            margin-left: 8px;
        }
    </style>

</head>
<body>
    <div class="content">
    <?php
    // Check for success or error messages and display them
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p>Data berhasil disimpan ke dalam keranjang.</p>";
    } elseif (isset($_GET['error']) && $_GET['error'] == 1) {
        echo "<p>Anda harus memilih minimal satu layanan untuk menyimpan ke keranjang.</p>";
    }
    ?>
    
    <a href="index.php" class="back-button">&#8592; Kembali</a>
    <div class="page-header">DATA LAYANAN</div>
    
    <!-- Form pencarian -->
    <div class="search-form">
        <form action="" method="get">
            <input type="text" name="search" placeholder="Cari data...">
            <input type="submit" value="Cari">
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama Layanan</th>
            <th>Harga</th>
            <th>Waktu Layanan</th>
            <th>Deskripsi</th>
            <th>Action</th>
        </tr>
        <form action="input_pemesanan.php" method="post">
        <?php
        // Periksa hasil query
        if (mysqli_num_rows($result) > 0) {
            // Loop melalui setiap baris data dan tampilkan
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id_layanan"] . "</td>";
                echo "<td>" . $row["jenis_layanan"] . "</td>";
                // Ubah harga menjadi format Rupiah
                echo "<td>Rp." . number_format($row["harga_layanan"], 0, ',', '.') . ",00"."</td>";
                echo "<td>" . $row["waktu_layanan"] . "</td>";
                echo "<td>" . $row["deskripsi_layanan"] . "</td>";
                echo "<td><input type='checkbox' name='layanan[]' value='" . $row["id_layanan"] . "'></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data layanan yang ditemukan.</td></tr>";
        }
        ?>
        <input type="submit" value="+ Simpan Ke Keranjang" class="add-pemesanan-button">
    </table>
    </form>
    </div> 
    <footer>
    </footer>

</body>
</html>
