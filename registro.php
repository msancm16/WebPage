<?php
  include_once 'modelos/Usuario.php';
  $user = new Usuario();

  session_start();
  if($user->getSession()){
    header("Location: home.php");
  }

  if (isset($_POST['registrar'])){
    $tipoUsuario = $_POST['tipoUsuario'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['movil'];
    $password = $_POST['password'];
    $dni = $_POST['dni'];

    $image = addslashes($_FILES['myFile']['tmp_name']);
    $name = addslashes($_FILES['myFile']['name']);
    $image = file_get_contents($image);
    $image = base64_encode($image);

    $register = $user->registrarUsuario($tipoUsuario, $nombre, $email, $telefono, $password, $dni, $image);
    if ($register) {
      // Registro con éxito
      $msj = 'Registro con éxito <a href="login.php">Haz click aquí</a> para iniciar sesión';
    } else {
      // Registration fallido
      $msj = 'Registro fallido. Ya existe un usuario con ese email.';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/registro.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto|Montserrat" rel="stylesheet">
    <script src="js/registro.js" type="text/javascript">

    </script>

    <title>Registro</title>
  </head>

  <body>
    <?php
        if(isset($register)){
    ?>
    <div class="avisoRegistro">
      <p><?php echo $msj ?></p>
    </div>
    <?php
        }
    ?>
    <header>
      <h1>Registro</h1>
    </header>

    <div class="container">

      <form id="formulario" action="" method="post" enctype="multipart/form-data">

        <input type="text" name="nombre" placeholder="Nombre" required="">
        <input type="text" name="email" placeholder="Email" required="">
        <input type="password" name="password" placeholder="Contraseña" required="">
        <input type="text" name="movil" placeholder="Teléfono móvil" required="">
        <input type="text" name="dni" placeholder="DNI" required="">
        <p class="userType">Tipo de usuario</p>
        <select  name="tipoUsuario">
          <option value="pasajero">Pasajero</option>
          <option value="conductor">Conductor</option>
        </select>
        <div class="foto">
          <label class="labelRuta">
            <input name="myFile" id="myFile" type="file" required=""/>
            Subir imagen
          </label>
          <input class="texto" type="text" id="path" name="ruta">
        </div>

        <input type="submit" name="registrar" value="Regístrate">

      </form>

    </div>

    <div class="container">
      <p class="link">¿Ya estás registrado? <a href="login.php">Entrar</a></p>
    </div>

  </body>

</html>
