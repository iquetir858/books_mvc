<?php
// http://www.w3programmers.com/crud-with-php-oop-and-mvc-design-pattern/
// https://github.com/keefekwan/php_crud_mvc_oop

//Se carga el controlador, que es el que va a gestionar la petición del usuario (delete, edit...)
require_once 'controller/BooksController.php';

//Se crea el objeto del controlador
$controller = new BooksController();

//Se gestiona la petición
$controller->handleRequest();

