<?php include "../templates/header.php"; ?>

<?php
include '../funciones.php';

$error = false;
$config = include '../config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  // Código que obtendrá la lista de libros

  $consultaSQL = "SELECT * FROM libros";

  if (isset($_POST['txtBusqueda'])) {
    $consultaSQL = "SELECT * FROM libros WHERE nombre LIKE '%" . $_POST['txtBusqueda'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM libros"; 
  }


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

      <!-- Busqueda -->
    <div class="row">
    <div class="col-md-12">
  
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="txtBusqueda" name="txtBusqueda" placeholder="texto de busqueda"  class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">buscar</button>
      </form>

    </div>
  </div>
    <!------ -->

      <h2 class="mt-3">Lista de libros</h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Autor</th>
            <th>Cantidad</th>
            <th>Editorial</th>
            <th>Genero</th>
            <th>Cantidad de paginas</th>
            <th>Edicion</th>
            <th>Foto de Portada</th>
            <th>Sipnosis</th>
            <th>Categoria</th>
            <th>Estado</th>
            <th>popular</th>
            <th>Disponibilidad</th>
            <th>Acción</th>

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
                <td><?php echo escapar($fila["autor"]); ?></td>
                <td><?php echo escapar($fila["cantidad"]); ?></td>
                <td><?php echo escapar($fila["editorial"]); ?></td>
                <td><?php echo escapar($fila["genero"]); ?></td>
                <td><?php echo escapar($fila["cantidad_Paginas"]); ?></td>
                <td><?php echo escapar($fila["edicion"]); ?></td>
                <td><img src="<?php echo escapar($fila["portada_URL_FOTOS"]); ?>" alt="foto" width="70px"></td>
                <td><?php echo escapar($fila["sipnosis"]); ?></td>
                <td><?php echo escapar($fila["categoria"]); ?></td>
                <td><?php echo escapar($fila["estado"]); ?></td>
                <td><?php echo escapar($fila["popular"]); ?></td>
                <td><?php echo escapar($fila["disponibilidad"]); ?></td>
                <td><a class="btn btn-danger" href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>">Eliminar</a><td>
                <td><a class="btn btn-primary" href="<?= 'modificar.php?id=' . escapar($fila["id"]) ?>">Editar</a><td>
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