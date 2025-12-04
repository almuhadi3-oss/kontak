<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Berita</title>
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

    /* ========== FOOTER SECTION ========== */
    footer {
      background: #0a3d62;
      color: white;
      text-align: center;
      padding: 2rem 1rem;
    }

    .footer-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 2rem;
    }

    .footer-content div {
      flex: 1 1 250px;
    }

    .footer-content h4 {
      margin-bottom: 0.8rem;
    }

    .footer-content a {
      color: #f8f9fa;
      text-decoration: none;
    }

    .footer-content a:hover {
      text-decoration: underline;
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

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📋 Daftar Berita</h2>
    <div>
      <a href="{{ route('berita.create') }}" class="btn btn-success">+ Tambah Berita</a>
      <a href="../myadmin.php" class="btn btn-secondary ms-2">← Kembali ke Dashboard</a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Gambar</th>
          <th>Judul</th>
          <th>Isi</th>
          <th>Tanggal Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($berita as $item)
        <tr>
          <td>
            @if($item->gambar)
              <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Berita" style="width: 80px; height: 60px; object-fit: cover;">
            @else
              <span class="text-muted">Tidak ada gambar</span>
            @endif
          </td>
          <td>{{ Str::limit($item->judul, 50) }}</td>
          <td>{{ Str::limit(strip_tags($item->isi), 100) }}</td>
          <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
          <td>
            <div class="btn-group" role="group">
              <a href="{{ route('berita.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <form method="POST" action="{{ route('berita.destroy', $item->id) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center">Belum ada berita yang ditambahkan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- ===== FOOTER SECTION ===== -->
<footer>
  <div class="footer-content">
    <!-- Alamat -->
    <div>
      <h4>Dinas Sosial Kabupaten Indragiri Hilir</h4>
      <p>
        <a
          href="https://www.google.com/maps/place/Dinas+Sosial+Kabupaten+Indragiri+Hilir,+Jl.+Bunga+No.07,+Tembilahan,+Indragiri+Hilir,+Riau+29211"
          target="_blank"
          style="color: white; text-decoration: none"
          title="Lihat lokasi di Google Maps"
        >
          Jl. Bunga Nomor 07, Tembilahan, Indragiri Hilir,
          Riau 29211
        </a>
      </p>
    </div>

    <!-- Kontak -->
    <div>
      <h4>Kontak</h4>
      <p>
        Telp: (0768) 24795 <br />
        Email:
        <a
          href="mailto:dinsosinhil@gmail.com"
          style="color: white; text-decoration: none"
          title="Kirim email ke Dinas Sosial Indragiri Hilir"
        >
          dinsosinhil@gmail.com
        </a>
      </p>
    </div>

    <!-- Media Sosial -->
    <div>
      <h4>Ikuti Kami</h4>
      <p>
        <a
          href="https://www.facebook.com/people/Dinas-Sosial-Indragiri-Hilir/100095172665432/"
          target="_blank"
          style="
            color: white;
            margin-right: 10px;
            display: inline-flex;
            align-items: center;
          "
        >
          <i
            data-feather="facebook"
            style="margin-right: 6px"
          ></i>
          Facebook
        </a>
        |
        <a
          href="https://www.instagram.com/dinassosial.inhil/"
          target="_blank"
          style="
            color: white;
            margin-left: 10px;
            display: inline-flex;
            align-items: center;
          "
        >
          <i
            data-feather="instagram"
            style="margin-right: 6px"
          ></i>
          Instagram
        </a>
      </p>
    </div>
  </div>

  <p style="margin-top: 1rem; font-size: 0.9rem">
    © 2025 Dinas Sosial Kabupaten Indragiri Hilir. All Rights Reserved.
  </p>
</footer>

<script>
// Replace icons
if (window.feather) {
  feather.replace();
}

// Navbar toggle untuk mobile (safety null checks)
const menuToggle = document.querySelector(".menu-toggle");
const navbar = document.querySelector(".navbar");
if (menuToggle && navbar) {
  menuToggle.addEventListener("click", () => {
    navbar.classList.toggle("active");
  });
}
</script>

</body>
</html>
