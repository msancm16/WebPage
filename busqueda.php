<?php
  session_start();
  require_once 'modelos/Usuario.php';
  require_once 'modelos/Consulta.php';

  $user = new Usuario();
  $consulta = new Consulta();

  $which = $_POST['element'];

  if($which == "reservar"){
    $result = $consulta->reservar($_POST['idT'], $_POST['idP']);
    echo $result;
  }else if($which == "datos"){
    $array = [
      "tipo" => $_SESSION['tipo'],
      "id" => $_SESSION['id'],
    ];
    echo json_encode($array);
  }else if($which == "busqueda"){
    $register = $consulta->busquedaGrande($_POST['origen'],$_POST['destino'],$_POST['fecha'],$_POST['precio'],$_POST['plazas'],$_POST['valoracion']);
    echo $register;
  }else if($which == "2"){
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
