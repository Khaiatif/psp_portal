<?php
session_start();
require_once '../config/database.php';
require_once '../models/StudentModel.php';

if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $studentModel = new StudentModel($db);

    $studentModel->deleteStudent($_GET['id']);
}

header("Location: student_list.php");
exit();
?>