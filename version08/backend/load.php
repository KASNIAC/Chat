<?php
   require_once('./libraries/db_access.php');
   require_once('./secret/config.php');
   
   $conexion = new db_access(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
   $arr = $conexion->query("SELECT Usuario.nombre AS autor, Mensaje.cuerpo, Mensaje.fecha FROM 
                           Usuario JOIN mensaje USING (id_usuario)
                           ORDER BY fecha");

   echo json_encode($arr);
?>