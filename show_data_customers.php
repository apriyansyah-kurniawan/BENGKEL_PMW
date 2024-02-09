<?php
include 'koneksi.php';

// Query untuk mendapatkan data admin
$sql = "SELECT * FROM customers";
// Handle the search query if the user submitted it
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Modify the SQL query to include the search condition
    $sql = "SELECT * FROM customers WHERE 
            nama LIKE '%$searchTerm%' OR 
            username LIKE '%$searchTerm%' OR 
            nohp LIKE '%$searchTerm%'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Data Customers</title>
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

        /* Gaya untuk tombol Edit */
        .back-button {
        background: none;
        color: #000;
        border: none;
        padding: 0;
        font-size: 16px;
        cursor: pointer;
        text-decoration: underline;
        float: left;
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
        .add-customers-button {
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
    <h2>Data Customers</h2>
    <a href="tambah_customers_data.php" class="add-customers-button">Tambah Data</a>
    <form action="" method="get">
        <input type="text" name="search" placeholder="Cari data...">
        <input type="submit" value="Cari">
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Password</th>
            <th>Alamat</th>
            <th>Nomor Hp</th>
            <th>Action</th>
        </tr>
        <?php
        // Periksa hasil query
        if (mysqli_num_rows($result) > 0) {
            // Loop melalui setiap baris data dan tampilkan
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id_pelanggan"] . "</td>";
                echo "<td>" . $row["nama"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["password"] . "</td>";
                echo "<td>" . $row["alamat"] . "</td>";
                echo "<td>" . $row["nohp"] . "</td>";
                echo "<td><a href='edit_customers_data.php?id=" . $row["id_pelanggan"] . "' class='edit-button'>Edit</a>";
                echo "<a href='hapus_customers_data.php?id=" . $row["id_pelanggan"] . "' class='delete-button'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data customers yang ditemukan.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Tutup koneksi ke database
mysqli_close($conn);
?>
