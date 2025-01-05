<?php
require_once 'Database.php';

//Clase que, tras conectarse a la base de datos, realiza todas las funciones del CRUD
//(mostrar todods, mostrar por id, insertar, editar y borrar
class BooksGateway extends Database
{
    //Realiza un listado de los libros y lo muestra en orden ascendente
    //------VERSIÓN 1- Muestra los libros (los que haya)
    /*public function selectAll($order)
    {
        if (!isset($order)) {
            $order = 'id';
        }
        $pdo = Database::connect();
        $sql = $pdo->prepare("SELECT * FROM books ORDER BY $order ASC");
        $sql->execute();
        // $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        $books = array();
        while ($obj = $sql->fetch(PDO::FETCH_OBJ)) {
            $books[] = $obj;
        }
        return $books;
    }*/

    //-------VERSIÓN 2 -  Sólo muestra x según la página en la que esté
    public function selectAll($order)
    {
        if (!isset($order)) {
            $order = 'id';
        }
        $pdo = Database::connect();
        $booksPerPage = 10; //Nºlibros por página
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; //Página por la que vamos (actual)
        if ($currentPage < 1) $currentPage = 1;
        $initRange = ($currentPage - 1) * $booksPerPage; //Índice dentro de la base de datos

        //Obtenemos los libros dentro de ese rango
        $sql = $pdo->query("SELECT * FROM books LIMIT $initRange, $booksPerPage");
        $sql->execute();
        $books = array();
        while ($obj = $sql->fetch(PDO::FETCH_OBJ)) {
            $books[] = $obj;
        }
        return $books;
    }

    public function getTotalNumPages()
    {
        $pdo = Database::connect();
        $booksPerPage = 10; //Nºlibros por página

        //Calculamos el nºtotal de páginas según los libros almacenados
        $numBooks = $pdo->query("SELECT COUNT(*) AS total FROM books");
        $total = $numBooks->fetch(PDO::FETCH_ASSOC)['total'];
        return ceil($total / $booksPerPage);
    }

    //función que devuelve sólo un contacto (cambiarlo a libro)
    //El id vendrá de un get que se le pasa al 'getContact(id)' de BooksService.php
    //desde el BooksController.php
    public function selectById($id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("SELECT * FROM books WHERE id = ?");
        $sql->bindValue(1, $id);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    //Inserta un nuevo contacto en la tabla
    public function insert($isbn, $title, $author, $publisher, $pages)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("INSERT INTO books (isbn, title, author, publisher, pages) VALUES (?, ?, ?, ?, ?)");
        $result = $sql->execute(array($isbn, $title, $author, $publisher, $pages));
    }

    //Edita un contacto
    public function edit($isbn, $title, $author, $publisher, $pages, $id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("UPDATE books set isbn = ?, title = ?, author = ?, publisher = ?, pages = ? WHERE id = ? LIMIT 1");
        $result = $sql->execute(array($isbn, $title, $author, $publisher, $pages, $id));
    }

    //Borra un contacto según un id
    public function delete($id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("DELETE FROM books WHERE id = ?");
        $sql->execute(array($id));
    }
}

?>