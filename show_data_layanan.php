<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username_admin'])) {
    header("Location: loginadmin.php");
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
        }

        body {
            background-image: url('pic1.jpg'); /* Set the background image for the left half */
            background-repeat: no-repeat;
            background-size: 99% 80%; /* 100% width, 50% height */
            /* Position the background image below the header */
            background-position: center top 355px; 
            margin-bottom: 200px;
        }

        /* New styles for header */
        header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 12px;
            background-color: skyblue;
            color: white;
            height: 100px;
        }

        header h2 {
            margin: 0;
            font-size: 24px;
            height: 10px;
        }

        /* Rest of the existing CSS styles */
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: lightgrey;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: silver;
        }

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

        .add-layanan-button, input[type="submit"] {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .edit-button, .delete-button {
            padding: 6px 12px;
            font-size: 14px;
            margin: 2px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            width: 60px; /* Set a fixed width for consistent button sizes */
            text-align: center;
            transition: background-color 0.3s ease-in-out; /* Add a smooth transition effect */
        }

        .edit-button {
            background-color: #4CAF50;
            color: white;
        }

        .delete-button {
            background-color: #f44336;
            color: white;
        }

        .edit-button:hover,
        .delete-button:hover,
        .add-layanan-button:hover,
        .back-button:hover {
            opacity: 0.8;
        }

        input[type="text"] {
            padding: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Untuk perangkat dengan lebar maksimum 600px */
        @media (max-width: 600px) {
            table {
                font-size: 12px;
            }

            th, td {
                padding: 4px;
            }

            .edit-button, .delete-button, .add-layanan-button {
                padding: 4px 8px;
                font-size: 12px;
                margin: 2px;
            }

            .back-button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- New header with "Data Layanan" -->
    <header>
        <h2>DATA LAYANAN</h2>
    </header>

    <a href="indexadmin.php" class="back-button">&#8592; Kembali</a>
    <a href="tambah_layanan_data.php" class="add-layanan-button">Tambah Data</a>
    <form action="" method="get">
        <input type="text" name="search" placeholder="Cari data...">
        <input type="submit" value="Cari">
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Layanan</th>
            <th>Harga</th>
            <th>Waktu Layanan</th>
            <th>Deskripsi</th>
            <th>Action</th>
        </tr>
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
                echo "<td><a href='edit_layanan_data.php?id=" . $row["id_layanan"] . "' class='edit-button'>Edit</a>";
                echo "<a href='hapus_layanan_data.php?id=" . $row["id_layanan"] . "' class='delete-button'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data layanan yang ditemukan.</td></tr>";
        }
        ?>
    </table>
</body>
</html>


<?php
// Tutup koneksi ke database
mysqli_close($conn);
?>
