<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username_admin'])) {
  header("Location: loginadmin.php");
}
// Query untuk mendapatkan data admin
$sql = "SELECT * FROM sparepart";
// Handle the search query if the user submitted it
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Modify the SQL query to include the search condition
    $sql = "SELECT * FROM sparepart WHERE 
            nama_sparepart LIKE '%$searchTerm%' OR 
            merk_sparepart LIKE '%$searchTerm%' OR 
            harga LIKE '%$searchTerm%'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Data Sparepart</title>
    <style>
        /* Gaya untuk tabel */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        body {
            /* Set the background image for the left half */
            background-image: url('pic2.jpg');
            background-repeat: no-repeat;
            background-size: 99% 50%; /* 100% width, 50% height */
            /* Position the background image below the header */
            background-position: center top 380px; 
            margin-bottom: 170px;
        }

        .header {
            background: linear-gradient(to right, #00b8ff, #e91e63); /* Warna gradasi */
            padding: 40px; /* Meningkatkan padding untuk memperbesar header */
            margin-bottom: 20px; /* Memberi margin bawah untuk memposisikan lebih ke bawah */
            color: white;
            font-size: 36px; /* Meningkatkan ukuran font */
            font-weight: bold;
        }

        .silver-background {
            background-color: silver;
            padding:20px 40px;
            height: 200px;
        }

        /* New style for the footer */
        .footer {
            background: linear-gradient(to right, #00b8ff, #e91e63);
            padding: 15px; /* Add padding for top and bottom */
            margin: 0 7px; /* Add margin for left and right sides */
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            /* Change the positioning to fixed and adjust other properties */
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
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
        .edit-button {
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
        }

         /* Style for search input field */
         input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 250px; /* Adjust the width as needed */
            margin-right: 10px; /* Add some space between input and button */
        }

        /* Style for search button */
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Add a hover effect for the search button */
        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Gaya untuk tombol Hapus */
        .delete-button {
            background-color: #f44336;
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

        /* Gaya untuk tombol Tambah Admin */
        .add-sparepart-button {
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
            float: right;
        }
        
    </style>
</head>
<body>
    <a href="indexadmin.php" class="back-button">&#8592; Kembali</a>
    <div class="header">Data Sparepart</div>
    <a href="tambah_sparepart_data.php" class="add-sparepart-button">Tambah Data</a>
    <div class="silver-background">
    <form action="" method="get">
        <input type="text" name="search" placeholder="Cari data...">
        <input type="submit" value="Cari">
    </form>
    <div class="silver-background">
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Sparepart</th>
            <th>Merk</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Action</th>
        </tr>
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
                echo "<td>Rp." . number_format($row["harga_sparepart"], 0, ',', '.') . ",00"."</td>";
                echo "<td><a href='edit_sparepart_data.php?id=" . $row["id_sparepart"] . "' class='edit-button'>Edit</a>";
                echo "<a href='hapus_sparepart_data.php?id=" . $row["id_sparepart"] . "' class='delete-button'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data sparepart yang ditemukan.</td></tr>";
        }
        ?>
    </table>
    </div>
    <div class="footer">Footer Content</div>
</body>
</html>

<?php
// Tutup koneksi ke database
mysqli_close($conn);
?>
