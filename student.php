<?php

// MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stuDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch all students from the database
function fetchAllStudents() {
    global $conn;
    $result = $conn->query("SELECT * FROM students");
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    return $students;
}

// ADD or UPDATE a student
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    if (empty($id)) {
        // ADD student
        $sql = "INSERT INTO students (name, email, age) VALUES ('$name', '$email', '$age')";
    } else {
        // UPDATE student
        $sql = "UPDATE students SET name='$name', email='$email', age='$age' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// DELETE a student
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM students WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully!";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// EDIT a student (fetch data for a specific student)
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $result = $conn->query("SELECT * FROM students WHERE id=$id");
    $student = $result->fetch_assoc();

    echo "
    <script>
        document.querySelector('input[name=id]').value = '{$student['id']}';
        document.querySelector('input[name=name]').value = '{$student['name']}';
        document.querySelector('input[name=email]').value = '{$student['email']}';
        document.querySelector('input[name=age]').value = '{$student['age']}';
    </script>
    ";
}

$conn->close();
?>
