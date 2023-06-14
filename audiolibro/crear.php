<?php include "../templates/header.php"; 

      include '../funciones.php';?>

<?php
if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El audiolibro ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito' 
  ];
  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $audiolibro = array(
      "nombre"   => $_POST['nombre'],
      "autor" => $_POST['autor'],
      "editorial"    => $_POST['editorial'],
      "genero"   => $_POST['genero'],
      "duracion" => $_POST['duracion'],
      "edicion"    => $_POST['edicion'],
      "fecha_de_subida" => $_POST['fecha_de_subida'],
      "portada_URL_FOTOS"    => $_POST['portada_URL_FOTOS'],
      "peso_archivo" => $_POST['peso_archivo'],
      "sipnosis"    => $_POST['sipnosis'],
      "archivo"    => $_POST['archivo'],
    );
    
    $consultaSQL = "INSERT INTO audiolibros (nombre, autor, editorial, genero, duracion, edicion, fecha_de_subida, portada_URL_FOTOS, peso_archivo, sipnosis, archivo)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($audiolibro)) . ")";
    
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($libro);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Agrega un audiolibro</h2>
      <hr>
      <form method="post">
      <div class="form-group">
      <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="form-group">
          <label for="autor">Autor</label>
          <input type="text" name="autor" id="autor" class="form-control">
        </div>
        <div class="form-group">
          <label for="editorial">Editorial</label>
          <input type="text" name="editorial" id="editorial" class="form-control">
        </div>
        <div class="form-group">
          <label for="genero">Genero</label>
          <input type="text" name="genero" id="genero" class="form-control">
        </div>
        <div class="form-group">
          <label for="duracion">Duracion</label>
          <input type="text" name="duracion" id="duracion" class="form-control">
        </div>
        <div class="form-group">
          <label for="edicion">Edicion</label>
          <input type="text" name="edicion" id="edicion" class="form-control">
        </div>              
        <div class="form-group">
          <label for="fecha_de_subida">Fecha de subida</label>
          <input type="text" name="fecha_de_subida" id="fecha_de_subida" class="form-control">
        </div>
        <div class="form-group">
          <label for="portada_URL_FOTOS">Foto de Portada</label>
          <input type="file" name="portada_URL_FOTOS" id="portada_URL_FOTOS" class="form-control">
        </div>
        <div class="form-group">
          <label for="peso_archivo">Peso de archivo</label>
          <input type="file" name="peso_archivo" id="peso_archivo" class="form-control">
        </div>
        <div class="form-group">
          <label for="sipnosis">Sipnosis</label>
          <input type="text" name="sipnosis" id="sipnosis" class="form-control">
        </div>
        <div class="form-group">
          <label for="archivo">Archivo</label>
          <input type="file" name="archivo" id="archivo" class="form-control">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include "../templates/footer.php"; ?>