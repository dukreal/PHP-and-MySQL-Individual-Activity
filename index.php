<?php
// index.php

require "db.php";

$sql = "SELECT * FROM contacts ORDER BY last_name ASC";
$result = mysqli_query($conn, $sql);

$errors = [];
$old = [
    "last_name" => "",
    "first_name" => "",
    "email" => "",
    "contact_number" => ""
];

session_start();
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $old = $_SESSION['old'];
    unset($_SESSION['errors']);
    unset($_SESSION['old']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Contact List</h1>

        <?php if (isset($_GET['deleted'])): ?>
            <p class="success-message">Contact deleted successfully.</p>
        <?php endif; ?>

        <?php if (isset($_GET['updated'])): ?>
            <p class="success-message">Contact updated successfully.</p>
        <?php endif; ?>

        <?php if (isset($_GET['added'])): ?>
            <p class="success-message">Contact added successfully.</p>
        <?php endif; ?>

        <!-- ================= ADD CONTACT FORM ================= -->
        <h2>Add Contact</h2>
        <form action="add_contact.php" method="POST">
            <div class="form-row">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" maxlength="50" required
                       value="<?php echo htmlspecialchars($old['last_name']); ?>">
                <?php if (isset($errors['last_name'])): ?>
                    <div class="error"><?php echo $errors['last_name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" maxlength="50" required
                       value="<?php echo htmlspecialchars($old['first_name']); ?>">
                <?php if (isset($errors['first_name'])): ?>
                    <div class="error"><?php echo $errors['first_name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" maxlength="50" required
                       value="<?php echo htmlspecialchars($old['email']); ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="error"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-row">
                <label for="contact_number">Contact Number</label>
                <input type="text" id="contact_number" name="contact_number" maxlength="15" required
                       pattern="[0-9]+" title="Digits only"
                       value="<?php echo htmlspecialchars($old['contact_number']); ?>">
                <?php if (isset($errors['contact_number'])): ?>
                    <div class="error"><?php echo $errors['contact_number']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Add Contact</button>
        </form>

        <!-- ================= CONTACTS TABLE ================= -->
        <h2>All Contacts</h2>
        <table>
            <thead>
                <tr>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Email Address</th>
                    <th>Contact Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                            <td>
                                <a class="btn btn-edit" href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a class="btn btn-delete" href="delete_contact.php?id=<?php echo $row['id']; ?>"
                                   onclick="return confirm('Are you sure you want to delete this contact?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-contacts">No contacts yet. Add one above.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>
