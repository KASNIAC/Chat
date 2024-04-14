<?php
   require_once(__DIR__.'/secret/config.php');
   
   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

   if(isset($_POST['username'], $_POST['message-body'])){
      if($_POST['username'] == "" && $_POST['message-body'] == ""){
         echo "vacio-usuario-mensaje";
      } else if($_POST['username'] == ""){
         echo "vacio-usuario";
      } else if($_POST['message-body'] == ""){
         echo "vacio-mensaje";
      } else{
         date_default_timezone_set('America/Mexico_City');
         $fecha = date('Y-m-d H:i:s');

         $autor = $conexion->escape_string($_POST['username']);
         $cuerpo = $conexion->escape_string($_POST['message-body']);
         $conexion->query("INSERT INTO mensaje (autor, cuerpo, fecha) VALUES ('$autor', '$cuerpo', '$fecha')");
         
         echo $fecha;
      }
   }
?>