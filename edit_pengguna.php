<?php
session_start();
require 'koneksi.php';

$id_pengguna = $_GET['id_pengguna'];

$stmt = $pdo->prepare('SELECT * FROM Pengguna WHERE id_pengguna = ?');
$stmt->execute([$id_pengguna]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pengguna = $_POST['nama_pengguna'];
    $username = $_POST['username'];
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user['password'];
    $hak_akses = $_POST['hak_akses'];

    $stmt = $pdo->prepare('UPDATE Pengguna SET nama_pengguna = ?, username = ?, password = ?, hak_akses = ? WHERE id_pengguna = ?');
    $stmt->execute([$nama_pengguna, $username, $password, $hak_akses, $id_pengguna]);

    header('Location: manajemen_pengguna.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengguna</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Edit Pengguna</h1>
    <form method="post" action="">
        <label>Nama Pengguna: <input type="text" name="nama_pengguna" value="<?php echo htmlspecialchars($user['nama_pengguna']); ?>"></label><br>
        <label>Username: <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"></label><br>
        <label>Password: <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"></label><br>
        <label>Hak Akses: 
            <select name="hak_akses">
                <option value="Admin" <?php if ($user['hak_akses'] == 'Admin') echo 'selected'; ?>>Admin</option>
                <option value="Operator" <?php if ($user['hak_akses'] == 'Operator') echo 'selected'; ?>>Operator</option>
            </select>
        </label><br>
        <input type="submit" value="Update Pengguna">
    </form>
    <a href="manajemen_pengguna.php">Kembali ke Manajemen Pengguna</a>
</body>
</html>
