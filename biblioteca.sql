CREATE DATABASE biblioteca.sql;

use biblioteca.sql;

CREATE TABLE usuario(
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  apellido VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL,
  numeroTel INT(12) NOT NULL,
  domicilio VARCHAR(40) NOT NULL,
  localidad VARCHAR(25) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE libros(
 id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  autor VARCHAR(30) NOT NULL,
  cantidad INT(20),
  editorial VARCHAR (30) NOT NULL,
  genero VARCHAR(20) NOT NULL,
  cantidad_Paginas INT(11) NOT NULL,
  edicion INT(20) NOT NULL,
  portada_URL_FOTOS VARCHAR (250) NOT NULL,
  sipnosis VARCHAR (11) NOT NULL,
  categoria VARCHAR (50) NOT NULL,
  estado VARCHAR (20) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE PDF(
 id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR (80) NOT NULL,
 autor VARCHAR (30) NOT NULL,
 editorial VARCHAR (30) NOT NULL,
 genero VARCHAR (20) NOT NULL,
 cantidad_Paginas INT(11) NOT NULL,
 edicion INT(20) NOT NULL,
 portada_URL_FOTOS VARCHAR (250) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ALQUILER(
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_libros INT(30) NOT NULL,
  estado_en_el_que_lo_entrego VARCHAR(50) NOT NULL,
  id_usuario INT (10) NOT NULL,
  responsable a cargo en ese momento VARCHAR(10) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
); 

CREATE TABLE AUDIOLIBROS(
 id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(80) NOT NULL,
 autor VARCHAR(30) NOT NULL,
 editorial VARCHAR (30) NOT NULL,
 genero VARCHAR (20) NOT NULL,
 duracion del audio VARCHAR (40) NOT NULL,
 edicion INT (30) NOT NULL,
 portada_URL_FOTOS VARCHAR (250) NOT NULL,
 peso_archivo VARCHAR (500) NOT NULL,
 sipnosis VARCHAR (11) NOT NULL,
 archivo VARCHAR (2000) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
); 

CREATE TABLE AUTOR(
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  generos VARCHAR (200) NOT NULL,  
  descripision VARCHAR(200) NOT NULL,
)

CREATE TABLE comentario(
   id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(80) NOT NULL,
   email VARCHAR(200) NOT NULL,
   telefono  VARCHAR(80) NOT NULL,
   comentario VARCHAR(500) NOT NULL,
)