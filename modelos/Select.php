<?php
  require_once 'dbconfig.php';
  class Select{
    public $db;

    public function __construct(){
      $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
      $this->db->set_charset("utf8");
      if(mysqli_connect_errno()) {
        echo "Error: No se pudo conectar a la base de datos.";
        exit;
      }
    }

    function getSelect($id){
      $sql = "SELECT idTrayecto FROM trayectopasajeros WHERE idPasajero LIKE $id";
      $result = $this->db->query($sql);
      $idViaje;

      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $idViaje = $row['idTrayecto'];

          $sql2 = "SELECT id,origen,destino FROM trayecto WHERE id = $idViaje";
          $result2 = $this->db->query($sql2);
          $combobox = "";

          if($result2->num_rows > 0){
        		while($row = $result2->fetch_assoc()){
        			$combobox .= "<option value='$row[id]'>".$row['origen']." - ".$row[destino]."</option>";
        		}
        	}
          echo $combobox;
        }
      }
    }

    function getPeople($id){
      $sql = "SELECT idPasajero FROM trayectopasajeros WHERE idTrayecto LIKE $id"; //Obtenemos todos los apuntados al viaje
      $result = $this->db->query($sql);

      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $idPasajero = $row['idPasajero'];

          $sql2 = "SELECT nombre FROM usuario WHERE id = $idPasajero";
          $result2 = $this->db->query($sql2);

          if($result2->num_rows > 0){
            while($row = $result2->fetch_assoc()){
              $list[] = $row;
            }
          }
        }
        return json_encode($list);
      }
      else{
        return "0 results";
      }
    }

    function getMensajes($p1, $p2){
      // $sql = "SELECT texto,persona1 FROM mensaje WHERE persona1 LIKE '$p1' OR persona1 LIKE '$p2' AND persona2 LIKE '$p1' OR persona2 LIKE '$p2'";
      $sql = "SELECT texto,persona1 FROM mensaje WHERE persona1 LIKE '$p1' AND persona2 LIKE '$p2' OR persona2 LIKE '$p1' AND persona1 LIKE '$p2'";
      $result = $this->db->query($sql);

      if($result){
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $list[] = $row;
          }
          return json_encode($list);
        }
      }else
      {
        return "0 results";
      }
    }

    function setMensaje($p1, $p2, $msj){
      $sql = "INSERT INTO mensaje (texto, persona1, persona2) VALUES ('$msj', '$p1', '$p2')";
      $result = $this->db->query($sql);

      if($result){
        return "new entry inserted";
      } else {
        return "error inserting";
      }
    }

}
?>
