<?php include "../templates/header.php"; ?>

<?php
include '../funciones.php';

session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
} else {
    // Show users the page! 
}

$error = false;
$config = include '../config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $consultaSQL = "SELECT * FROM usuario";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $libros = $sentencia->fetchAll();


} catch(PDOException $error) {
  $error = $error->getMessage();
}
?>

<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

  <!-- Aquí el código HTML de la aplicación -->

  
  <center>
    <h1>Biblioteca</h1>

    <div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3">Lista de usuarios</h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>E-mail</th>
            <th>Localidad</th>
            <th>Numero de telefono</th>
            <th>Domicilio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($libros && $sentencia->rowCount() > 0) {
            foreach ($libros as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["id"]); ?></td>
                <td><?php echo escapar($fila["nombre"]); ?></td>
                <td><?php echo escapar($fila["apellido"]); ?></td>
                <td><?php echo escapar($fila["email"]); ?></td>
                <td><?php echo escapar($fila["localidad"]); ?></td>
                <td><?php echo escapar($fila["numeroTel"]); ?></td>
                <td><?php echo escapar($fila["domicilio"]); ?></td>
                <td>
                    <a class="btn btn-primary" href="<?= 'editar.php?id=' . escapar($fila["id"]) ?>">Editar</a>
                    <a class="btn btn-danger" href="<?= 'eliminar.php?id=' . escapar($fila["id"]) ?>">Eliminar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <a href="../index.php"  class="btn btn-primary mt-4">Volver</a>
          <hr>
        </div>
      </div>
    </div>
  </center>
<?php include "../templates/footer.php"; ?>