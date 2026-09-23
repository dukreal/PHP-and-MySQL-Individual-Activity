<?php
// validate.php

function validate_contact(mysqli $conn, array $data, ?int $ignore_id = null): array {
    $errors = [];

    $last_name = trim($data['last_name']);
    $first_name = trim($data['first_name']);
    $email = trim($data['email']);
    $contact_number = trim($data['contact_number']);

    // ---- Required field checks ----
    if ($last_name === "") {
        $errors['last_name'] = "Last name is required.";
    } elseif (strlen($last_name) > 50) {
        $errors['last_name'] = "Last name must be 50 characters or fewer.";
    }

    if ($first_name === "") {
        $errors['first_name'] = "First name is required.";
    } elseif (strlen($first_name) > 50) {
        $errors['first_name'] = "First name must be 50 characters or fewer.";
    }

    if ($email === "") {
        $errors['email'] = "Email address is required.";
    } elseif (strlen($email) > 50) {
        $errors['email'] = "Email address must be 50 characters or fewer.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    } else {
        // ---- Duplicate email check ----
        if ($ignore_id === null) {
            $check_sql = "SELECT id FROM contacts WHERE email = ?";
            $stmt = mysqli_prepare($conn, $check_sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
        } else {
            $check_sql = "SELECT id FROM contacts WHERE email = ? AND id != ?";
            $stmt = mysqli_prepare($conn, $check_sql);
            mysqli_stmt_bind_param($stmt, "si", $email, $ignore_id);
        }
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $errors['email'] = "This email address is already in use.";
        }
        mysqli_stmt_close($stmt);
    }

    if ($contact_number === "") {
        $errors['contact_number'] = "Contact number is required.";
    } elseif (strlen($contact_number) > 15) {
        $errors['contact_number'] = "Contact number must be 15 characters or fewer.";
    } elseif (!preg_match('/^[0-9]+$/', $contact_number)) {
        $errors['contact_number'] = "Contact number must contain digits only.";
    }

    return $errors;
}
?>
