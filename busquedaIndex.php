<?php
  require_once 'modelos/Consulta.php';
  $consulta = new Consulta();

  $which = $_POST['element'];

  if($which == "2"){
    $register = $consulta->busquedaDestino($_POST['origen']);
    echo $register;
  }else if($which == "1"){
    $register = $consulta->busquedaOrigen();
    echo $register;
  }else{
    $register = $consulta->busquedaIndex($_POST['origen'],$_POST['destino'],$_POST['fecha']);
    echo $register;
  }
?>
