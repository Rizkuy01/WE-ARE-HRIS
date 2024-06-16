<?php
require_once 'database/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $salaryId = $_POST['salary_id'];
    $paymentMethod = $_POST['payment_method'];

    // Fetch salary details
    $sql = "SELECT s.id_salary, e.name AS employee_name, s.bruto_salary, s.allowance, s.cuts_salary, s.nett_salary 
            FROM salary s
            JOIN employees e ON s.id_employees = e.id_employees
            WHERE s.id_salary = $salaryId";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die('Data not found');
    }

    $conn->close();

    // Process payment (this is just a placeholder, actual implementation will depend on payment gateway API)
    $paymentStatus = 'success'; // or 'failure'

    // Redirect or display payment status
    if ($paymentStatus == 'success') {
        echo "Payment successful for " . $row['employee_name'] . " using " . $paymentMethod;
    } else {
        echo "Payment failed for " . $row['employee_name'];
    }
} else {
    die('Invalid request');
}
?>
