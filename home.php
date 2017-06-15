<?php
  session_start();
  require_once 'modelos/Usuario.php';
  require_once 'modelos/Trayecto.php';
  $user = new Usuario();

  if (!$user->getSession()){
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
    <link rel="stylesheet" href="./styles/home.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto|Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="styles/starrr.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/starrr.js"></script>
    <script src="js/home.js" type="text/javascript"></script>
    <title>Home</title>
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
        				<a href="home.php" class="userName"><i class="down"></i></a>

        				<div class="dropdownContain">
        					<div class="dropOut">
        						<div class="triangle"></div>
        						<ul>
                      <?php
                        if($_SESSION['tipo'] != "admin"){
                          echo "<li><a href=\"home.php?v\">Viajes</a></li>".
                          "<li><a href=\"chat.php\">Mensajes</a></li>";
                        }else{
                          echo "<li><a href=\"home.php?u\">Usuarios</a></li>";
                        }
                       ?>
        							<li><a href="home.php?q">Cerrar sesión</a></li>
        						</ul>
        					</div>
        				</div>

        			</li>

        		</ul>
          </nav>

      </div>

    </header>

    <div class="container">
      <?php
        if($_SESSION['tipo'] == "conductor"){
          echo "<button class=\"btn btn-1 btn-1a\" id=\"btnPublicarViaje\"> Publicar viaje </button>";
        }
        echo "<button class=\"btn btn-1 btn-1a\" id=\"btnBuscarViaje\"> Buscar viaje </button>";
      ?>
    </div>

    <div class="container">

        <!-- MOSTRAR TRAYECTOS  DEL CONDUCTOR  -->
        <?php
        if (isset($_GET['v']) & $_SESSION['tipo'] == "conductor"){
          $trip = new Trayecto();
          $viajes = $trip->cargarTrayectos($_SESSION['id']);
          foreach($viajes as $viaje){
          echo "<div id=\"$viaje[id]\" class=\"Page\">";
                if ($viaje['cancelado']) {
                  echo "<div class=\"Trip-containerC\">";
                }else{
                  echo "<div class=\"Trip-container\">";
                }
            echo  "<div class=\"Trip\">".
                    "<span class=\"Trip-avatar\">".
                      "<img src=\"data:image;base64,$_SESSION[imagen]\" alt=\"\" />".
                    "</span>".
                    "<div class=\"Trip-body\">".
                      "<h1>$_SESSION[nombre]</h1>".
                      "<span class=\"Trip-time\">$viaje[horasalida] &rarr; $viaje[horallegada]</span>".
                      "<span class=\"Trip-location\">".
                        "<span>$viaje[origen]</span> &rarr; <span>$viaje[destino]</span>".
                      "</span>".
                      "<span class=\"Trip-cost\">$viaje[precio] € por plaza</span>".
                      "<span class=\"Trip-seats\">$viaje[plazas] plazas</span>".
                      "<span class=\"Trip-seats\">$viaje[numeroPasajeros] pasajeros apuntados</span>";
                      if ($viaje['cancelado']) {
                        echo "<span class=\"Trip-cancelled\">CANCELADO</span>";
                      }
              echo  "</div>".
                  "</div>".
                "</div>".
                "<div class=\"middle\">";
                if($viaje['numeroPasajeros'] == 0){
                  if(!$viaje['cancelado']){
                    echo "<button class=\"btn btn-1 btn-1a c\" id=\"myBtn\">Editar</button>";
                  }
                  echo "<button class=\"btn btn-1 btn-1a c\">Borrar</button>";
                }
                if(!$viaje['cancelado']) {
                  echo "<button class=\"btn btn-1 btn-1a c\">Cancelar</button>";
                }

                echo "<button class=\"btn btn-1 btn-1a c\" id=\"myBtn\">Ver pasajeros</button>";
            echo  "</div>".
              "</div>";
          }
      }
      ?>
      </div>
    </div>  <!-- FINAL DIV TRAYECTOS CONDUCTOR -->

    <div class="container">
      <!-- MOSTRAR TRAYECTOS  DEL PASAJERO  -->

      <?php
      if (isset($_GET['v']) & $_SESSION['tipo'] == "pasajero"){
        $trip = new Trayecto();
        $viajes = $trip->cargarTrayectosPasajero($_SESSION['id']);
        foreach($viajes as $viaje){
        echo "<div id=\"$viaje[id]\" class=\"Page\">";
              if ($viaje['cancelado']) {
                echo "<div class=\"Trip-containerC\">";
              }else{
                echo "<div class=\"Trip-container\">";
              }
          echo  "<div class=\"Trip\">".
                  "<span class=\"Trip-avatar\">".
                    "<img src=\"data:image;base64,$viaje[imagen_conductor]\" alt=\"\" />".
                  "</span>".
                  "<div class=\"Trip-body\">".
                    "<h1>$viaje[nombre_conductor]</h1>".
                    "<span class=\"Trip-time\">$viaje[horasalida] &rarr; $viaje[horallegada]</span>".
                    "<span class=\"Trip-location\">".
                      "<span>$viaje[origen]</span> &rarr; <span>$viaje[destino]</span>".
                    "</span>".
                    "<span class=\"Trip-cost\">$viaje[precio] € por plaza</span>".
                    "<span class=\"Trip-seats\">$viaje[plazas] plazas</span>".
                    "<span class=\"Trip-seats\">$viaje[numeroPasajeros] pasajeros apuntados</span>".
                    "<span class=\"Trip-seats\">Valoración: $viaje[valoracion_conductor] / 5</span>";
                    if ($viaje['cancelado']) {
                      echo "<span class=\"Trip-cancelled\">CANCELADO</span>";
                    }
            echo  "</div>".
                "</div>".
              "</div>".
              "<div class=\"middle\">";
              date_default_timezone_set("Europe/Madrid");
              $t1 = StrToTime( $viaje['horasalida'] );
              $date = StrToTime(date('Y-m-d H:i:s'));
              $diff = $t1 - $date;
              $hours = $diff / ( 60 * 60 );
              if($hours > 6.0){
                echo "<button class=\"btn btn-1 btn-1a c\" value=\"$_SESSION[id]\">Anular</button>";
              }
              echo "<button class=\"btn btn-1 btn-1a c\" value=\"$viaje[conductor]\">Ver conductor</button>";
              echo "<button class=\"btn btn-1 btn-1a c\" id=\"myBtn\">Ver pasajeros</button>";
          echo  "</div>".
            "</div>";
        }
      }
      ?>
    </div>

    <div class="container">

      <?php
      if (isset($_GET['u'])){
        $usuarios = $user->obtenerUsuarios();
        foreach($usuarios as $usuario){
        echo "<div id=\"$usuario[id]\" class=\"Page\">".
              "<div class=\"Trip-container\">".
                "<div class=\"Trip\">".
                  "<span class=\"Trip-avatar\">".
                    "<img src=\"data:image;base64,$usuario[image]\" alt=\"\" />".
                  "</span>".
                  "<div class=\"Trip-body\">".
                    "<h1>$usuario[nombre]</h1>".
                    "<span class=\"Trip-time\">DNI: $usuario[dni]</span>".
                    "<span class=\"Trip-time\">".
                      "<span>Email: $usuario[email]</span>".
                    "</span>".
                    "<span class=\"Trip-time\">Teléfono: $usuario[telefono]</span>".
                    "<span class=\"Trip-seats\">$usuario[tipo]</span>".
                  "</div>".
                "</div>".
              "</div>".
              "<div class=\"middle\">".
              "<button class=\"btn btn-1 btn-1a u\">Borrar</button>".
              "</div>".
            "</div>";
        }
      }
      ?>
    </div>

    <div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2>Editar trayecto</h2>
        </div>
        <div class="modal-body">
          <form id="editarTrayecto" action="gestionarTrayecto.php" method="post">
              <label>
                <span class="espacio">Salida</span>
                <span>Destino</span>
              </label>

              <input type="text" id="salida" value="" required="">
              <input type="text" id="destino" value="" required="">

              <label>
                <span>Fecha de salida</span>
              </label>

              <input type="date" id="diaSalida" value="" required="">
              <input type="time" id="horaSalida" value="" required="">

              <label>
                <span>Fecha de llegada</span>
              </label>

              <input type="date" id="diaLlegada" value="" required="">
              <input type="time" id="horaLlegada" value="" required="">

              <label>
                <span class="espacio2">Precio del viaje</span>
                <span>Plazas disponibles</span>
              </label>

              <input type="text" id="precio" value="" required="">
              <input type="text" id="plazas" value="" required="">
              <button type="button" class="btn btn-1 btn-1a" id="publicar">Editar</button>
            </form>
        </div>
      </div>
    </div>

    <div id="myModal2" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span id="close2" class="close">&times;</span>
          <h2>Pasajeros</h2>
        </div>
        <div id=modalPasajeros class="modal-body">

        </div>
      </div>
    </div>

    <div id="myModal3" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span id="close3" class="close">&times;</span>
          <h2>Conductor</h2>
        </div>
        <div id=modalConductor class="modal-body">

        </div>
      </div>
    </div>
  </body>
</html>
