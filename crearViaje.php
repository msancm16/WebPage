<?php
  session_start();
  require_once 'modelos/Trayecto.php';
  require_once 'modelos/Usuario.php';

  $user = new Usuario();
  $viaje = new Trayecto();

  if (!$_SESSION['login']){
    header("location:login.php");
  }

  if (isset($_GET['q'])){
    $user->userLogout();
    header("location:login.php");
  }

  if($_SESSION['tipo'] != "conductor"){
    header("location:home.php");
  }

  if (isset($_POST['publicar'])){
    $salida = $_POST['salida'];
    $destino = $_POST['destino'];
    $horaSalida = $_POST['horaSalida'];
    $horaLlegada = $_POST['horaLlegada'];
    $diaSalida = $_POST['diaSalida'];
    $diaLlegada = $_POST['diaLlegada'];
    $precio = $_POST['precio'];
    $plazas = $_POST['plazas'];

    $horaSalida = $horaSalida .':00';
    $horaLlegada = $horaLlegada .':00';

    $fechaSalida = $diaSalida . ' ' . $horaSalida;
    $fechaLlegada = $diaLlegada . ' ' . $horaLlegada;

    $register = $viaje->registrarTrayecto($salida,$destino,$fechaSalida,$fechaLlegada,$_SESSION['id'],$precio,$plazas);

    header("location:login.php");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./styles/crearViaje.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto|Montserrat" rel="stylesheet">
    <title>Publicar un viaje</title>
  </head>
  <body>

    <header>

      <div class="container">

          <h1>Logo</h1>

          <nav>
        		<ul>

        			<li class="drop">

        				<a href="home.php" class="userName"><?php echo $_SESSION['nombre']; ?><i class="down"></i></a>

        				<div class="dropdownContain">
        					<div class="dropOut">
        						<div class="triangle"></div>
        						<ul>
        							<?php
                        if($_SESSION['tipo'] != "admin"){
                          echo "<li><a href=\"home.php?v\">Viajes</a></li>";
                        }
                      ?>
        							<li><a href="chat.php">Mensajes</a></li>
        							<li><a href="crearViaje.php?q">Cerrar sesión</a></li>
        						</ul>
        					</div>
        				</div>

        			</li>

        		</ul>
          </nav>

      </div>

    </header>

    <div class="container">

        <form class="" action="" method="post">
          <label>
            <span class="espacio">Salida</span>
            <span>Destino</span>
          </label>

          <input type="text" name="salida" value="" required="">
          <input type="text" name="destino" value="" required="">

          <label>
            <span>Fecha de salida</span>
          </label>

          <input type="date" name="diaSalida" value="" required="">
          <input type="time" name="horaSalida" value="" required="">

          <label>
            <span>Fecha de llegada</span>
          </label>

          <input type="date" name="diaLlegada" value="" required="">
          <input type="time" name="horaLlegada" value="" required="">

          <label>
            <span>Precio del viaje</span>
            <span>Plazas disponibles</span>
          </label>

          <input type="text" name="precio" value="" required="">
          <input type="text" name="plazas" value="" required="">

          <input type="submit" name="publicar" value="Publicar">
        </form>

    </div>
  </body>
</html>
