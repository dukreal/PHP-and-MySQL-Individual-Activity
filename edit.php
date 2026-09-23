<?php
// edit.php

session_start();
require "db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$errors = [];
if (isset($_SESSION['errors']) && isset($_SESSION['old'])) {
    $errors = $_SESSION['errors'];
    $contact = $_SESSION['old'];
    $contact['id'] = $id;
    unset($_SESSION['errors']);
    unset($_SESSION['old']);
} else {
    $sql = "SELECT * FROM contacts WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        header("Location: index.php");
        exit;
    }

    $contact = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Contact</h1>

        <form action="update_contact.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">

            <div class="form-row">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" maxlength="50" required
                       value="<?php echo htmlspecialchars($contact['last_name']); ?>">
                <?php if (isset($errors['last_name'])): ?>
                    <div class="error"><?php echo $errors['last_name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" maxlength="50" required
                       value="<?php echo htmlspecialchars($contact['first_name']); ?>">
                <?php if (isset($errors['first_name'])): ?>
                    <div class="error"><?php echo $errors['first_name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" maxlength="50" required
                       value="<?php echo htmlspecialchars($contact['email']); ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="error"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <label for="contact_number">Contact Number</label>
                <input type="text" id="contact_number" name="contact_number" maxlength="15" required
                       pattern="[0-9]+" title="Digits only"
                       value="<?php echo htmlspecialchars($contact['contact_number']); ?>">
                <?php if (isset($errors['contact_number'])): ?>
                    <div class="error"><?php echo $errors['contact_number']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="index.php" class="btn btn-cancel">Cancel</a>
        </form>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>
