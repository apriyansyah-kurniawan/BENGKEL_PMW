<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username_admin'])) {
  header("Location: loginadmin.php");
}
// Query untuk mendapatkan data 
// $sql = "SELECT * from pemesanan";
// $sql = "SELECT t.*, p.harga_layanan, p.jenis_layanan, s.harga_sparepart, s.nama_sparepart 
//         FROM layanan AS p 
//         LEFT JOIN pemesanan AS t ON p.id_layanan = t.id_layanan
//         RIGHT JOIN sparepart AS s ON t.id_sparepart = s.id_sparepart";
// $sql = "SELECT p.*,s.harga_sparepart, s.nama_sparepart 
//          FROM sparepart AS s
//          INNER JOIN pemesanan AS p ON s.id_sparepart = p.id_sparepart";
// $sql = "SELECT t.*, p.harga_layanan, p.jenis_layanan
//          FROM layanan AS p 
//          INNER JOIN pemesanan AS t ON p.id_layanan = t.id_layanan";
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
        'pesanan diproses' => 'Pesanan Diproses',
        'pesanan acc' => 'Pesanan Acc'
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
    <a href="indexadmin.php" class="back-button">&#8592; Kembali</a>
    <h2>Data Pemesanan</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>ID Pelanggan</th>
            <th>ID Layanan</th>
            <th>Nama Layanan</th>
            <th>ID Sparepart</th>
            <th>Nama Sparepart</th>
            <th>Tanggal Pemesanan</th>
            <th>harga_layanan</th>
            <th>harga sparepart</th>
            <th>Status</th>
        </tr>
        <?php
        // Associative array to store the grouped data
$grouped_data = array();

// Loop through the result and group the data by id_pelanggan
while ($row = mysqli_fetch_assoc($result)) {
    $id_pelanggan = $row["id_pelanggan"];

    // Check if the id_pelanggan is already in the grouped_data array
    if (isset($grouped_data[$id_pelanggan])) {
        // If it exists, add the data to the existing row
        $grouped_data[$id_pelanggan]["jenis_layanan"] .= ", " . $row["jenis_layanan"];
        $grouped_data[$id_pelanggan]["nama_sparepart"] .= ", " . $row["nama_sparepart"];
    } else {
        // If it doesn't exist, create a new row in the grouped_data array
        $grouped_data[$id_pelanggan] = array(
            "id_pelanggan" => $row["id_pelanggan"],
            "id_layanan" => $row["id_layanan"],
            "jenis_layanan" => $row["jenis_layanan"],
            "id_sparepart" => $row["id_sparepart"],
            "nama_sparepart" => $row["nama_sparepart"],
            "tanggal_pemesanan" => $row["tanggal_pemesanan"],
            "harga_layanan" => $row["harga_layanan"],
            "harga_sparepart" => $row["harga_sparepart"],
            "status_pemesanan" => $row["status_pemesanan"]
        );
    }
}

// Rendering the table with grouped rows
if (count($grouped_data) > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>ID Pelanggan</th>";
    echo "<th>ID Layanan</th>";
    echo "<th>Nama Layanan</th>";
    echo "<th>ID Sparepart</th>";
    echo "<th>Nama Sparepart</th>";
    echo "<th>Tanggal Pemesanan</th>";
    echo "<th>harga_layanan</th>";
    echo "<th>harga sparepart</th>";
    echo "<th>Status</th>";
    echo "</tr>";

    foreach ($grouped_data as $row) {
        echo "<tr>";
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
        echo '<input type="submit" value="Update">';
        echo '</form>'."</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Tidak ada data pemesanan yang ditemukan.";
}
        ?>
    </table>
</body>
</html>

<?php
// Tutup koneksi ke database
mysqli_close($conn);
?>
