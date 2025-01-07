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
            font-family: Roboto;
        }

        body {
            background-color: #fff8f8;
            text-align: center;
            min-height: 150vh;
            margin: 0;
            /*Elimina los espacios del footer*/
        }

        table {
            width: 80%;
            margin: auto;
            border: 2px solid #5e1717;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            border: 2px solid #5e1717;
        }

        a {
            color: #5e1717;
        }

        a:hover,
        a:visited:hover {
            color: darkgoldenrod;
        }

        a:visited {
            color: #5e1717;
        }

        #operations {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
        }

        #pdf input {
            border: 1px solid #5e1717;
            border-radius: 5px;
            font-size: 16px;
            width: 150px;
        }

        #pdf button {
            font-weight: bold;
            color: #5e1717;
            background-color: gold;
            border-radius: 5px;
            font-size: 16px;
        }

        #pdf button:hover {
            color: gold;
            background-color: #5e1717;
        }

        #newBook {
            margin: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        #pagination {
            margin: 10px 10px 20px 10px;
        }

        header,
        footer {
            margin: 0;
            width: 100%;
            background-color: #5e1717;
            font-size: 20px;
            color: #fff8f8;
        }

        header {
            position: relative;
            top: 0;
            padding: 5px 0px 5px 0px;
        }

        footer {
            position: fixed;
            bottom: 0;
        }
    </style>
</head>

<body>
    <header>
        <h1>BOOKS MVC</h1>
    </header>
    <div id="operations">
        <div id="newBook"><a href="index.php?op=new"><i class="fa-solid fa-circle-plus"></i> Add new book</a></div>
        <div id="pdf">
            <input type="number" placeholder="Number of books" name="nbooks" min="1">
            <button>Generate PDF</button>
        </div>
    </div>
    <br>
    <?php
    //Obtenemos la página actual aquí para el orden 
    $currentPage = (!isset($_GET['page']) || $_GET['page'] < 1) ? 1 : (int) $_GET['page']; //Página por la que vamos (actual)
    $order = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
    ?>

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
            <a href="?orderby=<?php echo $order?>&page=1">&laquo; First |</a>
            <a href="?orderby=<?php echo $order?>&page=<?= $currentPage - 1 ?>">&larr; Previous</a>
        <?php endif;

        ?>
        | Page <?= $currentPage ?> of <?= $totalNumPages ?> |
        <?php

        if ($currentPage < $totalNumPages): ?>
            <a href="?orderby=<?php echo $order?>&page=<?= $currentPage + 1 ?>">Next &rarr;</a>
            <a href="?orderby=<?php echo $order?>&page=<?= $totalNumPages ?>">| Last &raquo;</a>
        <?php endif; ?>
    </div>

    <footer>
        <p>Developer: Inma Quesada</p>
    </footer>
</body>

</html>