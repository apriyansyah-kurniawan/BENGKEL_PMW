<?php
// GA DIPAKAI KAYAKNYA
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username_admin'])) {
    header("Location: loginadmin.php");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID of the pemesanan
    $id_pemesanan = $_POST["id_pemesanan"];
    
    // Get the new status value from the form
    $new_status = $_POST["status"];

    // Update the status value in the database
    $update_sql = "UPDATE pemesanan SET status_pemesanan = '$new_status' WHERE id_pemesanan = '$id_pemesanan'";
    if (mysqli_query($conn, $update_sql)) {
        // Redirect back to the page after updating the status
        header("Location: pemesanan.php");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

// Query to get data from the pemesanan table
$sql = "SELECT * from pemesanan";
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
?>

