<?php
session_start();
require_once '../config/database.php';
require_once '../models/StudentModel.php';

$database = new Database();
$db = $database->getConnection();
$studentModel = new StudentModel($db);

$message = "";
$error = "";

// Semak sama ada ID wujud dalam URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: student_list.php");
    exit();
}

$id = $_GET['id'];
$student = $studentModel->getStudentForEdit($id);

if (!$student) {
    echo "Rekod pelajar tidak dijumpai.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $ic = trim($_POST['ic']);
    $program = trim($_POST['program']);
    $marks = trim($_POST['marks']);

    if (empty($name) || empty($ic) || empty($program) || empty($marks)) {
        $error = "Sila lengkapkan semua medan.";
    } else {
        if ($studentModel->updateStudent($id, $name, $ic, $program, $marks)) {
            $message = "Rekod pelajar berjaya dikemaskini!";
            // Ambil semula data terkini untuk paparan borang
            $student = $studentModel->getStudentForEdit($id);
        } else {
            $error = "Gagal mengemaskini rekod.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kemaskini Pelajar - PSP Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Kemaskini Rekod Pelajar (UPDATE)</h4>
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
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. K/P (IC)</label>
                                <input type="text" name="ic" class="form-control" value="<?php echo htmlspecialchars($student['ic']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program</label>
                                <input type="text" name="program" class="form-control" value="<?php echo htmlspecialchars($student['program']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Markah</label>
                                <input type="number" step="0.01" name="marks" class="form-control" value="<?php echo htmlspecialchars($student['marks']); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Kemaskini Rekod</button>
                            <a href="student_list.php" class="btn btn-secondary w-100 mt-2">Kembali ke Senarai Pelajar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>