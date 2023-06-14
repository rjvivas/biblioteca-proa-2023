<?php include "../templates/header.php"; ?>

<?php
include '../funciones.php';

$error = false;
$config = include '../config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  // Código que obtendrá la lista de libros

  $consultaSQL = "SELECT * FROM pdf";
 
  if (isset($_POST['txtBusqueda'])) {
    $consultaSQL = "SELECT * FROM pdf WHERE nombre LIKE '%" . $_POST['txtBusqueda'] . "%' OR editorial LIKE '%" . $_POST['txtBusqueda'] . "%'";
    $valor=$_POST['txtBusqueda'];
  } else {
    $consultaSQL = "SELECT * FROM pdf"; 
  }
  

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $pdf = $sentencia->fetchAll();


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
    <hr>
      <form method="post" class="row row-cols-lg-auto g-6 align-items-center">
        <div class="col-12">
          <input type="text" id="txtBusqueda" name="txtBusqueda" placeholder="Buscar" value="<?php echo isset($_POST['txtBusqueda'])? $_POST['txtBusqueda']:""; ?>" class="form-control">
        </div>
        <div class="col-12">
         <button type="submit" name="submit" class="btn btn-primary">Buscar</button>
       </div>
      </form>

    

    </div>
  </div>
      <h2 class="mt-3">Lista de PDFs</h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Autor</th>
            <th>Editorial</th>
            <th>Cantidad Paginas</th>
            <th>Genero</th>
            <th>Edicion</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($pdf && $sentencia->rowCount() > 0) {
            foreach ($pdf as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["id"]); ?></td>
                <td><?php echo escapar($fila["nombre"]); ?></td>
                <td><?php echo escapar($fila["autor"]); ?></td>
                <td><?php echo escapar($fila["editorial"]); ?></td>
                <td><?php echo escapar($fila["cantidad_Paginas"]); ?></td>
                <td><?php echo escapar($fila["genero"]); ?></td>
                <td><?php echo escapar($fila["edicion"]); ?></td>
                <td><a class="btn btn-primary" href="<?= 'modificar.php?id=' . escapar($fila["id"]) ?>">Editar</a><td>
                <td><a class="btn btn-danger" href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>">Eliminar</a><td>
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
          <a href="crear.php"  class="btn btn-primary mt-4">Agregar libro</a>
          <a href="../index.php"  class="btn btn-primary mt-4">Volver</a>
          <hr>
        </div>
      </div>
    </div>
  </center>
<?php include "../templates/footer.php"; ?>