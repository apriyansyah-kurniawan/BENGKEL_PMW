<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}
?>

<html>
    <head>
        <title>BENGKEL</title>
        <link rel="stylesheet" href="style2.css" />
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
                    <a href="index.php" class="a-navbar">Home</a>
                    <!-- pagar berarti kalau ditekan akan gak kemana" -->
                </li>
                <li class="li-navbar">
                    <a href="About.php" class="a-navbar">About</a>
                </li>
                <li class="li-navbar">
                    <a href="input_sparepart.php" class="a-navbar">Shop</a>
                </li>
                <li class="li-navbar">
                    <a href="Checkout.php" class="a-navbar">
                        <img src="shopicon.png" alt="ShopIcon" class="icon-img">
                    </a>
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
            <ul class="tabelbook">
                <P><b>KAMU MEMPUNYAI MASALAH MOBIL ?</b></P>
                <li class="li-isi1">
                    <a href="input_layanan.php" class="a-navbar">Book Now</a>
                </li>
                <li class="li-isi1">
                    <a>    
                        <b>Call Us</b>
                    </a>
                </li>
            </ul>
            <img src="bengkel2.png" alt="gambar isi" class="isi-gambar"/>
            <uL class="tabel-gambar">
                <li class="li-tulisan">
                    <P><b>KENAPA ANDA HARUS MEMILIH KAMI ?</b></P>
                </li>

                <li class="li-isi">
                    <a>    
                        <img src="icons8-mechanic-64.png" alt="gambar isi">
                        <b><br>MEKANIK BERPENGALAMAN<br><br>
                            Mekanik kami sudah mempunyai jam terbang lama dan mempunyai <br>
                            sertifikat BNSP, sehingga terjamin <br>
                            perbaikan mobil anda</b>
                    </a>
                </li>
                <li class="li-isi">
                    <a> 
                        <img src="icon8-support.png" alt="gambar isi">
                        <b><br>PELAYANAN TERBAIK<br><br>
                            Kami mendapatkan pelayanan terbaik dari karyawan kami</b>
                    </a>
                </li>
               
                <li class="li-isi">
                    <a>
                        <img src="icons8-towing-service-78.png" alt="gambar isi">
                        <b><br>MONTIR PANGGILAN<br><br>
                            MAGER KELUAR RUMAH?<br>
                            Kami bisa menjemput mobil anda <br>
                            dimanapun kapanpun</b>
                    </a>
                </li>

                <li class="li-isi">
                    <a>
                        <img src="icons8-cost-64.png" alt="gambar isi">
                        <b><br>BIAYA TERJANGKAU<br><br>
                            Di tempat kami, biaya service dan<br> 
                            perawatan <br>sangat terjangkau sehingga pelanggan <br>
                            masih tetap mendapatkan pelayanan <br>
                            terbaik</b>
                    </a>
                </li>
            </uL>
        </div>
        <!-- CONTENT ISI SELESAI -->
        
        <div id="sidebar">
                <ul class="sidebar-menu">
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
    </body>
</html>