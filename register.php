<?php
// Cek jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "if0_37984464_note_everyday";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Enkripsi password

    // Masukkan data ke database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // Jika pendaftaran berhasil, arahkan ke halaman login
        header("Location: login.php?message=Registrasi berhasil, silakan login.");
        exit();
    } else {
        $error = "Gagal mendaftar: " . $stmt->error;
    }

    // Tutup koneksi
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Note Everyday</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            position: relative;
        }
        h1 {
            color: #4CAF50;
            font-size: 2.5em;
            text-align: center;
            margin: 20px 0;
        }
        nav {
            margin: 20px 0;
            text-align: center;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #4CAF50;
            padding: 10px;
            display: inline-block;
        }
        nav a:hover {
            text-decoration: underline;
            color: #333;
        }
        .menu-toggle {
            cursor: pointer;
            font-size: 24px;
            background-color: transparent;
            color: #4CAF50;
            padding: 10px;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .welcome-message {
            max-width: 400px;
            margin: 20px auto;
            padding: 15px;
            background-color: #e7f5e1;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            text-align: left;
        }
        .welcome-message input[type="text"],
        .welcome-message input[type="password"],
        .welcome-message input[type="email"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .register-button {
            display: flex;
            justify-content: center; /* Menempatkan tombol di tengah */
        }
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Register - Note Everyday</h1>
    <nav>
        <a href="index.php">Dashboard</a>
        <a href="login.php">Login</a>
    </nav>
    <div class="welcome-message">
        <?php
        if (isset($error)) {
            echo "<p style='color: red;'>$error</p>";
        }
        ?>
        <form action="" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <div class="register-button">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>

    <script>
        function toggleMenu() {
            var menu = document.getElementById('dropdownMenu');
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>