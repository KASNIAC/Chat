<?php
   // $_SESSION es un arreglo que, si se está ejecutando PHP en el servidor
   // web, recuerda el contenido previo del arreglo para el mismo usuario
   // es como si fuera una variable estática de C/C++ pero por usuario
   // Esto sólo funciona se ejecuta el PHP desde el sevidor web

   session_start( );    // $_SESSION no existe hasta haber llamado a session_start( )
   if (!isset($_SESSION['numero'])) {
      $_SESSION['numero'] = 0;
   }
   
   echo $_SESSION['numero'], "\n";
   $_SESSION['numero'] += 1;
?>