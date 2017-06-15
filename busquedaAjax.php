<?php
  require_once 'modelos/Consulta.php';

  $consulta = new Consulta();

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

  $register = $consulta->buscarTrayecto($salida,$destino,$fechaSalida,$fechaLlegada,$precio,$plazas);
  echo $register;
?>
