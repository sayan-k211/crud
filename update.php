<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "connection.php";

// Initialise $row as empty array
$row = [];

// Directed from index page record [update] button
if (isset($_GET['update'])) {
    $id = $_GET['update'];

    // Ensure the ID is an integer
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        echo "<div class='alert alert-danger p-3 m-2'>Invalid ID provided for updating.</div>";
        exit();
    }

    // Prepare the SQL statement to select the record by ID
    $recordID = $connection->prepare("SELECT * FROM scp WHERE id = ?");
    
    if (!$recordID) {
        echo "<div class='alert alert-danger p-3 m-2'>Error preparing record for updating: {$connection->error}</div>";
        exit();
    }
    
    $recordID->bind_param("i", $id);
    
    if ($recordID->execute()) {
        $temp = $recordID->get_result();
        $row = $temp->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger p-3 m-2'>Error executing statement: {$recordID->error}</div>";
    }
    $recordID->close();
}

if (isset($_POST['update'])) {
    // Validate and sanitize input data
    $item = htmlspecialchars($_POST['item']);
    $class = htmlspecialchars($_POST['class']);
    $containment = htmlspecialchars($_POST['containment']);
    $image = htmlspecialchars($_POST['image']);
    $description = htmlspecialchars($_POST['description']);
    $id = $_POST['id'];

    // Ensure the ID is an integer
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        echo "<div class='alert alert-danger p-3 m-2'>Invalid ID provided for updating.</div>";
        exit();
    }

    // Prepare the SQL statement to update data
    $update = $connection->prepare("UPDATE scp SET item=?, class=?, containment=?, image=?, description=? WHERE id=?");
    
    if (!$update) {
        echo "<div class='alert alert-danger p-3 m-2'>Error preparing update statement: {$connection->error}</div>";
        exit();
    }
    
    $update->bind_param("sssssi", $item, $class, $containment, $image, $description, $id);
    
    if ($update->execute()) {
        // Redirect to avoid form resubmission
        header("Location: update.php?update=$id&success=1");
        exit();
    } else {
        echo "<div class='alert alert-danger p-3 m-2'>Error executing statement: {$update->error}</div>";
    }
    $update->close();
}

if (isset($_GET['success'])) {
    echo "<div class='alert alert-success p-3 m-2'>Record updated successfully</div>";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update SCP Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            margin-top: 50px;
        }
    </style>
</head>
<body class="container">

<h1 class="text-center">Update SCP Record</h1>

<a href="index.php" class="btn btn-secondary mb-3">Back to Home</a>

<div class="form-container">
    <form method="post" action="update.php" class="form-group">
        <input type="hidden" name="id" value="<?php echo isset($row['id']) ? htmlspecialchars($row['id']) : ''; ?>">
        <div class="mb-3">
            <label for="item" class="form-label">SCP Item:</label>
            <input type="text" name="item" id="item" class="form-control" placeholder="Item..." value="<?php echo isset($row['item']) ? htmlspecialchars($row['item']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="class" class="form-label">Class:</label>
            <input type="text" name="class" id="class" class="form-control" placeholder="Class..." value="<?php echo isset($row['class']) ? htmlspecialchars($row['class']) : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="containment" class="form-label">Containment:</label>
            <textarea name="containment" id="containment" class="form-control"><?php echo isset($row['containment']) ? htmlspecialchars($row['containment']) : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="text" name="image" id="image" class="form-control" placeholder="images/name_of_image.png" value="<?php echo isset($row['image']) ? htmlspecialchars($row['image']) : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="description" class="form-control"><?php echo isset($row['description']) ? htmlspecialchars($row['description']) : ''; ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update Record</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
