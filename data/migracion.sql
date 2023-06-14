CREATE DATABASE biblioteca_libros;

use biblioteca_libros;

CREATE TABLE libros (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  autor VARCHAR(80) NOT NULL,
  cantidad INT(80) NOT NULL
);