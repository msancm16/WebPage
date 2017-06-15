<?php
  session_start();
  include_once 'modelos/Usuario.php';
  $user = new Usuario();

  if ($user->getSession()){
    header("location:home.php");
  }

  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = $user->check_login($email, $password);

    if ($login) {
      // Acceso con éxito
      echo $_SESSION['id'];
      $msj = "";
      header("location:home.php");

    } else {
      // Acceso fallido
      $msj = 'Email o contraseña incorrectos';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto|Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="styles/login.css">

    <title>Inicio de Sesión</title>
  </head>

  <body>

    <?php
        if(isset($login)){
    ?>
    <div class="avisoLogin">
      <p><?php echo $msj ?></p>
    </div>
    <?php
        }
    ?>

    <header>
      <h1>Iniciar Sesión</h1>
    </header>

    <div class="container">

      <form class="" action="" method="post">

        <input type="text" name="email" placeholder="Email" required="">
        <input type="password" name="password" placeholder="Contraseña" required="">

        <input type="submit" name="login" value="Iniciar sesión">

      </form>

    </div>

    <div class="container">
      <p class="link">¿No tienes cuenta? <a href="registro.php">Regístrate ahora</a></p>
    </div>


  </body>
</html>
