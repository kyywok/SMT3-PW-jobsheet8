<?php
require_once '../includes/koneksi.php';

$jsonString = file_get_contents('./buku.json'); 
$dataBuku = json_decode($jsonString, true);

$sql = "INSERT INTO buku (judul, pengarang, tahun, isbn, stok,kategori) VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)";
$stmt = $pdo->prepare($sql);

$berhasil = 0;

foreach ($dataBuku as $buku) {
    try {
        $stmt->execute([
            ':judul' => $buku['judul'],
            ':pengarang' => $buku['pengarang'],
            ':tahun' => $buku['tahun'],
            ':isbn' => $buku['isbn'],
            ':stok' => $buku['stok'],
            ':kategori' => $buku['kategori']
        ]);
        $berhasil++;
    } catch (PDOException $e) {
        echo "Gagal migrasi buku: " . $buku['judul'] . " - " . $e->getMessage() . "<br>";
    }
}

echo "Migrasi Selesai! $berhasil baris data berhasil dimasukkan ke PostgreSQL.";
?>