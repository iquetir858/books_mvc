<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Info Books</title>
    <!-- <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7b7111c316.js" crossorigin="anonymous"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: azure;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 100vh;
            margin: 0; /*Elimina los espacios del footer*/
        }

        table {
            width: 80%;
            margin: 20px auto;
            border: 2px solid darkblue;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            border: 2px solid darkblue;
        }

        a:hover, a:visited:hover {
            color: deeppink;
        }

        a:visited {
            color: purple;
        }

        #newBook {
            margin: 20px;
        }

        #pagination {
            margin: 10px 10px 20px 10px;
        }

        header, footer {
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: darkblue;
            font-size: 20px;
            color: azure;
        }
    </style>
</head>
<body>
<header><h1>BOOKS MVC</h1></header>
<div id="newBook"><a href="index.php?op=new">Add new book</a></div>
<br>
<table class="books" border="0" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th><a href="?orderby=isbn">ISBN</a></th>
        <th><a href="?orderby=title">Title</a></th>
        <th><a href="?orderby=author">Author</a></th>
        <th><a href="?orderby=publisher">Publisher</a></th>
        <th><a href="?orderby=pages">Pages</a></th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    <!-- Se recorre el array de libros (en este caso el de mostrar - showAll) y va mostrando su info-->
    <?php foreach ($books as $book) : ?>
        <tr>
            <td>
                <a href="index.php?op=show&id=<?php echo $book->id; ?>"><?php echo htmlentities($book->isbn); ?></a>
            </td>
            <td><?php echo htmlentities($book->title); ?></td>
            <td><?php echo htmlentities($book->author); ?></td>
            <td><?php echo htmlentities($book->publisher); ?></td>
            <td><?php echo htmlentities($book->pages); ?></td>
            <td>
                <a href="index.php?op=edit&id=<?php echo $book->id; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                &nbsp;&nbsp;
                <a href="index.php?op=delete&id=<?php echo $book->id; ?>"
                   onclick="return confirm('Are you sure you want to delete?');"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div id="pagination">
    <?php
    $currentPage = (!isset($_GET['page']) || $_GET['page'] < 1) ? 1 : (int)$_GET['page']; //Página por la que vamos (actual)

    if ($currentPage > 1): ?>
        <a href="?page=1">&laquo; First |</a>
        <a href="?page=<?= $currentPage - 1 ?>">&larr; Previous</a>
    <?php endif;

    ?>
    | Page <?= $currentPage ?> of <?= $totalNumPages ?> |
    <?php

    if ($currentPage < $totalNumPages): ?>
        <a href="?page=<?= $currentPage + 1 ?>">Next &rarr;</a>
        <a href="?page=<?= $totalNumPages ?>">| Last &raquo;</a>
    <?php endif; ?>
</div>

<footer>
    <p>Developer: Inma Quesada</p>
</footer>
</body>
</html>
