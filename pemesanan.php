<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username_admin'])) {
  header("Location: loginadmin.php");
}
// Query untuk mendapatkan data 

$sql1 = "SELECT p.*, s.harga_sparepart, s.nama_sparepart, NULL AS harga_layanan, NULL AS jenis_layanan
         FROM sparepart AS s
         INNER JOIN pemesanan AS p ON s.id_sparepart = p.id_sparepart";

$sql2 = "SELECT t.*, NULL AS harga, NULL AS nama_sparepart, l.harga_layanan, l.jenis_layanan
         FROM layanan AS l 
         INNER JOIN pemesanan AS t ON l.id_layanan = t.id_layanan";

$sql = "$sql1 UNION $sql2";


$result = mysqli_query($conn, $sql);

// Function to generate the status options dropdown
function generateStatusOptions($currentStatus) {
    $options = array(
        'tolak pemesanan' => 'Tolak Pemesanan',
        'pesanan acc' => 'Pesanan Acc',
        'pesanan diproses' => 'Pesanan Diproses',
        'pesanan sudah selesai' => 'Pesanan sudah selesai'
    );

    $select = '<select name="status">';
    foreach ($options as $value => $label) {
        $selected = ($value == $currentStatus) ? 'selected' : '';
        $select .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
    }
    $select .= '</select>';

    return $select;
}

// Process form submission to update status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_pemesanan"]) && isset($_POST["status"])) {
        $id_pemesanan = $_POST["id_pemesanan"];
        $status = $_POST["status"];

        // Update status in the database
        $update_query = "UPDATE pemesanan SET status_pemesanan = '$status' WHERE id_pemesanan = $id_pemesanan";
        if (mysqli_query($conn, $update_query)) {
            // Status updated successfully
            header("Location: pemesanan.php"); // Replace "this_page.php" with the filename of this PHP file
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Data Pemesanan</title>
    <style>
        /* Background */
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header */
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }

        /* Footer */
        footer {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

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

        .back-button {
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

        /* Gaya untuk tombol Edit dan Hapus */
        .action-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 6px 12px; /* Mengurangi ukuran padding */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px; /* Mengurangi ukuran font */
            margin: 2px;
            cursor: pointer;
        }

        .action-button.delete-button {
            background-color: #f44336;
        }

        /* Gaya untuk tombol Tambah Admin */
        .add-pemesanan-button {
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
    <header>
        <h1>Data Pemesanan</h1>
    </header>

    <a href="indexadmin.php" class="back-button">&#8592; Kembali</a>

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
            <th>Actions</th>
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
                // Display the dropdown selection for status within a form
                echo "<td>".'<form method="post">';
                echo '<input type="hidden" name="id_pemesanan" value="' . $row["id_pemesanan"] . '">';
                echo generateStatusOptions($row["status_pemesanan"]);
                echo '<input type="submit" value="Update" class="action-button">';
                echo '</form>'."</td>";

                // Add Edit and Delete buttons
                echo "<td>";
                echo '<a href="#" class="action-button">Edit</a>';
                echo '<a href="#" class="action-button delete-button">Delete</a>';
                echo "</td>";

                echo "</tr>";
            }
            
        } else {
            echo "<tr><td colspan='7'>Tidak ada data pemesanan yang ditemukan.</td></tr>";
        }
        ?>
    </table>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> All rights reserved.</p>
    </footer>
</body>
</html>


<?php
// Tutup koneksi ke database
mysqli_close($conn);
?>
