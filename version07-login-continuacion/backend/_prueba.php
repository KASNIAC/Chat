<?php
   require_once('./secret/config.php');

   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

   $r1 = $conexion->query("SELECT Mensaje.fecha FROM Mensaje
      INNER JOIN Usuario ON usuario.id_usuario = mensaje.id_usuario
      WHERE email = 'alexis@kasniac.com'
      ORDER BY mensaje.id_mensaje DESC LIMIT 1;");
   $fecha_ultimo_msj = $r1->fetch_assoc(); // assoc porque solo tengo una fila

   var_dump($fecha_ultimo_msj);
   // echo($fecha_ultimo_msj["fecha"]);
?>