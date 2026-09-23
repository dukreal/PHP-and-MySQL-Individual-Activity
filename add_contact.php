<?php
//add_contact.php

session_start();
require "db.php";
require "validate.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        "last_name" => $_POST['last_name'],
        "first_name" => $_POST['first_name'],
        "email" => $_POST['email'],
        "contact_number" => $_POST['contact_number']
    ];

    $errors = validate_contact($conn, $data, null);

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $data;
        header("Location: index.php");
        exit;
    }

    $last_name = trim($data['last_name']);
    $first_name = trim($data['first_name']);
    $email = trim($data['email']);
    $contact_number = trim($data['contact_number']);

    $sql = "INSERT INTO contacts (last_name, first_name, email, contact_number) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $last_name, $first_name, $email, $contact_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: index.php?added=1");
    exit;
}

// If someone visits this file directly without submitting the form, send them back
header("Location: index.php");
exit;
