<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';


$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$keyword = $_GET['keyword'] ?? '';

if ($keyword) {
    $sql = "SELECT * FROM buku WHERE judul ILIKE :keyword ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':keyword' => "%$keyword%"]);
} else {
    $sql = "SELECT * FROM buku ORDER BY id DESC";
    $stmt = $pdo->query($sql);
}
$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Daftar Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form method="GET" action="" class="search-box">
        <label for="search-input">Cari Judul Buku</label>
        <input type="text" id="search-input" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Ketik judul buku...">
        <button type="submit">Cari</button>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Tanggal ditambahkan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarBuku)): ?>
                    <tr>
                        <td colspan="5">Belum ada data buku. Silakan tambah lewat menu "Tambah Buku".</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarBuku as $buku): ?>
                        <tr>
                            <td><?php echo $buku['judul']; ?></td>
                            <td><?php echo $buku['pengarang']; ?></td>
                            <td><?php echo $buku['tahun']; ?></td>
                            <td><?php echo $buku['stok']; ?></td>
                            <td><?php echo $buku['tanggal_ditambahkan']; ?></td>
                            <td>
                                <button type="button">Edit</button>
                                <button type="button" class="btn-hapus">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>