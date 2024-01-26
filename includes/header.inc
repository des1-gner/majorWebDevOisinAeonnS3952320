<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>International Melbourne Hotel</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="main.js" defer></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ysabeau+SC&family=Exo&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap">
    <link rel="stylesheet" href="https://fonts.google.com/specimen/Exo">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>


</head>

<body <?php echo isset($isIndexPage) && $isIndexPage ? 'class="body-index"' : ''; ?>>

    <header>

        <div class="logo">
    
            <a href="index.php">
    
                <img src="images/logo.jpeg" alt="Logo">
    
            </a>
    
            <?php include('includes/nav.inc'); ?>
    
        </div>
    
        <form>
    
            <input type="text" placeholder="Search...">
    
            <button type="submit" class="search-icon">&#128269;</button>
    
        </form>
    
    </header>