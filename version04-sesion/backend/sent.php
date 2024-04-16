<?php
   require_once(__DIR__.'/secret/config.php');
   
   date_default_timezone_set('America/Mexico_City');
   session_start( );
   
   // if(count($_SESSION) == 0) -> Puede dar fallas si es que otro archivo PHP
   // previamente había creado una sesión, como por ejemplo:
   // /_1_prueba_sesion/sesion.php
   if (isset($_SESSION['rastrea-mensaje']) == false) {       // es la primera vez que llega este usuario
      $_SESSION['rastrea-mensaje'] = time();
   } else if(time() - $_SESSION['rastrea-mensaje'] < 10) { 
      echo "demasiados-mensajes";
      // print_r ($_SESSION);
      exit;
   } else {
      $_SESSION['rastrea-mensaje'] = time();
   }
   
   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

   if(isset($_POST['autor'], $_POST['cuerpo'])){
      if($_POST['autor'] == "" && $_POST['cuerpo'] == ""){
         echo "vacio-usuario-mensaje";
      } else if($_POST['autor'] == ""){
         echo "vacio-usuario";
      } else if($_POST['cuerpo'] == ""){
         echo "vacio-mensaje";
      } else{
         $fecha = date('Y-m-d H:i:s');
         $autor = $conexion->escape_string($_POST['autor']);
         $cuerpo = $conexion->escape_string($_POST['cuerpo']);
         $conexion->query("INSERT INTO mensaje (autor, cuerpo, fecha) VALUES ('$autor', '$cuerpo', '$fecha')");
         
         echo $fecha;
      }
   }
?>