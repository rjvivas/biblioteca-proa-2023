<?php include "../templates/header_ini.php"; ?>

<?php
include '../funciones.php';

session_start();

$error = false;
$config = include '../config.php';

$email = $password = $confirm_password = $nombre = $apellido = $domicilio = $localidad = $numeroTel = "";

$email_err = $password_err = $confirm_password_err = $nombre_err = $localidad_err = $apellido_err = "";

$usuario = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Validar el email

  if(empty(trim($_POST["email"]))){

      $email_err = "Por favor ingrese un email.";

  }
  elseif(empty(trim($_POST["nombre"]))){
      $nombre_err = "Por favor ingrese un nombre.";
  }
  elseif(empty(trim($_POST["apellido"]))){
    $apellido_err = "Por favor ingrese un apellido.";
  }
  elseif(empty(trim($_POST["localidad"]))){
    $localidad_err = "Por favor ingrese una localidad.";
  }
  elseif(empty(trim($_POST["password"]))){

    $password_err = "Por favor ingresa una contraseña.";     

  } elseif(strlen(trim($_POST["password"])) < 6){

    $password_err = "La contraseña al menos debe tener 6 caracteres.";

  } elseif(empty(trim($_POST["confirm_password"]))){

    $confirm_password_err = "Confirma tu contraseña.";     
  } 
  elseif(empty($password_err) && ($password != $confirm_password)){

    $confirm_password_err = "No coincide la contraseña.";
  }
  else {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $query = $conexion->prepare("SELECT * FROM usuario WHERE EMAIL=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        $error = "El e-mail ya esta usado!";
    }
    if ($query->rowCount() == 0) {
        $query = $conexion->prepare("INSERT INTO usuario(email,contrasena,nombre,apellido,domicilio,localidad,numeroTel) VALUES (:email,:password_hash,:nombre,:apellido,:domicilio,:localidad,:numeroTel)");
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("nombre", $_POST["nombre"], PDO::PARAM_STR);
        $query->bindParam("apellido", $_POST["apellido"], PDO::PARAM_STR);
        $query->bindParam("domicilio", $_POST["domicilio"], PDO::PARAM_STR);
        $query->bindParam("localidad", $_POST["localidad"], PDO::PARAM_STR);
        $query->bindParam("numeroTel", $_POST["numeroTel"], PDO::PARAM_STR);
        $result = $query->execute();
        if ($result) {
            echo '  <div class="container mt-2">
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                  Estas registrado!
                </div>
              </div>
            </div>
          </div>';
          header( "refresh:1;url=index.php" );
        } else {
          $error = "Algo salio mal!";
        }
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

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Registrarse</h2>
      <p> (*) significa que es necesario </p>
      <hr>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Nombre (*)</label>
        <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
        <span><?php echo $nombre_err; ?></span><br>
        <label>Apellido (*)</label>
        <input type="text" name="apellido" class="form-control" value="<?php echo $apellido; ?>">
        <span><?php echo $apellido_err; ?></span><br>
        <label>Numero de telefono</label>
        <input type="number" name="numeroTel" class="form-control" value="<?php echo $numeroTel; ?>">
        <label>Domicilio</label>
        <input type="text" name="domicilio" class="form-control" value="<?php echo $domicilio; ?>">
        <label>Localidad (*)</label>
        <input type="text" name="localidad" class="form-control" value="<?php echo $localidad; ?>">
        <span><?php echo $localidad_err; ?></span><br>
        <label>E-mail (*)</label>
        <input type="text" autocomplete="email" name="email" class="form-control" value="<?php echo $email; ?>">
        <span><?php echo $email_err; ?></span><br>
        <label>Contraseña (*)</label>
        <input class="form-control" type="password" autocomplete="new-password" name="password"  value="<?php echo $password; ?>">
        <span><?php echo $password_err; ?></span><br>
        <label>Confirmar contraseña (*)</label>
        <input class="form-control" type="password" autocomplete="new-password" name="confirm_password"  value="<?php echo $confirm_password; ?>">
        <span><?php echo $confirm_password_err; ?></span><br>
        <input class="btn btn-primary mt-4" type="submit" name="register" value="Registrarse">
        <input class="btn btn-primary mt-4" type="reset" value="Borrar"><br>
      </form>
    </div>
  </div>
</div>

<?php include "../templates/footer.php"; ?>