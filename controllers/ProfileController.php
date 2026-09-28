<?php
session_start();
require_once '../config/database.php';
require_once '../models/StudentModel.php';

// Simulasi log masuk (Untuk ujian, kita setkan session id kepada 1 buat sementara waktu)
// Nanti bila modul login siap, session ini akan datang dari proses login yang sah.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; 
}

$database = new Database();
$db = $database->getConnection();

$studentModel = new StudentModel($db);
$student = $studentModel->getStudentById($_SESSION['user_id']);

// Jika pelajar tidak wujud
if (!$student) {
    echo "Maklumat pelajar tidak dijumpai.";
    exit();
}
?>