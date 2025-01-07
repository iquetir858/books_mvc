<?php
require_once 'Database.php';
require_once 'pdfBooks.php'; //Para la creación del pdf

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
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1; //Página por la que vamos (actual)
        if ($currentPage < 1)
            $currentPage = 1;
        $initRange = ($currentPage - 1) * $booksPerPage; //Índice dentro de la base de datos

        //Obtenemos los libros dentro de ese rango
        $sql = $pdo->query("SELECT * FROM books  order by $order LIMIT $initRange, $booksPerPage");
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

    //función que devuelve sólo un libro
    public function selectById($id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("SELECT * FROM books WHERE id = ?");
        $sql->bindValue(1, $id);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    //Inserta un nuevo libro en la tabla
    public function insert($isbn, $title, $author, $publisher, $pages)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("INSERT INTO books (isbn, title, author, publisher, pages) VALUES (?, ?, ?, ?, ?)");
        $result = $sql->execute(array($isbn, $title, $author, $publisher, $pages));
    }

    //Edita un libro
    public function edit($isbn, $title, $author, $publisher, $pages, $id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("UPDATE books set isbn = ?, title = ?, author = ?, publisher = ?, pages = ? WHERE id = ? LIMIT 1");
        $result = $sql->execute(array($isbn, $title, $author, $publisher, $pages, $id));
    }

    //Borra un libro según un id
    public function delete($id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("DELETE FROM books WHERE id = ?");
        $sql->execute(array($id));
    }

    public function showPDF($orderby, $page, $nbooks)
    {
        $pdo = Database::connect();

        $pdf = new PDF();
        $pdf->AddPage();
        // Tabla libros seleccionados
        $pdf->AddCol('isbn', 30, 'ISBN', 'C');
        $pdf->AddCol('title', 55, 'Title', 'C');
        $pdf->AddCol('author', 35, 'Author', 'C');
        $pdf->AddCol('publisher', 50, 'Publisher', 'C');
        $pdf->AddCol('pages', 15, 'Pages', 'C');

        //COLORES DE LA ÚLTIMA TABLA
        $prop = array(
            'HeaderColor' => array(255, 132, 108),
            'color1' => array(249, 206, 198),
            'color2' => array(248, 230, 227),
            'padding' => 2
        );
        $init = ($page - 1) * 10;
        //LIMIT $init, $nbooks --> a partir del primer elemento de esa página (en cada pag hay 10), coge el numLibros indicados
        $pdf->Table($pdo, "SELECT * FROM books ORDER BY $orderby ASC LIMIT $init,$nbooks", $prop);
        $pdf->Output();
    }
}
?>