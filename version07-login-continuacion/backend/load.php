<?php
   require_once('./secret/config.php');
   
   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
   $r1 = $conexion->query("SELECT Usuario.nombre AS autor, Mensaje.cuerpo, Mensaje.fecha FROM Usuario
                           INNER JOIN mensaje
                           ON Usuario.id_usuario = Mensaje.id_usuario
                           ORDER BY fecha;");
   $arr = $r1->fetch_all(MYSQLI_ASSOC);

   echo json_encode($arr);
?>