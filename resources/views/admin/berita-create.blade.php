<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Berita - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
      object-fit: contain;
    }

    .header-title {
      font-size: 1.8rem;
      font-weight: 600;
      color: #0a3d62;
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
    }

    /* ========== FORM STYLES ========== */
    .form-container {
      max-width: 800px;
      margin: 2rem auto;
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #0a3d62;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 1rem;
    }

    .form-group textarea {
      min-height: 200px;
      resize: vertical;
    }

    .btn {
      padding: 0.75rem 2rem;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn-primary {
      background: #0a3d62;
      color: #fff;
    }

    .btn-primary:hover {
      background: #1e90ff;
    }

    .btn-secondary {
      background: #6c757d;
      color: #fff;
    }

    .btn-secondary:hover {
      background: #5a6268;
    }

    .image-preview {
      max-width: 200px;
      max-height: 200px;
      object-fit: cover;
      border: 1px solid #ddd;
      border-radius: 6px;
      margin-top: 0.5rem;
    }
  </style>
</head>
<body>
  <!-- ===== HEADER SECTION ===== -->
  <header>
    <div class="header-top">
      <div class="logo-area">
        <img src="{{ asset('gambar/KAB.Inhil.jpg') }}" alt="Logo Kabupaten Indragiri Hilir" />
        <img src="{{ asset('gambar/KEMENSOS.jpg') }}" alt="Logo Kementerian Sosial" />
        <img src="{{ asset('gambar/berakhlak.png') }}" alt="Logo Berakhlak" />
        <img src="{{ asset('gambar/bangga.png') }}" alt="Logo Bangga" />
        <span class="header-title">Dinas Sosial Kabupaten Indragiri Hilir</span>
      </div>
      <i data-feather="menu" class="menu-toggle"></i>
    </div>
    <nav>
      <ul class="navbar">
        <li><a href="../index.html">Beranda</a></li>
        <li><a href="../layanan.html">Layanan</a></li>
        <li><a href="../berita.html">Berita</a></li>
        <li><a href="../profil.html">Profil</a></li>
        <li><a href="../kontak.html">Kontak</a></li>
        <li><a href="../admin.php">Admin</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <div class="form-container">
      <h2 class="mb-4">Tambah Berita Baru</h2>

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label for="judul">Judul Berita *</label>
          <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required>
        </div>

        <div class="form-group">
          <label for="isi">Isi Berita *</label>
          <textarea id="isi" name="isi" required>{{ old('isi') }}</textarea>
        </div>

        <div class="form-group">
          <label for="gambar">Gambar Berita</label>
          <input type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
          <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.</small>
          <img id="imagePreview" class="image-preview" style="display: none;" alt="Preview Gambar">
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Simpan Berita</button>
          <a href="{{ route('berita.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    feather.replace();

    // Navbar toggle
    const menuToggle = document.querySelector(".menu-toggle");
    const navbar = document.querySelector(".navbar");
    if (menuToggle && navbar) {
      menuToggle.addEventListener("click", () => {
        navbar.classList.toggle("active");
      });
    }

    // Image preview
    function previewImage(event) {
      const file = event.target.files[0];
      const preview = document.getElementById('imagePreview');

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        preview.style.display = 'none';
      }
    }
  </script>
</body>
</html>
