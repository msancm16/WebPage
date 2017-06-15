<?php
  include_once 'modelos/Usuario.php';
  $user = new Usuario();

  session_start();
  if($user->getSession()){
    header("Location: home.php");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto|Montserrat" rel="stylesheet">
    <script src="js/registro.js" type="text/javascript">

    </script>
    <title>Práctica de Viajes</title>
  </head>
  <body>

    <header class="barraColor">

      <div class="container">

          <h1>Logo</h1>

          <nav class="barraNavegacion">

            <ul>
              <li><a href="registro.php">Registrarse</a></li>
              <li><a href="login.php">Iniciar sesión</a></li>
            </ul>

          </nav>

      </div>

    </header>

    <section class="busqueda">

      <div class="container">

        <h2>¿Vas a viajar con tu coche?</h2>
        <p>Encuentra usuarios que van al mismo destino.</p>
        <p>Comparte tu viaje y reducirás tus gastos.</p>

        <div class="selectDate">

          <div class="origen">
            <label>Origen</label>
            <select id="origen" class="origen" name="origen">
              <option value=""> ... </option>
            </select>
          </div>

          <div class="destino">
            <label>Destino</label>
            <select id="destino" class="destino" name="destino">
              <option value=""> ... </option>
            </select>
          </div>

          <div class="fecha">
            <label>Fecha</label>
            <input type="date" id="fecha" name="fecha" min="2007-05-27" value="">
          </div>

          <button type="button" id="buscar" name="buscar"> Buscar </button>

          <div class="advert">
            <p> Debes rellenar los datos para realizar la búsqueda. </p>
          </div>

          <div class="advert2">
            <p> Búsqueda sin resultados. </p>
          </div>

          <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
              <div class="modal-header">
                <!-- <button type="button" id="close"> &times; </button> -->
                <span class="close"> &times; </span>
                <h2>Resultados</h2>
              </div>
              <div class="modal-body">
                <table id="tabla">

                </table>
              </div>
              <div class="modal-footer">
                <h3></h3>
              </div>
            </div>
          </div>

        </div>
      </div>

    </section>

  </body>
</html>
