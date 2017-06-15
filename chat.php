<?php
  session_start();
  include 'modelos/Select.php';
  require_once 'modelos/Trayecto.php';
  require_once 'modelos/Usuario.php';
  $combobox = new Select();
  $user = new Usuario();
  $viaje = new Trayecto();

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
    <link rel="stylesheet" href="./styles/chat.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto|Montserrat" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/chat.js" type="text/javascript"></script>
    <title>Chats</title>
  </head>
  <body>

    <header>

      <div class="container">

          <h1>Logo</h1>

          <nav>
        		<ul>

        			<li class="drop">
        				<a href="#" class="userName" id="userName"><?php echo $_SESSION['nombre']; ?></a>

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
    <div class="wrap">
        <div class="combobox">
          <p class="selecciones">Selecciona tu viaje:</p>
          <select id="viaje" class="viaje" name="viaje">
              <option value=""> ... </option>
              <<?php $combobox->getSelect($_SESSION['id']); ?>
          </select>
          <p class="selecciones">Personas:</p>

          <select id="persona" class="persona" name="persona">
              <option value=""> ... </option>
          </select>
        </div>
        <div class="chat">
          <div class="mensajes" id="mensajes">

          </div>
          <div class="lowchat">
            <input class="texto" type="text" id="textField" name="" placeholder="Escribe tu mensaje ..."/>
            <button class="" id="sendButton"> Enviar </button>
          </div>
        </div>
    </div>

  </body>
</html>
