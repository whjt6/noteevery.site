<?php
session_start();
include 'db.php';

// Cek jika pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Arahkan ke login jika pengguna belum login
    exit();
}

// Cek jika ID catatan diberikan
if (!isset($_GET['id'])) {
    header("Location: index.php"); // Arahkan ke index jika tidak ada ID
    exit();
}

$entry_id = intval($_GET['id']);

// Ambil catatan dari database
$stmt = $conn->prepare("SELECT * FROM entries WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $entry_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$entry = $result->fetch_assoc();

if (!$entry) {
    // Jika tidak ditemukan, arahkan ke index
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Siapkan dan eksekusi pernyataan untuk memperbarui catatan
    $stmt = $conn->prepare("UPDATE entries SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $title, $content, $entry_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        header("Location: view.php?message=Catatan berhasil diperbarui.");
        exit();
    } else {
        $error = "Gagal memperbarui catatan: " . $stmt->error;
    }
}

include 'header.php';
?>

<h2>Edit Catatan</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    <table>
        <tr>
            <td>Judul:</td>
            <td><input type="text" name="title" value="<?php echo htmlspecialchars($entry['title']); ?>" required></td>
        </tr>
        <tr>
            <td>Konten:</td>
            <td><textarea name="content" required><?php echo htmlspecialchars($entry['content']); ?></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Perbarui</button></td>
        </tr>
    </table>
</form>

<a href="index.php">Kembali ke Dashboard</a>

<?php include 'footer.php'; ?>