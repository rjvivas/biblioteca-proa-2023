<?php

/* Credenciales de la base de datos. Suponiendo que está ejecutando MySQL

 con configuración predeterminada (usuario 'root' sin contraseña) */

define('DB_SERVER', '192.168.40.154');//nombre del servidor

define('DB_USERNAME', 'pablo');//nombre de usuario del servidor

define('DB_PASSWORD', '1234');//contraseña del servidor

define('DB_NAME', 'biblioteca_libros');//nombre de la base de datos

 

/* Prueba de conexión a la base de datos MySQL*/

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

 

// Se verifica la conexión, si no se puede realizar se indica el error

if($link === false){

    die("ERROR: Could not connect. " . mysqli_connect_error());

}

?>