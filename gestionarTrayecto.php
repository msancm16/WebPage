<?php
  require_once 'modelos/Trayecto.php';

  $trayecto = new Trayecto();

  if(isset($_POST['origen'])){
    if($_POST['origen'] == "anular"){
      $trayecto->anularTrayectoPasajero($_POST['iD'],$_POST['idPasajero']);
    }elseif($_POST['origen'] == "borrar"){
      $trayecto->eliminarTrayecto($_POST['iD']);
    }elseif ($_POST['origen'] == "cancelar") {
      $trayecto->cancelarTrayecto($_POST['iD']);
    }elseif($_POST['origen'] == "editar"){
      $id = $_POST['iD'];
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

      $trayecto->editarTrayecto($salida,$destino,$fechaSalida,$fechaLlegada,$id,$precio,$plazas);
    }else{
      $trayecto->obtenerPasajeros($_POST['iD']);
    }
  }


?>
