<?php
//Requiere los archivos de Gateaway (el que hace las consultas sql), el de error y el de la
//conexión a la base de datos
require_once 'BooksGateway.php';
require_once 'ValidationException.php';
require_once 'Database.php';

class BooksService extends BooksGateway
{

    private $booksGateway = null;

    //Constructor que crea un objeto BooksGateway
    public function __construct()
    {
        $this->booksGateway = new BooksGateway();
    }

    //Función que llama a la función de seleccionar todos los libros (booksGateway)
    public function getAllBooks($order)
    {
        try {
            self::connect();
            $res = $this->booksGateway->selectAll($order);
            self::disconnect();
            return $res;
        } catch (Exception $e) {
            self::disconnect();
            throw $e;
        }
    }

    //Función que llama a la función de devolver 1 libro según un ID (booksGateway)
    public function getBook($id)
    {
        try {
            self::connect();
            $result = $this->booksGateway->selectById($id);
            self::disconnect();
            return $result;
        } catch (Exception $e) {
            self::disconnect();
            throw $e;
        }
        //No llega a este result pq hace un return o un throw
        //return $this->booksGateway->selectById($id);
    }

    //Función que valida los errores de los parámetros de entrada  (por si están vacíos)
    private function validateBookParams($isbn, $title, $author, $publisher, $pages)
    {
        //CAMBIAR ESTO A LOS DATOS DE LOS LIBROS
        //id isbn title author publisher pages
        $errors = array();
        if (!isset($isbn) || empty($isbn)) {
            $errors[] = 'ISBN field is required';
        }
        if (!isset($title) || empty($title)) {
            $errors[] = 'TITLE field is required';
        }
        if (!isset($author) || empty($author)) {
            $errors[] = 'AUTHOR field is required';
        }
        if (!isset($publisher) || empty($publisher)) {
            $errors[] = 'PUBLISHER field is required';
        }
        if (!isset($pages) || empty($pages)) {
            $errors[] = 'PAGES field is required';
        }
        if (empty($errors)) {
            return;
        }
        throw new ValidationException($errors);
    }

    //Función que crea un nuevo contacto con los datos de entrada y emplea la función de arriba
    //para asegurar que no están vacíos (si hay errores salta excepción y se corta la conexión
    //si no hay errores, inserta un nuevo contacto
    public function createNewBook($isbn, $title, $author, $publisher, $pages)
    {
        try {
            self::connect();
            $this->validateBookParams($isbn, $title, $author, $publisher, $pages);
            $result = $this->booksGateway->insert($isbn, $title, $author, $publisher, $pages);
            self::disconnect();
            return $result;
        } catch (Exception $e) {
            self::disconnect();
            throw $e;

        }
    }

    //Función que edita la información de un libro concreto
    public function editBook($isbn, $title, $author, $publisher, $pages, $id)
    {
        try {
            self::connect();
            $result = $this->booksGateway->edit($isbn, $title, $author, $publisher, $pages, $id);
            self::disconnect();
        } catch (Exception $e) {
            self::disconnect();
            throw $e;
        }
    }

    //Función que borra un libro según su id
    public function deleteBook($id)
    {
        try {
            self::connect();
            $result = $this->booksGateway->delete($id);
            self::disconnect();
        } catch (Exception $e) {
            self::disconnect();
            throw $e;
        }
    }

    public function showPDF($orderby, $page, $nbooks)
    {
        try {
            self::connect();
            $this->booksGateway->showPDF($orderby, $page, $nbooks);
            self::disconnect();
        } catch (Exception $e) {
            self::disconnect();
            throw $e;
        }
    }
}
?>