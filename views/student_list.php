<?php
session_start();
require_once '../config/database.php';
require_once '../models/StudentModel.php';

$database = new Database();
$db = $database->getConnection();

$studentModel = new StudentModel($db);
$students = $studentModel->getAllStudents();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Gred Pelajar - PSP Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Senarai Gred Pelajar (CRUD Operations)</h2>
            <div>
                <a href="student_add.php" class="btn btn-success">+ Tambah Pelajar</a>
                <a href="profile.php" class="btn btn-secondary">Profil</a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>No. K/P (IC)</th>
                            <th>Program</th>
                            <th>Markah</th>
                            <th width="18%">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($students) > 0): ?>
                            <?php foreach ($students as $row): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['ic']); ?></td>
                                <td><?php echo htmlspecialchars($row['program']); ?></td>
                                <td><?php echo htmlspecialchars($row['marks']); ?></td>
                                <td>
                                    <a href="student_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="student_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Adakah anda pasti mahu memadam rekod pelajar ini?');">Padam</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tiada rekod pelajar dijumpai.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>