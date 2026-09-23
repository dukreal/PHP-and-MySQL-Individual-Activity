<?php
// update_contact.php

session_start();
require "db.php";
require "validate.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];

    $data = [
        "last_name" => $_POST['last_name'],
        "first_name" => $_POST['first_name'],
        "email" => $_POST['email'],
        "contact_number" => $_POST['contact_number']
    ];

    $errors = validate_contact($conn, $data, $id);

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $data;
        header("Location: edit.php?id=" . $id);
        exit;
    }

    $last_name = trim($data['last_name']);
    $first_name = trim($data['first_name']);
    $email = trim($data['email']);
    $contact_number = trim($data['contact_number']);

    $sql = "UPDATE contacts SET last_name = ?, first_name = ?, email = ?, contact_number = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $last_name, $first_name, $email, $contact_number, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: index.php?updated=1");
    exit;
}

header("Location: index.php");
exit;
