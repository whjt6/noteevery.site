<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user notes from the database
$user_id = $_SESSION['user_id'];
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

// Prepare search query
$sql = "SELECT * FROM entries WHERE user_id = ? AND (title LIKE ? OR content LIKE ?) ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$searchWildcard = "%" . $searchTerm . "%";
$stmt->bind_param("iss", $user_id, $searchWildcard, $searchWildcard);
$stmt->execute();
$result = $stmt->get_result();

include 'header.php';
?>

<h2>Daftar Catatan</h2>

<!-- Search Form -->
<form method="POST" action="">
    <input type="text" name="search" placeholder="Cari catatan..." value="<?php echo htmlspecialchars($searchTerm); ?>" aria-label="Search notes">
    <input type="submit" value="Cari" aria-label="Search">
</form>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Konten</th>
            <th>Tanggal Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($entry = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($entry['title']); ?></td>
                    <td><?php echo htmlspecialchars($entry['content']); ?></td>
                    <td><?php echo htmlspecialchars($entry['created_at']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $entry['id']; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $entry['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Tidak ada catatan ditemukan.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="create.php">Buat Catatan Baru</a>

<?php include 'footer.php'; ?>