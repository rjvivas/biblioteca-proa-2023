<?php include "../templates/header.php"; 
      include '../funciones.php';?>

<?php
if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El autor ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito' 
  ];
  $config = include  '../config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $autor = array(
      "nombre"   => $_POST['nombre'],
      "biografia" => $_POST['biografia'],
    );
    
    $consultaSQL = "INSERT INTO autor (nombre, biografia)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($autor)) . ")";
    
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($autor);

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
      <h2 class="mt-4">Agrega un autor</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="form-group">
          <label for="biografia">Biografia</label>
          <input type="text" name="biografia" id="biografia" class="form-control">
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