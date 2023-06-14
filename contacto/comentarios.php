<h1>Zona de comentario</h1>
<?php
if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El comentario ha sido agregado con éxito' 
  ];
  $config = include '../config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $alumno = array(
      "nombre"   => $_POST['nombre'],
      "telefono" => $_POST['telefono'],
      "email"    => $_POST['email'],
      "comentario"     => $_POST['comentario'],
    );
    
    $consultaSQL = "INSERT INTO comentario (nombre, telefono, email, comentario)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($alumno)) . ")";
    
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($alumno);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include "../templates/header_ini.php"; ?>

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
  header("refresh:1;url=/index.php");
}
?>