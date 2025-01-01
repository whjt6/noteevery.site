<?php
session_start();
include 'db.php';

// Cek jika pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Arahkan ke login jika pengguna belum login
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $created_at = date("Y-m-d H:i:s");
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session

    // Siapkan dan eksekusi pernyataan untuk menyimpan catatan
    $stmt = $conn->prepare("INSERT INTO entries (user_id, title, content, created_at) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("isss", $user_id, $title, $content, $created_at);

        if ($stmt->execute()) {
            // Ambil ID catatan yang baru dibuat
            $entry_id = $stmt->insert_id;
            // Redirect ke halaman hasil catatan setelah berhasil menambahkan catatan
            header("Location: view.php?id=" . $entry_id);
            exit(); // Tambahkan exit setelah redirect
        } else {
            // Jika gagal, tampilkan error
            $error = "Gagal menambahkan catatan: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Pernyataan gagal disiapkan: " . $conn->error;
    }
}

include 'header.php';
?>

<h2>Buat Catatan Baru</h2>
<div class="form-container">
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>"; // Tampilkan pesan error jika ada
    }
    ?>
    <form method="post">
        <table>
            <tr>
                <td>Judul:</td>
                <td><input type="text" name="title" required></td>
            </tr>
            <tr>
                <td>Konten:</td>
                <td><textarea name="content" required></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit">Tambah</button></td>
            </tr>
        </table>
    </form>
</div>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    h2 {
        color: #4CAF50;
        text-align: center;
    }
    .form-container {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    table {
        width: 100%;
    }
    input[type="text"],
    textarea {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }
    button:hover {
        background-color: #45a049;
    }
</style>

<?php include 'footer.php'; ?>