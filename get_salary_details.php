<?php
require_once 'database/conn.php';

$id = $_GET['id'];

$sql = "SELECT s.id_salary, e.name AS employee_name, s.bruto_salary, s.allowance, s.cuts_salary, s.nett_salary 
        FROM salary s
        JOIN employees e ON s.id_employees = e.id_employees
        WHERE s.id_salary = $id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Data not found']);
}

$conn->close();
?>
