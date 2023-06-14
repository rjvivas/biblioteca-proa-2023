<?php include "../templates/header_ini.php"; ?>

<?php
include '../funciones.php';

session_start();

$error = false;
$config = include '../config.php';

$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = $conexion->prepare("SELECT * FROM usuario WHERE email=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $error = "El email o contraseña esta mal! MAL!";
    } else {
        if (password_verify($password, $result['contrasena'])) {
            $_SESSION['user_id'] = $result['id'];
            echo '  <div class="container mt-2">
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                  Bien ahi! Iniciaste sesion
                </div>
              </div>
            </div>
          </div>';
          header( "refresh:1;url=administrar.php" );
        } else {
          $error = "El email o contraseña esta mal! MAL!";
        }
    }
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
    <h1>Iniciar sesion</h1>


    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <hr>
          <form method="post">
            <div class="form-group">
              <label for="nombre">E-mail</label>
              <input type="text" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" name="password" id="password" class="form-control">
            </div>
            </div>
            <button type="submit" name="login" value="login" class="btn btn-primary mt-4">Iniciar sesion</button>
          </form>
      </div>
      <br><br>
      <hr>
      <p>¿No tienes cuenta?</p>
      <a href="registrarse.php"  class="btn btn-primary mt-4">Registrarse</a>
    </div>
  </center>
<?php include "../templates/footer.php"; ?>