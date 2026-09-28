<?php
session_start();
require_once '../config/database.php';
require_once '../models/StudentModel.php';

// Pastikan sesi log masuk aktif (menggunakan session id 1 buat sementara waktu)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Sila isi semua medan.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Kata laluan baharu tidak sepadan dengan pengesahan.";
    } else {
        $database = new Database();
        $db = $database->getConnection();
        $studentModel = new StudentModel($db);

        // Ambil data kata laluan dari pangkalan data
        $student = $studentModel->getStudentPasswordById($_SESSION['user_id']);

        // Semak kata laluan lama menggunakan password_verify()
        if ($student && password_verify($old_password, $student['password'])) {
            // Hash kata laluan baharu sebelum simpan ke DB
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            if ($studentModel->updatePassword($_SESSION['user_id'], $hashed_password)) {
                $message = "Kata laluan berjaya dikemaskini!";
            } else {
                $error = "Gagal mengemaskini kata laluan.";
            }
        } else {
            $error = "Kata laluan lama tidak sah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tukar Kata Laluan - PSP Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Tukar Kata Laluan</h4>
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
                                <label class="form-label">Kata Laluan Lama</label>
                                <input type="password" name="old_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kata Laluan Baharu</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sahkan Kata Laluan Baharu</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kemaskini Kata Laluan</button>
                            <a href="profile.php" class="btn btn-secondary w-100 mt-2">Kembali ke Profil</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>