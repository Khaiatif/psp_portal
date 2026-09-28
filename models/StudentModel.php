<?php
class StudentModel {
    private $conn;
    private $table = 'students';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Dapatkan data pelajar mengikut ID (untuk profil)
    public function getStudentById($id) {
        $query = "SELECT id, name, ic, program, marks FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Dapatkan rekod kata laluan pelajar mengikut ID untuk semakan
    public function getStudentPasswordById($id) {
        $query = "SELECT id, password FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Kemaskini kata laluan baharu
    public function updatePassword($id, $new_password) {
        $query = "UPDATE " . $this->table . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $new_password);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Dapatkan senarai semua pelajar (READ)
    public function getAllStudents() {
        $query = "SELECT id, name, ic, program, marks FROM " . $this->table . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah pelajar baharu (CREATE)
    public function addStudent($name, $ic, $password, $program, $marks) {
        $query = "INSERT INTO " . $this->table . " (name, ic, password, program, marks) VALUES (:name, :ic, :password, :program, :marks)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':ic', $ic);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':program', $program);
        $stmt->bindParam(':marks', $marks);
        return $stmt->execute();
    }

    // Dapatkan data pelajar untuk borang Update
    public function getStudentForEdit($id) {
        $query = "SELECT id, name, ic, program, marks FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Kemaskini maklumat pelajar (UPDATE)
    public function updateStudent($id, $name, $ic, $program, $marks) {
        $query = "UPDATE " . $this->table . " SET name = :name, ic = :ic, program = :program, marks = :marks WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':ic', $ic);
        $stmt->bindParam(':program', $program);
        $stmt->bindParam(':marks', $marks);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Padam rekod pelajar (DELETE)
    public function deleteStudent($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Kemaskini gambar profil pelajar
    public function updateProfilePic($id, $filename) {
        $query = "UPDATE " . $this->table . " SET profile_pic = :profile_pic WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':profile_pic', $filename);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>