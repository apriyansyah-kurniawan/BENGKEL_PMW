<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['layanan']) && is_array($_POST['layanan']) && count($_POST['layanan']) > 0) {
        // Assuming the 'username' column in your customers table is used to identify the customer
        $username = $_SESSION['username'];
        
        // Retrieve the customer's ID based on the username
        $sql_get_id = "SELECT id_pelanggan FROM customers WHERE username = '$username'";
        $result_get_id = mysqli_query($conn, $sql_get_id);
        
        if (!$result_get_id || mysqli_num_rows($result_get_id) == 0) {
            // Handle the error if the username is not found (you can customize the error handling based on your needs)
            echo "Error: Username not found.";
            exit;
        }
        
        $row = mysqli_fetch_assoc($result_get_id);
        $id_pelanggan = $row['id_pelanggan'];
        // Get the current date
        $tanggal_pemesanan = date('Y-m-d');

        // Loop through the selected layanan and insert them into the pemesanan table
        foreach ($_POST['layanan'] as $id_layanan) {
            $sql = "INSERT INTO pemesanan (id_pelanggan, id_layanan, tanggal_pemesanan) VALUES ('$id_pelanggan', '$id_layanan','$tanggal_pemesanan')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                // Handle the error if the insertion fails (you can customize the error handling based on your needs)
                echo "Error: " . mysqli_error($conn);
                exit;
            }
        }
        // Redirect to the success page or any other desired page after successful insertion
        header("Location: input_layanan.php"); // Replace 'success_page.php' with the desired destination page
        exit;
    } else {
        // Redirect to the error page or any other desired page if no layanan is selected
        header("Location: error_page.php"); // Replace 'error_page.php' with the desired destination page
        exit;
    }
}
?>
