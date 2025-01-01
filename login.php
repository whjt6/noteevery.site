<?php
session_start(); // Memulai sesi untuk menyimpan data pengguna

// Cek jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "if0_37984464_note_everyday"; // Ganti dengan nama database Anda

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari form
    $inputUsername = trim($_POST['username']);
    $inputPassword = $_POST['password'];

    // Ambil data pengguna dari database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Cek apakah pengguna ada dan password cocok
    if ($user && password_verify($inputPassword, $user['password'])) {
        // Simpan data pengguna ke session
        $_SESSION['user_id'] = $user['id']; // Simpan id ke session
        $_SESSION['username'] = $user['username'];
        header("Location: view.php"); // Arahkan ke dashboard setelah login berhasil
        exit();
    } else {
        $error = "Username atau password salah.";
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Note Everyday</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
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
        .welcome-message input[type="password"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-button {
            display: flex;
            justify-content: center;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 5px; /* Mengurangi padding */
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            font-size: 14px; /* Mengurangi ukuran font */
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <h1>Login - Note Everyday</h1>
    <nav>
        <a href="index.php">Dashboard</a>
        <a href="register.php">Register</a>
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
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <div class="login-button">
                <input type="submit" value="Login">
            </div>
        </form>
        <div class="register-link">
            <p>Belum punya akun? <a href="register.php">Register</a></p>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>