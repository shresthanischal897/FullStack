<?php
// app/controllers/StudentController.php

require_once __DIR__ . '/../models/Student.php';

class StudentController {
    private $studentModel;
    private $blade;
    
    public function __construct($pdo, $blade) {
        $this->studentModel = new Student($pdo);
        $this->blade = $blade;
    }
    
    public function index() {
        $students = $this->studentModel->all();
        echo $this->blade->make('students.index', ['students' => $students])->render();
    }
    
    public function create() {
        echo $this->blade->make('students.create')->render();
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->studentModel->create(
                $_POST['name'],
                $_POST['email'],
                $_POST['course']
            );
            header('Location: /workshop8/public/index.php?action=index');
            exit();
        }
    }
    
    public function edit($id) {
        $student = $this->studentModel->find($id);
        if (!$student) {
            echo "Student not found!";
            exit();
        }
        echo $this->blade->make('students.edit', ['student' => $student])->render();
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->studentModel->update(
                $id,
                $_POST['name'],
                $_POST['email'],
                $_POST['course']
            );
            header('Location: /workshop8/public/index.php?action=index');
            exit();
        }
    }
    
    public function delete($id) {
        // Directly delete the student without any confirmation page
        $this->studentModel->delete($id);
        header('Location: /workshop8/public/index.php?action=index');
        exit();
    }
}
?>
