<?php
session_start();
require_once '../config/database.php';
require_once '../models/StudentModel.php';

// Pastikan sesi aktif (menggunakan ID 1 buat sementara waktu)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$database = new Database();
$db = $database->getConnection();
$studentModel = new StudentModel($db);

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $file = $_FILES['profile_pic'];
    
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // Dapatkan ekstensi fail
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    // Validasi jenis fail (.jpg, .jpeg, .png) dan saiz (maks 2MB)[cite: 6]
    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize <= 2 * 1024 * 1024) { // Had 2MB[cite: 6]
                // Secure Renaming menggunakan uniqid()[cite: 6]
                $newFileName = "profile_" . $_SESSION['user_id'] . "_" . uniqid('', true) . "." . $fileExt;
                $fileDestination = '../uploads/' . $newFileName;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Simpan nama fail ke pangkalan data[cite: 6]
                    if ($studentModel->updateProfilePic($_SESSION['user_id'], $newFileName)) {
                        $message = "Gambar profil berjaya dimuat naik!";
                    } else {
                        $error = "Gagal menyimpan maklumat gambar ke pangkalan data.";
                    }
                } else {
                    $error = "Gagal memindahkan fail yang dimuat naik.";
                }
            } else {
                $error = "Saiz fail terlalu besar. Had maksimum adalah 2MB[cite: 6].";
            }
        } else {
            $error = "Terdapat ralat semasa memuat naik fail.";
        }
    } else {
        $error = "Format fail tidak sah. Hanya .jpg, .jpeg, dan .png dibenarkan[cite: 6].";
    }
}

// Ambil data pelajar untuk paparan gambar semasa
$student = $studentModel->getStudentById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muat Naik Gambar Profil - PSP Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Muat Naik Gambar Profil</h4>
                    </div>
                    <div class="card-body text-center">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-success"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <!-- Paparan Gambar Profil Semasa -->
                        <div class="mb-3">
                            <?php 
                            $pic = (!empty($student['profile_pic']) && file_exists('../uploads/' . $student['profile_pic'])) 
                                   ? $student['profile_pic'] 
                                   : 'default.png'; 
                            ?>
                            <img src="../uploads/<?php echo $pic; ?>" alt="Gambar Profil" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3 text-start">
                                <label class="form-label">Pilih Gambar Profil (.jpg, .jpeg, .png | Maks: 2MB)[cite: 6]</label>
                                <input type="file" name="profile_pic" class="form-control" accept=".jpg, .jpeg, .png" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Muat Naik Gambar</button>
                            <a href="profile.php" class="btn btn-secondary w-100 mt-2">Kembali ke Profil</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>