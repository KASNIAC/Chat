<?php
   // __DIR__ -> indica relativo al directorio actual, no al inicial
   require_once(__DIR__.'/secret/config.php');
   
   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
   $r1 = $conexion->query("SELECT autor, cuerpo, fecha FROM mensaje");
   $arr = $r1->fetch_all(MYSQLI_ASSOC);

   echo json_encode($arr);
?>