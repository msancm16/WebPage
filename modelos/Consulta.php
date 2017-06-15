<?php
  require_once 'dbconfig.php';

  class Consulta{
    public $db;

    public function __construct(){
      $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
      $this->db->set_charset("utf8");
      if(mysqli_connect_errno()) {
        echo "Error: No se pudo conectar a la base de datos.";
        exit;
      }
    }

    public function buscarTrayecto($origen, $destino, $fechaSalida, $fechaLlegada, $precio, $plazas){
      $sql = "SELECT origen FROM trayecto WHERE origen like '%$origen%'"; //, destino like '%$destino%', horasalida like '%$fechaSalida%', horallegada like '%$fechaLlegada%', precio like '%$precio%', plazas like '%$plazas%'";

      $check = $this->db->query($sql);

      if($check){
        if ($check->num_rows > 0) {
          while($row = $check->fetch_assoc()) {
            echo "SALIDA: ". $row;
            $list[] = $row;
          }

          return json_encode($list);
        }
      }else
      {
        return "0 results";
      }
    }

    public function busquedaOrigen(){
      $sql = "SELECT origen FROM trayecto ";

      $check = $this->db->query($sql);

      if($check){
        if ($check->num_rows > 0) {
          while($row = $check->fetch_assoc()) {
            $list[] = $row;
          }

          return json_encode($list);
        }
      }else
      {
        return "0 results";
      }
    }

    public function busquedaDestino($origen){
      $sql = "SELECT destino FROM trayecto WHERE origen = '$origen'";

      $check = $this->db->query($sql);

      if($check){
        if ($check->num_rows > 0) {
          while($row = $check->fetch_assoc()) {
            $list[] = $row;
          }

          return json_encode($list);
        }
      }else
      {
        return "0 results";
      }
    }

    public function busquedaIndex($origen, $destino, $fecha){
      $sql = "SELECT origen, destino, horasalida, horallegada, precio, plazas FROM trayecto WHERE origen = '$origen' AND horasalida > '$fecha' AND destino = '$destino' AND cancelado = 0 AND numeroPasajeros < plazas";

      $check = $this->db->query($sql);

      if($check){
        if ($check->num_rows > 0) {
          while($row = $check->fetch_assoc()) {
            $list[] = $row;
          }

          return json_encode($list);
        }
      }else
      {
        return "0 results";
      }
    }

    public function busquedaGrande($idP, $origen, $destino, $fecha, $precio, $plazas, $valoracion){
      $sql = "select trayecto.*, p1.nombre nombre_conductor, p2.image imagen_conductor, p3.valoracion valoracion_conductor from trayecto left join usuario p1 on (trayecto.conductor=p1.id) left join usuario p2 on (trayecto.conductor=p2.id) left join usuario p3 on (trayecto.conductor=p3.id) where origen like '%$origen%' AND destino like '%$destino%' AND horasalida>='$fecha' AND precio>='$precio' AND plazas>='$plazas' AND numeroPasajeros<plazas AND p3.valoracion >= '$valoracion'";

      $check = $this->db->query($sql);

      $list = null;
      if ($check->num_rows > 0) {
        while($row = $check->fetch_assoc()) {
          $idT = $row['id'];

          $sql2 = "SELECT * FROM trayectopasajeros WHERE IdPasajero = $idP AND IdTrayecto = $idT";

          $check2 = $this->db->query($sql2);

          if(!$check2->num_rows > 0){
            $list[] = $row;
          }

        }

        return json_encode($list);
      }else
      {
        return "0 results";
      }
    }

    public function reservar($idT, $idP){
      $sql = "UPDATE trayecto SET numeroPasajeros = numeroPasajeros+1 WHERE id=$idT";
      $check = $this->db->query($sql);

      $sql = "INSERT INTO `trayectopasajeros` (`IdTrayecto`, `IdPasajero`) VALUES ('$idT','$idP')";
      $check = $this->db->query($sql);

      return $check;
    }

  }

?>
