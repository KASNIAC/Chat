<?php
   $conexion = new mysqli('127.0.0.1:3307', 'root', 'root', 'mensajes_kasniac');
   echo $conexion;

   $r1 = $conexion->query("SELECT autor, cuerpo, fecha FROM mensaje");
   
   $arr = $r1->fetch_all(MYSQLI_ASSOC);

   foreach($arr1 as $tupla) {
      echo "<div class='message sent'>";
      echo $tupla["autor"] + " ";
      echo $tupla["fecha"] + " ";
      echo "<br>";
      echo $tupla["cuerpo"] + " ";
   }
?>
