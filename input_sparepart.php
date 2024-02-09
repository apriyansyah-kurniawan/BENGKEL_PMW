<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}
// Query untuk mendapatkan data admin
$sql = "SELECT * FROM sparepart";
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Modify the SQL query to include the search condition
    $sql = "SELECT * FROM sparepart WHERE 
            nama_sparepart LIKE '%$searchTerm%' OR 
            merk_sparepart LIKE '%$searchTerm%' OR 
            stok_sparepart LIKE '%$searchTerm%' OR 
            harga_sparepart LIKE '%$searchTerm%'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Data Sparepart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        /* Header style */
        header {
            background-color: #2196F3;
            color: white;
            text-align: center;
            padding: 15px;
        }

        /* Gaya untuk tabel */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: grey; /* Ganti warna latar belakang menjadi biru */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

         /* Ganti warna latar belakang baris genap menjadi hijau */
         tr:nth-child(even) {
            background-color: silver; /* Ganti warna latar belakang menjadi hijau */
        }

        body {
            background-image: url("sparepart2.png");
            background-size: cover; /* Menyesuaikan gambar agar mengisi seluruh halaman */
            background-repeat: no-repeat; /* Mencegah gambar diulang pada latar belakang */
            background-position: center center; /* Posisi gambar latar belakang di tengah-tengah */
            background-attachment: fixed; /* Memastikan gambar tetap di posisi yang sama saat menggulir halaman */
        }

        /* Gaya untuk tombol Edit */
        .back-button {
            background-color: #4CAF50; /* Warna hijau */
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

        /* Gaya untuk tombol Tambah Admin */
        .add-pemesanan-button {
            background-color: #4CAF50;
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
            border-radius: 5px;
        }

        /* Style untuk form pencarian */
        .search-form {
            margin-top: 20px;
            text-align: center;
        }

        .search-form input[type="text"] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .search-form input[type="submit"] {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Footer style */
        footer {
            background-color: #2196F3;
            color: white;
            text-align: center;
            padding: 10px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Data Sparepart</h1>
    </header>
    
    <div class="search-form">
        <form action="" method="get">
            <input type="text" name="search" placeholder="Cari data...">
            <input type="submit" value="Cari">
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama Sparepart</th>
            <th>Merk</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Action</th>
        </tr>
        <!-- Add a form to wrap the table and the "+ Simpan Ke Keranjang" button -->
        <form action="input_pemesanan_sparepart.php" method="post" >
        <?php
        // Periksa hasil query
        if (mysqli_num_rows($result) > 0) {
            // Loop melalui setiap baris data dan tampilkan
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id_sparepart"] . "</td>";
                echo "<td>" . $row["nama_sparepart"] . "</td>";
                echo "<td>" . $row["merk_sparepart"] . "</td>";
                echo "<td>" . $row["stok_sparepart"] . "</td>";
                // Ubah harga menjadi format Rupiah
                echo "<td>Rp." . number_format($row["harga_sparepart"], 0, ',', '.') . ",00"."</td>";
                echo "<td><input type='checkbox' name='sparepart[]' value='" . $row["id_sparepart"] . "'></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data sparepart yang ditemukan.</td></tr>";
        }
        ?>
        <input type="submit" value="+ Simpan Ke Keranjang" class="add-pemesanan-button">
    </table>
    </form>

    <a href="index.php" class="back-button">&#8592; Kembali</a>

    <footer>
        &copy; 2023 Wijaya mandiri. All rights reserved.
    </footer>
</body>
</html>

<?php
// Tutup koneksi ke database
mysqli_close($conn);
?>