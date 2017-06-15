<?php
  require_once 'modelos/Select.php';
  $consulta = new Select();

  $p1 = $_POST['persona1'];
  $p2 = $_POST['persona2'];
  $msj = $_POST['mensaje'];
  //Primero introducimos la nueva entrada en la db, y luego reutilizamos getMensajes Para que apatezca el nuevo msj
  $consulta->setMensaje($p1,$p2,$msj);
  $text = $consulta->getMensajes($p1,$p2);
  echo $text;
?>
