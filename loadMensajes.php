<?php
  require_once 'modelos/Select.php';
  $consulta = new Select();

  $p1 = $_POST['persona1'];
  $p2 = $_POST['persona2'];

  $text = $consulta->getMensajes($p1,$p2);
  echo $text;
?>
