<?php
   $conexion = new mysqli('127.0.0.1:3307', 'root', 'root', 'mensajes_kasniac');

   $r1 = $conexion->query("SELECT autor, cuerpo, fecha FROM mensaje");
   
   $arr = $r1->fetch_all(MYSQLI_ASSOC);

   foreach($arr as $tupla) {
      echo "<div class='message sent'>";

         echo "<div class='metadata'>";
            echo "<div class='autor'>";
               echo "<p>".$tupla["autor"]."</p>";
            echo "</div>";
            echo "<div class='date'>";
               echo "<p>".$tupla["fecha"]."</p>" ;
            echo "</div>";
         echo "</div>";

         echo "<div class='content'>";
            echo $tupla["cuerpo"] ;
         echo "</div>";  
      echo "</div>";
   }
?>
