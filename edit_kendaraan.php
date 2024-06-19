<?php
session_start();
require 'koneksi.php';

$id_kendaraan = $_GET['id_kendaraan'];

$stmt = $pdo->prepare('SELECT * FROM Kendaraan WHERE id_kendaraan = ?');
$stmt->execute([$id_kendaraan]);
$vehicle = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_kendaraan = $_POST['no_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $jam_masuk = $_POST['jam_masuk'];
    $jam_keluar = $_POST['jam_keluar'];
    $status = $_POST['status'];
    $id_pengguna = $_POST['id_pengguna'];

    $stmt = $pdo->prepare('UPDATE Kendaraan SET no_kendaraan = ?, jenis_kendaraan = ?, jam_masuk = ?, jam_keluar = ?, status = ?, id_pengguna = ? WHERE id_kendaraan = ?');
    $stmt->execute([$no_kendaraan, $jenis_kendaraan, $jam_masuk, $jam_keluar, $status, $id_pengguna, $id_kendaraan]);

    header('Location: manajemen_kendaraan.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kendaraan</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Edit Kendaraan</h1>
    <form method="post" action="">
        <label>No Kendaraan: <input type="text" name="no_kendaraan" value="<?php echo htmlspecialchars($vehicle['no_kendaraan']); ?>"></label><br>
        <label>Jenis Kendaraan: 
            <select name="jenis_kendaraan">
                <option value="mobil" <?php if ($vehicle['jenis_kendaraan'] == 'mobil') echo 'selected'; ?>>Mobil</option>
                <option value="motor" <?php if ($vehicle['jenis_kendaraan'] == 'motor') echo 'selected'; ?>>Motor</option>
            </select>
        </label><br>
        <label>Jam Masuk: <input type="datetime-local" name="jam_masuk" value="<?php echo htmlspecialchars($vehicle['jam_masuk']); ?>"></label><br>
        <label>Jam Keluar: <input type="datetime-local" name="jam_keluar" value="<?php echo htmlspecialchars($vehicle['jam_keluar']); ?>"></label><br>
        <label>Status: 
            <select name="status">
                <option value="belum selesai" <?php if ($vehicle['status'] == 'belum selesai') echo 'selected'; ?>>Belum Selesai</option>
                <option value="selesai" <?php if ($vehicle['status'] == 'selesai') echo 'selected'; ?>>Selesai</option>
            </select>
        </label><br>
        <label>ID Pengguna: <input type="number" name="id_pengguna" value="<?php echo htmlspecialchars($vehicle['id_pengguna']); ?>"></label><br>
        <input type="submit" value="Update Kendaraan">
    </form>
    <a href="manajemen_kendaraan.php">Kembali ke Manajemen Kendaraan</a>
</body>
</html>
