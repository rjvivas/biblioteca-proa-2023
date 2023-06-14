<?php
include '../funciones.php';

$config = include '../config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El libro no existe';
}

if (isset($_POST['submit'])) {
  try {

    //obtener el archivo
    $fileaudiolibro=subirArchivo('portada_URL_FOTOS','AUDIOLIBRO');
   
    
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $libro = [
        "id" => $_GET['id'],
        "nombre"   => $_POST['nombre'],
        "autor" => $_POST['autor'],
        "cantidad"    => $_POST['cantidad'],
        "editorial"  => $_POST['editorial'],
        "genero"  => $_POST['genero'],
        "cantidad_Paginas"  => $_POST['cantidad_Paginas'],
        "edicion"  => $_POST['edicion'],
        "fecha_Inscripcion"  => $_POST['fecha_Inscripcion'],
        "portada_URL_FOTOS"  =>$fileaudiolibro,
        "sipnosis"  => $_POST['sipnosis'],
        "categoria"  => $_POST['categoria'],
        "estado"  => $_POST['estado'],
        "disponibilidad"  => $_POST['disponibilidad'],
    ];
    
    $consultaSQL = "UPDATE libros SET
        nombre = :nombre,
        autor = :autor,
        cantidad = :cantidad,
        editorial = :editorial,
        genero = :genero,
        cantidad_Paginas = :cantidad_Paginas,
        edicion = :edicion,
        fecha_Inscripcion = :fecha_Inscripcion,
        portada_URL_FOTOS = :portada_URL_FOTOS,
        sipnosis = :sipnosis,
        categoria = :categoria,
        estado = :estado,
        disponibilidad = :disponibilidad,
        updated_at = NOW()
        WHERE id = :id";
    
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($libro);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM libros WHERE id =" . $id;



  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $libro = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$libro) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el libro';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "../templates/header.php"; ?>

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
          El libro ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
    header( "refresh:2;url=index.php" );
}
?>

<?php
if (isset($libro) && $libro) {
  ?>
  <div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Editar un libro</h2>
      <hr>
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" value="<?= escapar($libro['nombre']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="autor">Autor</label>
          <select class="form-select" aria-label="Default select example" value="<?= escapar($libro['autor']) ?>" name="autor">
          <option selected>SELECCIONAR</option>
            <?php 
            $autores = getAutores(); 
            foreach ($autores as $fila) {
              echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="cantidad">Cantidad</label>
          <input type="number" name="cantidad" id="cantidad" value="<?= escapar($libro['cantidad']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="editorial">Editorial</label>
          <input type="text" name="editorial" id="editorial" value="<?= escapar($libro['editorial']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="genero">Genero</label>
          <input type="text" name="genero" id="genero" value="<?= escapar($libro['genero']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="cantidad_Paginas">Cantidad de paginas</label>
          <input type="number" name="cantidad_Paginas" id="cantidad_Paginas" value="<?= escapar($libro['cantidad_Paginas']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="edicion">Edicion</label>
          <input type="text" name="edicion" id="edicion" value="<?= escapar($libro['edicion']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="fecha_Inscripcion">Fecha de Inscripcion</label>
          <input type="date" name="fecha_Inscripcion" id="fecha_Inscripcion" value="<?= escapar($libro['fecha_Inscripcion']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="portada_URL_FOTOS">Foto de Portada</label>
          <input type="file" name="portada_URL_FOTOS" id="portada_URL_FOTOS" value="<?= escapar($libro['portada_URL_FOTOS']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="sipnosis">Sipnosis</label>
          <input type="text" name="sipnosis" id="sipnosis" value="<?= escapar($libro['sipnosis']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="categoria">Categoria</label>
          <input type="text" name="categoria" id="categoria" value="<?= escapar($libro['categoria']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="estado">Estado</label>
          <input type="text" name="estado" id="estado" value="<?= escapar($libro['estado']) ?>" class="form-control">
        </div>
        <div class="form-group">
          <label for="disponibilidad">Disponibilidad</label>
          <input type="text" name="disponibilidad" id="disponibilidad" value="<?= escapar($libro['disponibilidad']) ?>" class="form-control">
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