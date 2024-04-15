<?php
   require_once(__DIR__.'/secret/config.php');
   
   session_start( );
   if (count($_SESSION) == 0) {
      // es la primera vez que llega este usuario
   } else {
      /*
      if (ya mandó muchos mensajes) {
         echo 'demasiados-mensajes';
         exit;
      }
      */
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
         date_default_timezone_set('America/Mexico_City');
         $fecha = date('Y-m-d H:i:s');

         $autor = $conexion->escape_string($_POST['autor']);
         $cuerpo = $conexion->escape_string($_POST['cuerpo']);
         $conexion->query("INSERT INTO mensaje (autor, cuerpo, fecha) VALUES ('$autor', '$cuerpo', '$fecha')");
         
         echo $fecha;
      }
   }
?>