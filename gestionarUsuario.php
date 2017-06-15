<?php
  require_once 'modelos/Usuario.php';

  $usuario = new Usuario();

  if(isset($_POST['origen'])){
    if($_POST['origen'] == "borrar"){
      $usuario->borrarUsuario($_POST['iD']);
    }elseif ($_POST['origen'] == "cargar") {
      $usuario->cargarConductor($_POST['iD']);
    }
  }

?>
