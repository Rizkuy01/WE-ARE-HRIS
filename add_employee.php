<?php
require_once 'database/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = $_POST['name'];
    $position = $_POST['position'];
    $office = $_POST['office'];
    $email = $_POST['email'];
    $start_date = $_POST['start_date'];
    $salary = $_POST['salary'];
    $birth = $_POST['birth'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Validasi data (opsional)
    // Tambahkan validasi data sesuai kebutuhan

    // SQL untuk memasukkan data ke tabel employees
    $sql = "INSERT INTO employees (name, id_positions, id_departement, email, start_date, salary, birth, address, phone)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Mendapatkan id_positions dan id_departement berdasarkan nama position dan office
    $position_sql = "SELECT id_positions FROM positions WHERE name_positions = ?";
    $stmt = $conn->prepare($position_sql);
    $stmt->bind_param('s', $position);
    $stmt->execute();
    $stmt->bind_result($position_id);
    $stmt->fetch();
    $stmt->close();

    $department_sql = "SELECT id_departement FROM departement WHERE nama_departement = ?";
    $stmt = $conn->prepare($department_sql);
    $stmt->bind_param('s', $office);
    $stmt->execute();
    $stmt->bind_result($department_id);
    $stmt->fetch();
    $stmt->close();

    // Memasukkan data ke tabel employees
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('siisss', $name, $position_id, $department_id, $email, $start_date, $salary, $birth, $address, $phone);
        if ($stmt->execute()) {
            // Berhasil memasukkan data
            header('Location: tables.php?success=1');
        } else {
            // Gagal memasukkan data
            header('Location: tables.php?error=1');
        }
        $stmt->close();
    } else {
        // Gagal menyiapkan statement
        header('Location: tables.php?error=1');
    }

    $conn->close();
} else {
    // Jika bukan metode POST, redirect ke halaman utama
    header('Location: tables.php');
}
?>
