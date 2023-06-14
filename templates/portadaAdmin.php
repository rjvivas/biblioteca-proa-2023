<?php

session_start();

$error = false;
$config = include '../config.php';

$nombre = "";

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $consultaSQL = "SELECT nombre FROM usuario WHERE id =" . $_SESSION['user_id'];

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $usuario = $sentencia->fetchAll();

  foreach ($usuario as $fila) {
    $nombre = $fila["nombre"];
  }
} catch(PDOException $error) {
  $error = $error->getMessage();
}
?>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="assets/img/logo biblioteca pagina.svg" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="/libros/index.php">Libros</a></li><!--"#portfolio"-->
                        <li class="nav-item"><a class="nav-link" href="/audiolibro/index.php">Audio libros</a></li>
                        <li class="nav-item"><a class="nav-link" href="/pdf/index.php">PDF</a></li>
                        <li class="nav-item"><a class="nav-link" href="/autor/index.php">Autor</a></li>
                        <li class="nav-item"><a style="font-weight: bold;" class="nav-link" value="nombre"><?php echo $nombre; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="/usuario/logout.php">Cerrar Sesion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
               <!-- Masthead-->
               <header class="masthead" style=" padding-top: 7px;background-position-y: -900px;">
            <div class="container">

            </div>
        </header>