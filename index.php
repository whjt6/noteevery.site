<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Note Everyday</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            position: relative; /* Memungkinkan penempatan absolut untuk menu */
        }
        h1 {
            color: #4CAF50;
            font-size: 2.5em;
            text-align: center;
            margin: 20px 0; /* Menambahkan jarak atas dan bawah untuk judul */
        }
        nav {
            margin: 20px 0; /* Menambahkan margin atas dan bawah untuk jarak */
            text-align: center; /* Memastikan teks di tengah */
        }
        nav a {
            margin: 0 15px; /* Memberi jarak horizontal antar tautan */
            text-decoration: none;
            color: #4CAF50;
            padding: 10px; /* Memberi ruang dalam pada tautan */
            display: inline-block; /* Membuat tautan memiliki lebar sesuai konten */
        }
        nav a:hover {
            text-decoration: underline;
            color: #333;
        }
        .menu-toggle {
            cursor: pointer;
            font-size: 24px;
            background-color: transparent; /* Membuat latar belakang transparan */
            color: #4CAF50; /* Warna teks */
            padding: 10px; /* Ruang dalam */
            position: absolute; /* Memungkinkan posisi bebas */
            top: 20px; /* Sesuaikan dengan tinggi judul */
            right: 20px; /* Menempatkan di kanan */
        }
        .dropdown-menu {
            display: none; /* Menu tidak terlihat secara default */
            position: absolute;
            right: 20px; /* Menempatkan dropdown sejajar dengan tombol */
            top: 60px; /* Mengatur posisi dropdown di bawah tombol */
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            padding: 10px; /* Ruang dalam untuk dropdown */
            width: 150px; /* Mengatur lebar dropdown */
            text-align: center; /* Mengatur teks agar berada di tengah */
        }
        .dropdown-menu a {
            display: block; /* Mengatur agar tautan ditampilkan vertikal */
            padding: 10px; /* Ruang dalam yang konsisten */
            text-decoration: none;
            color: black;
            width: 100%; /* Memastikan tautan mengambil lebar penuh */
            box-sizing: border-box; /* Menyertakan padding dalam perhitungan lebar */
            margin: 5px 0; /* Menambahkan jarak vertikal antar tautan */
        }
        .dropdown-menu .menu-title {
            display: flex; /* Menggunakan flexbox untuk penataan */
            align-items: center; /* Menengah vertikal */
            justify-content: center; /* Menengah horizontal */
            margin-bottom: 10px; /* Jarak bawah */
            color: #4CAF50; /* Warna teks */
        }
        .back-icon {
            margin-right: 10px; /* Jarak antara ikon dan judul */
            cursor: pointer; /* Menunjukkan bahwa ikon dapat diklik */
        }
        .color-option {
            margin: 5px;
            cursor: pointer;
            padding: 5px;
            text-align: center; /* Mengatur teks agar berada di tengah */
            opacity: 0.7; /* Mengurangi opasitas untuk efek tipis */
        }
        .color-option:hover {
            opacity: 1; /* Menambahkan efek hover untuk menonjolkan warna */
        }
        /* Warna cerah untuk opsi tema */
        .color-option.original {
            background-color: #f4f4f4; /* Warna semula */
        }
        .color-option.blue {
            background-color: #90caf9; /* Biru lebih tipis */
        }
        .color-option.red {
            background-color: #ff8a80; /* Merah lebih tipis */
        }
        .color-option.yellow {
            background-color: #ffe57f; /* Kuning lebih tipis */
        }
        .welcome-message {
            max-width: 600px; /* Mengatur lebar maksimal */
            margin: 20px auto; /* Menambahkan margin otomatis untuk tengah */
            padding: 15px; /* Mengurangi ruang dalam */
            background-color: #e7f5e1; /* Latar belakang sambutan */
            border: 1px solid #4CAF50; /* Garis batas */
            border-radius: 5px; /* Sudut membulat */
            text-align: left; /* Mengatur teks rata kiri */
        }
        footer {
            text-align: center; /* Rata tengah */
            margin-top: 20px; /* Jarak atas */
            padding: 10px; /* Ruang dalam */
            background-color: #4CAF50; /* Latar belakang hijau */
            color: white; /* Warna teks putih */
            border-radius: 5px; /* Sudut membulat */
        }
    </style>
</head>
<body>
    <h1>Note Everyday</h1>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
    <nav>
        <a href="index.php">Dashboard</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="create.php">Add Note</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
    <div class="dropdown-menu" id="dropdownMenu">
        <div class="menu-title">
            <span class="back-icon" onclick="window.location.href='index.php'">🔙</span>
            Note Everyday
        </div>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <div style="cursor: pointer; margin: 5px 0;" onclick="showColorOptions()">Tema</div>
        <div id="colorOptions" style="display:none;">
            <div class="color-option original" onclick="changeBackgroundColor('')">Warna Semula</div>
            <div class="color-option blue" onclick="changeBackgroundColor('blue')">Biru</div>
            <div class="color-option red" onclick="changeBackgroundColor('red')">Merah</div>
            <div class="color-option yellow" onclick="changeBackgroundColor('yellow')">Kuning</div>
        </div>
    </div>
    <div class="welcome-message">
        <p>Selamat datang di Note Everyday!</p>
        <p>Kami senang Anda bergabung dengan komunitas kami. Di Note Everyday, kami percaya bahwa setiap catatan adalah langkah menuju produktivitas dan kreativitas.</p>
        <p><strong>Catatan Penting:</strong><br>
        Sebelum Anda dapat membuat catatan pribadi Anda, harap lakukan registrasi atau login ke akun Anda. Ini akan memastikan bahwa semua catatan Anda aman dan dapat diakses kapan saja.</p>
        <p><strong>Langkah-langkah:</strong><br>
        Registrasi: Jika Anda pengguna baru, klik tombol "Daftar" dan ikuti instruksi untuk membuat akun.<br>
        Login: Jika Anda sudah memiliki akun, masukkan detail login Anda untuk Dapat membuat cataran anda.</p>
        <p>Setelah masuk, Anda akan dapat mulai mencatat ide, tugas, dan hal-hal penting lainnya dengan aman. Terima kasih telah memilih Note Everyday!</p>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function toggleMenu() {
            var menu = document.getElementById('dropdownMenu');
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }

        function showColorOptions() {
            var colorOptions = document.getElementById('colorOptions');
            colorOptions.style.display = (colorOptions.style.display === 'none') ? 'block' : 'none';
        }

        function changeBackgroundColor(color) {
            if (color === 'blue') {
                document.body.style.backgroundColor = '#90caf9'; // Biru lebih tipis
            } else if (color === 'red') {
                document.body.style.backgroundColor = '#ff8a80'; // Merah lebih tipis
            } else if (color === 'yellow') {
                document.body.style.backgroundColor = '#ffe57f'; // Kuning lebih tipis
            } else {
                document.body.style.backgroundColor = '#f4f4f4'; // Warna semula
            }
        }
    </script>
</body>
</html>