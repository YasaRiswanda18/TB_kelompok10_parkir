<?php
session_start();
require 'koneksi.php';

// Create new vehicle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_vehicle'])) {
    $no_kendaraan = $_POST['no_kendaraan'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $jam_masuk = $_POST['jam_masuk'];
    $jam_keluar = $_POST['jam_keluar'];
    $status = $_POST['status'];
    $id_pengguna = $_POST['id_pengguna'];

    $stmt = $pdo->prepare('INSERT INTO Kendaraan (no_kendaraan, jenis_kendaraan, jam_masuk, jam_keluar, status, id_pengguna) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$no_kendaraan, $jenis_kendaraan, $jam_masuk, $jam_keluar, $status, $id_pengguna]);
}

// Delete vehicle
if (isset($_GET['delete_vehicle'])) {
    $id_kendaraan = $_GET['delete_vehicle'];
    $stmt = $pdo->prepare('DELETE FROM Kendaraan WHERE id_kendaraan = ?');
    $stmt->execute([$id_kendaraan]);
}

// Read vehicles
$stmt = $pdo->query('SELECT * FROM Kendaraan');
$vehicles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Kendaraan</title>

    <link rel="stylesheet" type="text/css" href="style.css">
    
</head>
<body>
    <h1>Manajemen Kendaraan</h1>
    <form method="post" action="">
        <input type="hidden" name="create_vehicle" value="1">
        <label>No Kendaraan: <input type="text" name="no_kendaraan"></label><br>
        <label>Jenis Kendaraan: 
            <select name="jenis_kendaraan">
                <option value="mobil">Mobil</option>
                <option value="motor">Motor</option>
            </select>
        </label><br>
        <label>Jam Masuk: <input type="datetime-local" name="jam_masuk"></label><br>
        <label>Jam Keluar: <input type="datetime-local" name="jam_keluar"></label><br>
        <label>Status: 
            <select name="status">
                <option value="belum selesai">Belum Selesai</option>
                <option value="selesai">Selesai</option>
            </select>
        </label><br>
        <label>ID Pengguna: <input type="number" name="id_pengguna"></label><br>
        <input type="submit" value="Tambah Kendaraan">
    </form>
    <h2>Daftar Kendaraan</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>No Kendaraan</th>
            <th>Jenis Kendaraan</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Status</th>
            <th>ID Pengguna</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($vehicles as $vehicle): ?>
        <tr>
            <td><?php echo htmlspecialchars($vehicle['id_kendaraan']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['no_kendaraan']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['jenis_kendaraan']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['jam_masuk']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['jam_keluar']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['status']); ?></td>
            <td><?php echo htmlspecialchars($vehicle['id_pengguna']); ?></td>
            <td>
                <a href="edit_kendaraan.php?id_kendaraan=<?php echo $vehicle['id_kendaraan']; ?>">Edit</a>
                <a href="?delete_vehicle=<?php echo $vehicle['id_kendaraan']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
