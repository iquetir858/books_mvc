<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>
        <?php echo htmlentities($title); ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="view/general.css">
    <link rel="stylesheet" type="text/css" href="view/newBook.css">
</head>

<body>
    <header>
        <h3>Add New Book</h3>
    </header>
    <?php
    if ($errors) {
        echo '<ul class="errors">';
        foreach ($errors as $field => $error) {
            echo '<li>' . htmlentities($error) . '</li>';
        }
        echo '</ul>';
    }
    ?>

    <form method="post" action="">
        <label for="isbn">ISBN: </label><br>
        <input type="text" name="isbn" value="<?php echo htmlentities($isbn); ?>">
        <br>
        <label for="title">Title: </label><br>
        <input type="text" name="title" value="<?php echo htmlentities($title); ?>">
        <br>
        <label for="author">Author: </label><br>
        <input type="text" name="author" value="<?php echo htmlentities($author); ?>">
        <br>
        <label for="publisher">Publisher: </label><br>
        <textarea name="publisher"><?php echo htmlentities($publisher); ?></textarea>
        <br>
        <label for="pages">Pages: </label><br>
        <textarea name="pages"><?php echo htmlentities($pages); ?></textarea>
        <br>

        <input type="hidden" name="form-submitted" value="1">
        <input type="submit" value="Submit">
        <button type="button" onclick="location.href='index.php'">Cancel</button>
    </form>

    <footer>
        <p>Developer: Inma Quesada</p>
    </footer>
</body>

</html>