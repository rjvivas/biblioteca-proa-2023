<?php
    function escapar($html) {
        return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
    }





    // Funcion para obtener la lista de autores
    function getAutores(){
        $config = include  'config.php';
        

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
    $consultaSQL = "SELECT * FROM autor";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

   return $sentencia->fetchAll();

  } catch(PDOException $error) {
    return $error->getMessage();
  }
    }






    //Función para subir un archivo
    function subirArchivo($nombre,$tipo){

      if($tipo=="AUDIOLIBRO"){
        $uploaddir = './archivoaudiolibros/';
        if(!file_exists($uploaddir)){
          mkdir($uploaddir, 0777);

        }
      }

      
   
      $uploadfile = $uploaddir . basename($_FILES[$nombre]['name']);
      
     

     echo '<pre>';
     
      if (move_uploaded_file($_FILES[$nombre]['tmp_name'], $uploadfile)) {
          echo "El archivo es válido, y se ha cargado correctamente.\n";
          return $uploadfile;
      } else {
          echo "Possible file upload attack!\n";
          return null;
      }

      echo 'Here is some more debugging info:';
      print_r($_FILES);

      print "</pre>";
    }
?>
