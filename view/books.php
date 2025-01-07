<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Info Books</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7b7111c316.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="view/general.css">
    <link rel="stylesheet" type="text/css" href="view/listing.css">
</head>

<body>
    <header>
        <h1>BOOKS MVC</h1>
    </header>

    <?php
    //Obtenemos la página actual aquí para el orden 
    $currentPage = (!isset($_GET['page']) || $_GET['page'] < 1) ? 1 : (int) $_GET['page']; //Página por la que vamos (actual)
    $order = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
    ?>

    <div id="operations">
        <div id="newBook"><a href="index.php?op=new"><i class="fa-solid fa-circle-plus"></i> Add new book</a></div>
        <div id="pdf">
            <form method="GET">
                <input type="text" name="page" value="<?php echo $currentPage ?>" hidden>
                <input type="text" name="orderby" value="<?php echo $order ?>" hidden>
                <input type="number" placeholder="Number of books" name="nbooks" min="1">
                <input id="inputSubmit" type="submit" name="op" value="Generate PDF">
            </form>
        </div>
    </div>
    <br>

    <table class="books" border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><a href="?orderby=isbn&page=<?php echo $currentPage ?>">ISBN</a></th>
                <th><a href="?orderby=title&page=<?php echo $currentPage ?>">Title</a></th>
                <th><a href="?orderby=author&page=<?php echo $currentPage ?>">Author</a></th>
                <th><a href="?orderby=publisher&page=<?php echo $currentPage ?>">Publisher</a></th>
                <th><a href="?orderby=pages&page=<?php echo $currentPage ?>">Pages</a></th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <!-- Se recorre el array de libros (en este caso el de mostrar - showAll) y va mostrando su info-->
            <?php foreach ($books as $book): ?>
                <tr>
                    <td>
                        <a href="index.php?op=show&id=<?php echo $book->id; ?>"><?php echo htmlentities($book->isbn); ?></a>
                    </td>
                    <td><?php echo htmlentities($book->title); ?></td>
                    <td><?php echo htmlentities($book->author); ?></td>
                    <td><?php echo htmlentities($book->publisher); ?></td>
                    <td><?php echo htmlentities($book->pages); ?></td>
                    <td>
                        <a href="index.php?op=edit&id=<?php echo $book->id; ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        &nbsp;&nbsp;
                        <a href="index.php?op=delete&id=<?php echo $book->id; ?>"
                            onclick="return confirm('Are you sure you want to delete?');"><i
                                class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="pagination">
        <?php
        if ($currentPage > 1): ?>
            <a href="?orderby=<?php echo $order ?>&page=1">&laquo; First |</a>
            <a href="?orderby=<?php echo $order ?>&page=<?= $currentPage - 1 ?>">&larr; Previous</a>
        <?php endif;

        ?>
        | Page <?= $currentPage ?> of <?= $totalNumPages ?> |
        <?php

        if ($currentPage < $totalNumPages): ?>
            <a href="?orderby=<?php echo $order ?>&page=<?= $currentPage + 1 ?>">Next &rarr;</a>
            <a href="?orderby=<?php echo $order ?>&page=<?= $totalNumPages ?>">| Last &raquo;</a>
        <?php endif; ?>
    </div>

    <footer>
        <p>Developer: Inma Quesada</p>
    </footer>
</body>

</html>