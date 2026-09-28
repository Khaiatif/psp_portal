<?php
session_start();
require_once '../config/database.php';
require_once '../models/StudentModel.php';

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $ic = trim($_POST['ic']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash kata laluan baharu
    $program = trim($_POST['program']);
    $marks = trim($_POST['marks']);

    if (empty($name) || empty($ic) || empty($_POST['password']) || empty($program) || empty($marks)) {
        $error = "Sila lengkapkan semua medan.";
    } else {
        $database = new Database();
        $db = $database->getConnection();
        $studentModel = new StudentModel($db);

        if ($studentModel->addStudent($name, $ic, $password, $program, $marks)) {
            $message = "Rekod pelajar berjaya ditambah!";
        } else {
            $error = "Gagal menambah rekod pelajar (Mungkin No. K/P sudah wujud).";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelajar - PSP Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Tambah Rekod Pelajar Baru (CREATE)</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-success"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Penuh</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. K/P (IC)</label>
                                <input type="text" name="ic" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kata Laluan</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program</label>
                                <input type="text" name="program" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Markah</label>
                                <input type="number" step="0.01" name="marks" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Simpan Rekod</button>
                            <a href="student_list.php" class="btn btn-secondary w-100 mt-2">Lihat Senarai Pelajar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>