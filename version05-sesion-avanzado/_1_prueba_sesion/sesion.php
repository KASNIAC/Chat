<?php
   session_name("Nueva-sesion"); // Ya es una nueva sesion, por lo que al actualizar el contador, ya no afecta
   // a la sesion de /version04-sesion/_1_prueba_sesion/sesion.php

   session_start( );    // $_SESSION no existe hasta haber llamado a session_start( )
   if (!isset($_SESSION['numero'])) {
      $_SESSION['numero'] = 0;
   }
   
   echo $_SESSION['numero'], "\n";
   $_SESSION['numero'] += 1;
   var_dump(($_SESSION));
?>