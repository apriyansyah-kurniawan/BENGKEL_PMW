<?php
session_start();
if (!isset($_SESSION['username_admin'])) {
  header("Location: loginadmin.php");
}
?>

<html>
    <head>
        <title>BENGKEL</title>
        <link rel="stylesheet" href="style7.css" />
        <link rel="stylesheet" href="sidebar.css" />
        <script>
            function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("active");
            }
            window.addEventListener("mouseup", function(event) {
                var sidebar = document.getElementById("sidebar");
                var toggleButton = document.querySelector(".a-navbar img[src='profile.png']");
                
                // Cek apakah mouse berada di luar area sidebar atau toggleButton
                if (event.target !== sidebar && event.target !== toggleButton && !sidebar.contains(event.target)) {
                    sidebar.classList.remove("active");
                }
            });
        </script>
        
    </head>
    <body>
        <!-- NAVBAR -->
        <div class="container-navbar">
            <img src="wijaya mandiri white.png" alt="LogoIcon" class="logo-img">

            <uL class="ul-navbar">
                <li class="li-navbar">
                    <a href="show_data_layanan.php" class="a-navbar">Layanan</a>
                </li>
                <li class="li-navbar">
                    <a href="show_data_sparepart.php" class="a-navbar">Sparepart</a>
                </li>
                <li class="li-navbar">
                    <a href="Pemesanan.php" class="a-navbar">Pemesanan</a>
                </li>
                <li class="li-navbar">
                    <a href="transaksi.php" class="a-navbar">Transaksi</a>
                </li>
                <li class="li-navbar">
                    <a href="#" class="a-navbar" onclick="toggleSidebar()">
                        <img src="profile.png" alt="ProfileIcon" class="icon-img">
                    </a>
                </li>
            </uL>
        </div>
        <!-- NAVBAR SELESAI -->

        <!-- CONTENT ISI -->
        <div id="scroll-content">
            <img src="bengkel2.png" alt="gambar isi" class="isi-gambar"/>
            <div id="sidebar">
                <ul class="sidebar-menu">
                    <li><a href="show_data_admin.php">Show Data Admin</a></li>
                    <li><a href="show_data_customers.php">Show Data Pelanggan</a></li>
                    <li><a href="logoutadmin.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <!-- CONTENT ISI SELESAI -->
    </body>
</html>