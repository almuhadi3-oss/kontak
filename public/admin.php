<?php
// Start session
session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit();
}

// Handle authentication before any output
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple authentication (replace with secure method in production)
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: myadmin.php');
        exit();
    } else {
        $error_message = '<p style="color: red; text-align: center;">Username atau password salah!</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Dinas Sosial</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
            position: fixed;
            top: 0;
            width: 100%;
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

        /* ========== LOGIN FORM ========== */
        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin-top: 100px; /* Adjust for fixed header */
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #0a3d62;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
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

        .back-link {
            text-align: center;
            margin-top: 1rem;
        }

        .back-link a {
            color: #0a3d62;
            font-weight: 500;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- ===== HEADER SECTION ===== -->
    <header>
        <div class="header-top">
            <div class="logo-area">
                <img src="gambar/KAB.Inhil.jpg" alt="Logo Dinas Sosial" />
                <img src="gambar/KEMENSOS.jpg" alt="Logo Dinas Sosial" />
                <img src="gambar/berakhlak.png" alt="Logo Dinas Sosial" />
                <img src="gambar/bangga.png" alt="Logo Dinas Sosial" />
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

    <!-- ===== LOGIN FORM ===== -->
    <div class="login-container">
        <h2>Login Admin</h2>
        <?php echo $error_message; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="back-link">
            <a href="index.html">&larr; Kembali ke Beranda</a>
        </div>
    </div>

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
