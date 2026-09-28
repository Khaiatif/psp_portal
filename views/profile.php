<?php
// Masukkan fail controller di atas
require_once '../controllers/ProfileController.php';
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pelajar - PSP Portal</title>
    <!-- Masukkan Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Profil Pelajar PSP</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Nama</th>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                            </tr>
                            <tr>
                                <th>No. K/P (NRIC)</th>
                                <td><?php echo htmlspecialchars($student['ic']); ?></td>
                            </tr>
                            <tr>
                                <th>Program</th>
                                <td><?php echo htmlspecialchars($student['program']); ?></td>
                            </tr>
                        </table>
                        <a href="edit_password.php" class="btn btn-warning w-100">Tukar Kata Laluan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>