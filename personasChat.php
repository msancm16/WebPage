<?php
  require_once 'modelos/Select.php';
  $consulta = new Select();

  $id = $_POST['viajeId'];
  $option = $consulta->getPeople($id);
  echo $option;
?>
