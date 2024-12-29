<?php
require_once 'Database.php';

//Clase que, tras conectarse a la base de datos, realiza todas las funciones del CRUD
//(mostrar todods, mostrar por id, insertar, editar y borrar
class BooksGateway extends Database
{

    //Realiza un listado de los libros y lo muestra en orden ascendente
    public function selectAll($order)
    {
        if (!isset($order)) {
            $order = 'title';
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
    }

    //función que devuelve sólo un contacto (cambiarlo a libro)
    //El id vendrá de un get (cambiarlo a post) que se le pasa al 'getContact(id)' de BooksService.php
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