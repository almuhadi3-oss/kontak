<?php
// Start session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Dinas Sosial</title>
    <link rel="icon" href="gambar/logodinassosial.png">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        /* ========== GLOBAL STYLES ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body {
            color: #222;
            background: #f8f9fa;
            line-height: 1.6;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        img {
            max-width: 100%;
            border-radius: 8px;
        }

        /* ========== HEADER SECTION ========== */
        header {
            border-top: 5px solid #0a3d62;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 2rem;
            flex-wrap: wrap;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo-area img {
            width: 80px;
            height: 70px;
        }

        .header-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #0a3d62;
        }

        .search-wrapper input {
            padding: 0.4rem 0.8rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 300px;
        }

        nav {
            background: #0a3d62;
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            padding: 0.8rem 1rem;
            list-style: none;
        }

        .navbar a {
            color: #fff;
            font-weight: 500;
        }

        .menu-toggle {
            display: none;
            color: rgb(36, 8, 244);
            cursor: pointer;
            size: 1.5rem;
        }

        @media (max-width: 768px) {
            .navbar {
                display: none;
                flex-direction: column;
                background: #0a3d62;
            }
            .navbar.active {
                display: flex;
            }
            .menu-toggle {
                display: block;
                position: absolute;
                top: 18px;
                right: 20px;
            }
            .search-wrapper input {
                width: 100%;
                margin-top: 0.5rem;
            }
        }

        /* ========== DASHBOARD CONTENT ========== */
        .dashboard {
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard h1 {
            text-align: center;
            color: #0a3d62;
            margin-bottom: 2rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .dashboard-card {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .dashboard-card h3 {
            color: #0a3d62;
            margin-bottom: 1rem;
        }

        .dashboard-card p {
            margin-bottom: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            background: #0a3d62;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #1e90ff;
        }

        .logout {
            text-align: center;
            margin-top: 2rem;
        }

        .logout a {
            color: #0a3d62;
            font-weight: 500;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- ===== HEADER SECTION ===== -->
    <header>
        <div class="header-top">
            <div class="logo-area">
                <img src="gambar/KAB.Inhil.jpg" alt="Logo Kabupaten Indragiri Hilir" />
                <img src="gambar/KEMENSOS.jpg" alt="Logo Kementerian Sosial" />
                <img src="gambar/berakhlak.png" alt="Logo Berakhlak" />
                <img src="gambar/bangga.png" alt="Logo Bangga" />
                <span class="header-title">Dinas Sosial Kabupaten Indragiri Hilir</span>
            </div>
            <div class="search-wrapper">
                <input type="text" placeholder="Cari berita dan layanan..." />
            </div>
            <i data-feather="menu" class="menu-toggle"></i>
        </div>
        <nav>
            <ul class="navbar">
                <li><a href="index.html">Beranda</a></li>
                <li><a href="layanan.html">Layanan</a></li>
                <li><a href="berita.html">Berita</a></li>
                <li><a href="profil.html">Profil</a></li>
                <li><a href="kontak.html">Kontak</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>

    <!-- ===== DASHBOARD CONTENT ===== -->
    <section class="dashboard">
        <h1>Selamat Datang di Dashboard Admin</h1>
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Kelola Pengaduan</h3>
                <p>Lihat dan kelola pengaduan masyarakat yang masuk.</p>
                <button class="btn" onclick="location.href='/admin/pengaduan'">Lihat Pengaduan</button>
            </div>
            <div class="dashboard-card">
                <h3>Kelola Berita</h3>
                <p>Tambah, edit, atau hapus berita terbaru.</p>
                <button class="btn" onclick="location.href='/admin/berita'">Kelola Berita</button>
            </div>
            <div class="dashboard-card">
                <h3>Statistik</h3>
                <p>Lihat statistik pengaduan dan layanan.</p>
                <button class="btn">Lihat Statistik</button>
            </div>
            <div class="dashboard-card">
                <h3>Pengaturan</h3>
                <p>Konfigurasi pengaturan sistem.</p>
                <button class="btn">Pengaturan</button>
            </div>
        </div>
        <div class="logout">
            <a href="admin.php?logout=true">&larr; Logout</a>
        </div>
    </section>

    <script>
        feather.replace();
        const menuToggle = document.querySelector(".menu-toggle");
        const navbar = document.querySelector(".navbar");
        menuToggle.addEventListener("click", () => {
            navbar.classList.toggle("active");
        });
    </script>
</body>
</html>
