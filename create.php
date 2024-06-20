<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "connection.php";

if (isset($_POST['submit'])) {
    // Prepare statement to insert data
    $insert = $connection->prepare("INSERT INTO scp (item, class, containment, image, description) VALUES (?, ?, ?, ?, ?)");
    if (!$insert) {
        echo "<div class='alert alert-danger p-3 m-3'>Error preparing statement: {$connection->error}</div>";
        exit;
    }

    $insert->bind_param("sssss", $_POST['item'], $_POST['class'], $_POST['containment'], $_POST['image'], $_POST['description']);

    if ($insert->execute()) {
        // Redirect to avoid form resubmission
        header("Location: create.php?success=1");
        exit();
    } else {
        echo "<div class='alert alert-danger p-3 m-3'>Error: {$insert->error}</div>";
    }

    // Close the statement
    $insert->close();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create SCP Record</title>
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

<h1 class="text-center">Create a New SCP Record</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success p-3 m-3">Record successfully created</div>
<?php endif; ?>

<a href="index.php" class="btn btn-secondary mb-3">Back to Home</a>

<div class="form-container">
    <form method="post" action="create.php" class="form-group">
        <div class="mb-3">
            <label for="item" class="form-label">SCP Item:</label>
            <input type="text" name="item" id="item" class="form-control" placeholder="Item..." required>
        </div>
        <div class="mb-3">
            <label for="class" class="form-label">Class:</label>
            <input type="text" name="class" id="class" class="form-control" placeholder="Class...">
        </div>
        <div class="mb-3">
            <label for="containment" class="form-label">Containment:</label>
            <textarea name="containment" id="containment" class="form-control" placeholder="Containment..."></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="text" name="image" id="image" class="form-control" placeholder="images/nameofimage.png...">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter description..."></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Create Record</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
