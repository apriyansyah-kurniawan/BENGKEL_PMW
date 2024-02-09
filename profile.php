<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

// Function to update customer data
function updateCustomerData($conn, $id_pelanggan, $nama, $username, $password, $alamat, $nohp) {
    // Sanitize inputs to prevent SQL injection
    $id_pelanggan = $conn->real_escape_string($id_pelanggan);
    $nama = $conn->real_escape_string($nama);
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);
    $alamat = $conn->real_escape_string($alamat);
    $nohp = $conn->real_escape_string($nohp);

    // Update customer data in the database
    $sql = "UPDATE customers SET nama = '$nama', username = '$username', password = '$password', alamat = '$alamat', nohp = '$nohp' WHERE id_pelanggan = '$id_pelanggan'";

    if ($conn->query($sql) === TRUE) {
        echo "Customer data updated successfully.";
    } else {
        echo "Error updating customer data: " . $conn->error;
    }
}

// Get the customer data from the database based on the logged-in username
$logged_in_username = $_SESSION['username'];
$sql = "SELECT * FROM customers WHERE username = '$logged_in_username' LIMIT 1";
$result = $conn->query($sql);

// Check if the customer data exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_pelanggan = $row['id_pelanggan'];
    $nama = $row['nama'];
    $username = $row['username'];
    $password = $row['password'];
    $alamat = $row['alamat'];
    $nohp = $row['nohp'];
} else {
    echo "Customer data not found.";
    exit();
}

// Check if the form was submitted for updating customer data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nohp'];

    // Call the function to update customer data
    updateCustomerData($conn, $id_pelanggan, $nama, $username, $password, $alamat, $nohp);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            padding: 40px;
            background-color: lightblue;
            height: 500px; 
        }
        

        header {
            background-color: #007BFF;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Add this rule to change the text color to white */
        header h1 {
            color: #fff;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .back-button {
            color: #007BFF;
            font-size: 16px;
            text-decoration: none;
        }

        .back-button:hover {
            text-decoration: underline;
        }

        h1 {
            margin-top: 0;
            color: #007BFF;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .profile-info {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 15px;
        }

        .profile-info b {
            font-weight: bold;
            color: #555;
        }

        .profile-info p {
            margin: 10px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $nama; ?>!</h1>
    </header>
    <div class="container">
        <a href="index.php" class="back-button">&#8592; Kembali</a>
        <div class="profile-info">
            <p><b>Nama:</b> <?php echo $nama; ?></p>
            <p><b>Username:</b> <?php echo $username; ?></p>
            <p><b>Password:</b> <?php echo $password; ?></p>
            <p><b>Alamat:</b> <?php echo $alamat; ?></p>
            <p><b>Nomor Hp:</b> <?php echo $nohp; ?></p>
        </div>
        <h1>Edit Profile</h1>
        <form method="post" action="">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" value="<?php echo $nama; ?>"><br>

            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo $username; ?>"><br>

            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo $password; ?>"><br>

            <label for="alamat">Alamat:</label>
            <input type="text" name="alamat" value="<?php echo $alamat; ?>"><br>

            <label for="nohp">No. HP:</label>
            <input type="text" name="nohp" value="<?php echo $nohp; ?>"><br>
            <br>
            <input type="submit" name="submit" value="Update">
        </form>
    </div>
</body>
</html>

