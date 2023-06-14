<?php
include '../funciones.php';

$config = include '../config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El audiolibro no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $audiolibro = [
        "id" => $_GET['id'],
        "nombre"   => $_POST['nombre'],
        "autor" => $_POST['autor'],
        "editorial"  => $_POST['editorial'],
        "cantidad"    => $_POST['cantidad'],
        "genero"  => $_POST['genero'],
        "duracion"  => $_POST['duracion'],
        "edicion"  => $_POST['edicion'],
        "fecha_de_subida"  => $_POST['fecha_de_subida'],
        "portada_URL_FOTOS"  => $_POST['portada_URL_FOTOS'],
        "peso_archivo"  => $_POST['peso_archivo'],
        "sipnosis"  => $_POST['sipnosis'],
        "archivo"  => $_POST['archivo'],
    ];
    
    $consultaSQL = "UPDATE audiolibros SET
        nombre = :nombre,
        autor = :autor,
        editorial = :editorial,
        cantidad = :cantidad,
        genero = :genero,
        duracion = :duracion,
        edicion = :edicion,
        fecha_de_subida = :fecha_de_subida,
        portada_URL_FOTOS = :portada_URL_FOTOS,
        peso_archivo = :peso_archivo,
        sipnosis = :sipnosis,
        archivo = :archivo,
        updated_at = NOW()
        WHERE id = :id";
    
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($usuario);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM audiolibros WHERE id =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$usuario) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el libro';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "../templates/header.php"; 
?>

<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El audiolibro ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
    header( "refresh:2;url=libros.php" );
}
?>

<?php
if (isset($usuario) && $usuario) {
  ?>
  <div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Editar un audiolibro</h2>
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
          <input type="number" name="editorial" id="editorial" class="form-control">
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
          <input type="number" name="edicion" id="edicion" class="form-control">
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
          <label for="peso_archivo">Peso del archivo</label>
          <input type="text" name="peso_archivo" id="peso_archivo" class="form-control">
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
  <?php
}
?>

<?php require "../templates/footer.php"; ?>