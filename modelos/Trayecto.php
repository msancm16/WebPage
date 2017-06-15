<?php
  require_once  'dbconfig.php';

  class Trayecto{
    public $db;

    public function __construct(){
      $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
      $this->db->set_charset("utf8");
      if(mysqli_connect_errno()) {
      echo "Error: No se pudo conectar a la base de datos.";
      exit;
      }
    }

    public function registrarTrayecto($salida,$destino,$fechaSalida,$fechaLlegada,$id,$precio,$plazas){
      $sql="INSERT INTO `trayecto` (`origen`, `destino`, `horasalida`,`horallegada`,`conductor`,`precio`,`plazas`) VALUES ('$salida', '$destino', '$fechaSalida','$fechaLlegada','$id','$precio','$plazas')";

      $check = $this->db->query($sql) ;
    }

    //Carga todos los trayectos para un conductor
    public function cargarTrayectos($id){
      $sql = "SELECT * FROM trayecto WHERE conductor='$id'";
      $result = $this->db->query($sql);
      return $result;
    }

    //Carga todos los trayectos para un pasajero
    public function cargarTrayectosPasajero($id){
      $sql = "SELECT `idTrayecto` FROM `trayectopasajeros` WHERE `idPasajero` = $id";
      $check = $this->db->query($sql);

      $list = array();
      if($check){
        if ($check->num_rows > 0) {
          while($row = $check->fetch_assoc()) {
            $list[] = $row['idTrayecto'];
          }
        }
      }

      $viajes = array();
      foreach ($list as $id) {
        $sql2 = "SELECT trayecto.*, p1.nombre nombre_conductor, p2.image imagen_conductor , p3.valoracion valoracion_conductor from trayecto left join usuario p1 on (trayecto.conductor=p1.id) left join usuario p2 on (trayecto.conductor=p2.id) left join usuario p3 on(trayecto.conductor=p3.id)WHERE trayecto.id = $id";
        $result = $this->db->query($sql2);
        $row = $result->fetch_assoc();
        $viajes[] = $row;
      }
      return $viajes;
    }

    public function checkPuntuado($idViaje,$idPasajero){
      $sql = "SELECT `puntuado` FROM `trayectopasajeros` WHERE `idPasajero` = $idPasajero AND `idTrayecto` = $idViaje";
      return  $this->db->query($sql);

    }

    //Elimina un trayecto elegido por el conductor
    public function eliminarTrayecto($id){
      $sql = "DELETE FROM `trayecto` WHERE `trayecto`.`id` = $id";
      $this->db->query($sql);
    }

    //Anular trayecto para un pasajero
    public function anularTrayectoPasajero($idViaje, $idPasajero){
      $sql = "DELETE FROM `trayectopasajeros` WHERE `trayectopasajeros`.`idTrayecto` = $idViaje AND `trayectopasajeros`.`idPasajero` = $idPasajero";
      $this->db->query($sql);

      $sql2 = "UPDATE trayecto SET numeroPasajeros = numeroPasajeros-1 WHERE trayecto.id = $idViaje";
      $this->db->query($sql2);
    }
    //Cancela un trayecto elegido por el conductor
    public function cancelarTrayecto($id){
      $sql = "UPDATE `trayecto` SET `cancelado` = '1' WHERE `trayecto`.`id` = '$id'";
      $this->db->query($sql);
    }

    //Edita un trayecto elegido por el conductor
    public function editarTrayecto($salida,$destino,$fechaSalida,$fechaLlegada,$id,$precio,$plazas){
      $sql = "UPDATE `trayecto` SET `origen` = '$salida',`destino` = '$destino',`horasalida` = '$fechaSalida',`horallegada` = '$fechaLlegada',`precio` = '$precio',`plazas` = '$plazas' WHERE `trayecto`.`id` = '$id'";
      $this->db->query($sql);
    }

    //Obtiene todos los pasajeros apuntados al trayecto especificado como parametro
    public function obtenerPasajeros($id){
      $sql = "SELECT `idPasajero` FROM `trayectopasajeros` WHERE `idTrayecto` = $id";
      $check = $this->db->query($sql);

      $list = array();
      if($check){
        if ($check->num_rows > 0) {
          while($row = $check->fetch_assoc()) {
            $list[] = $row['idPasajero'];
          }
        }
      }
      $users = array();
      foreach ($list as $id) {
        $sql2 = "SELECT * FROM `usuario` WHERE `id` = $id";
        $result = $this->db->query($sql2);
        $row = $result->fetch_assoc();
        $users[] = $row;
      }
      echo json_encode($users);
    }

  }

?>
