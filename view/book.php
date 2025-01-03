<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
    <title><?php echo $book->isbn; ?></title>
</head>
<body>
<h1>ISBN: <?php echo $book->isbn; ?></h1>
<div>
    <span class="label">Title:</span>
    <?php echo $book->title; ?>
</div>
<div>
    <span class="label">Author:</span>
    <?php echo $book->author; ?>
</div>
<div>
    <span class="label">Publisher:</span>
    <?php echo $book->publisher; ?>
</div>
<div>
    <span class="label">Pages:</span>
    <?php echo $book->pages; ?>
</div>
<a href="index.php">Go Back</>
</body>
</html>
