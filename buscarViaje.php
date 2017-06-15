<?php
  session_start();
  require_once 'modelos/Usuario.php';

  $user = new Usuario();

  if (!$_SESSION['login']){
    header("location:login.php");
  }

  if (isset($_GET['q'])){
    $user->userLogout();
    header("location:login.php");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto|Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="./styles/buscarViaje.css">
    <script src="js/buscar.js" type="text/javascript">  </script>
    <title>Publicar un viaje</title>
  </head>
  <body>

    <header>
      <div class="container">

          <h1>Logo</h1>

          <nav>
        		<ul>

        			<li class="drop">
                <span class="userName2"><?php echo $_SESSION['nombre']; ?></span>
                <?php
                  echo "<img class=\"userNameImage\" src=\"data:image;base64,$_SESSION[imagen]\" width=50 />";
                ?>
        				<a href="buscarViaje.php" class="userName"><i class="down"></i></a>

        				<div class="dropdownContain">
        					<div class="dropOut">
        						<div class="triangle"></div>
        						<ul>
        							<li><a href="home.php">Perfil</a></li>
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

    <div class="cuerpo">
      <button type="button" id="abrirFiltro"> &#9776; Filtros</button>

      <div id="mySidenav" class="sidenav">
        <a id="cerrarFiltro">&times;</a>

        <div class="panel">
          <label>
            <span>Origen</span>
            <input type="text" id="origen" value="" required="">
          </label>
          <label>
            <span>Destino</span>
            <input type="text" id="destino" value="" required="">
          </label>
          <label>
            <span>Fecha de salida</span>
            <input type="date" id="fecha" value="" required="">
          </label>
          <label>
            <span>Precio</span>
            <input type="text" id="precio" value="" required="">
          </label>
          <label>
            <span>Plazas</span>
            <input type="text" id="plazas" value="" required="">
          </label>
          <label>
            <span>Valoracion</span>
            <div class="ec-stars-wrapper">
            	<a href="#" id="1" value="1" title="Votar con 1 estrellas">&#9733;</a>
            	<a href="#" id="2" value="2" title="Votar con 2 estrellas">&#9733;</a>
            	<a href="#" id="3" value="3" title="Votar con 3 estrellas">&#9733;</a>
            	<a href="#" id="4" value="4" title="Votar con 4 estrellas">&#9733;</a>
            	<a href="#" id="5" value="5" title="Votar con 5 estrellas">&#9733;</a>
            </div>
            <input type="number" id="valoracion" min="1" max="5" value="0" readonly="true">
          </label>

          <button type="button" id="aplicar"> Aplicar Filtros </button>
        </div>

      </div>
    </div>

    <div class="results">

    </div>
  </body>
</html>
