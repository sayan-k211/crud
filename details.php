<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "connection.php";

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ensure the ID is an integer
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        echo "<div class='alert alert-danger p-3 m-2'>Invalid ID provided.</div>";
        exit();
    }

    // Prepare the SQL statement to select the record by ID
    $stmt = $connection->prepare("SELECT * FROM scp WHERE id = ?");
    if (!$stmt) {
        echo "<div class='alert alert-danger p-3 m-2'>Error preparing statement: {$connection->error}</div>";
        exit();
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $record = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-danger p-3 m-2'>Record not found.</div>";
            exit();
        }
    } else {
        echo "<div class='alert alert-danger p-3 m-2'>Error executing statement: {$stmt->error}</div>";
        exit();
    }

    $stmt->close();
} else {
    echo "<div class='alert alert-danger p-3 m-2'>No ID provided.</div>";
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Details - <?php echo htmlspecialchars($record['item']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .img-container {
            text-align: center;
        }
        .img-container img {
            width: 100%;
            max-width: 400px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body class="container">

<h1><?php echo htmlspecialchars($record['item']); ?></h1>
<p><strong>Class:</strong> <?php echo htmlspecialchars($record['class']); ?></p>
<p><strong>Containment:</strong> <?php echo nl2br(htmlspecialchars($record['containment'])); ?></p>
<p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($record['description'])); ?></p>
<div class="img-container">
    <img src="<?php echo htmlspecialchars($record['image'] ?: 'default-image.jpg'); ?>" alt="<?php echo htmlspecialchars($record['item']); ?>">
</div>

<p><a href="index.php" class="btn btn-secondary mt-3">Back to Home</a></p>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
