<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin: 20px 0;
            height: 100%;
        }
        .card img {
            max-height: 200px;
            object-fit: cover;
        }
        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .card-title, .card-text {
            margin-bottom: auto;
        }
        .card-actions {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
        }
        .row > div {
            display: flex;
        }
        .nav-link.add-new {
            background-color: #28a745;
            color: white !important;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
            height: 100%;
            display: flex;
            align-items: center;
            padding: 8px 15px;
            margin-right :20px;
        }
        .nav-link.add-new:hover {
            background-color: white;
            color: #28a745 !important;
        }
        .navbar-add-new {
            margin-left: auto;
            display: flex;
            align-items: center;
        }
        .navbar-brand {
            margin-left: 20px;
        }
       .sayan
       {
           color:red;
       }
    </style>
</head>
<body class="container">

<?php
include "connection.php";
include "fetch_records.php";
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php"><b>SCP Foundation</b></a>
    
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <!-- Placeholder for potential left-aligned navbar items -->
        </ul>
    </div>
    <a class="nav-link add-new navbar-add-new" href="create.php">Add New SCP Record</a>
</nav>

<h1 class="text-center">Welcome to the SCP Foundation</h1>

<div class="row">
    <?php foreach ($records as $record): ?>
        <div class="col-md-4 d-flex">
            <div class="card w-100">
                <img src="<?php echo htmlspecialchars($record['image'] ?: 'default-image.jpg'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($record['item']); ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($record['item']); ?></h5>
                    <p class="card-text sayan"><?php echo htmlspecialchars($record['class']); ?></p>
                    <p class="card-text flex-grow-1"><?php echo htmlspecialchars(substr($record['description'], 0, 100)) . '...'; ?></p>
                    <div class="card-actions">
                        <a href="details.php?id=<?php echo htmlspecialchars($record['id']); ?>" class="btn btn-primary">View Details</a>
                        <a href="update.php?update=<?php echo $record['id']; ?>" class="btn btn-warning">Update</a>
                        <a href="delete.php?delete=<?php echo $record['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
