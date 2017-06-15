<?php
  require_once 'dbconfig.php';

  class Usuario{

    public $db;

    public function __construct(){
      $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
      $this->db->set_charset("utf8");
      if(mysqli_connect_errno()) {
      echo "Error: No se pudo conectar a la base de datos.";
      exit;
      }
    }

    public function registrarUsuario($tipoUsuario, $nombre, $email, $telefono, $password, $dni, $image){
      $sql="SELECT * FROM usuario WHERE email='$email'";
      //Comprueba si el email está disponible en la base de datos
      $check = $this->db->query($sql);
      $count_row = $check->num_rows;
      //Si el email no está en la base de datos lo inserta en la tabla
      if ($count_row == 0){
        $sql1="INSERT INTO `usuario` (`tipo`, `nombre`, `email`, `telefono`,`pass`,`dni`,`image`) VALUES ('$tipoUsuario', '$nombre', '$email', '$telefono', '$password', '$dni', '$image')";
        $result = mysqli_query($this->db,$sql1) or die(mysqli_connect_errno()."No se pudo insertar los datos");
        return $result;
      }else {
        return false;
      }
    }

    public function borrarUsuario($id){
      $sql="DELETE FROM `usuario` WHERE `usuario`.`id` = $id";
      $this->db->query($sql);
    }

    public function obtenerUsuarios(){
      $sql="SELECT * FROM usuario WHERE tipo != \"admin\"";
      $result = $this->db->query($sql);
      return $result;
    }

    public function cargarConductor($id){
      $sql = "SELECT * FROM usuario WHERE usuario.id = $id";
      $result = $this->db->query($sql);

      $datos = $result->fetch_assoc();
      echo json_encode($datos);
    }

    public function check_login($email, $password){
      $sql2="SELECT * from usuario WHERE email='$email' and pass='$password'";
      //comprobar si el email está registrado
      $result = mysqli_query($this->db,$sql2);
      $datosUsuario = mysqli_fetch_array($result);
      $count_row = $result->num_rows;

      if ($count_row == 1) {

        $_SESSION['login'] = true;
        $_SESSION['id'] = $datosUsuario['id'];
        $_SESSION['nombre'] = $datosUsuario['nombre'];
        $_SESSION['tipo'] = $datosUsuario['tipo'];
        $_SESSION['imagen'] = $datosUsuario['image'];

        return true;
      }else{
        return false;
      }
    }

    public function getSession(){
      if(isset($_SESSION['login']))
        return $_SESSION['login'];
    }

    public function userLogout() {
      $_SESSION['login'] = FALSE;
      session_destroy();
    }

  }

?>
