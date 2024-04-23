<?php
   require_once('./secret/config.php');

   session_name(APP_NAME); // La misma sesion que login.php. Ya tengo los datos del usuario
   session_start( );

   session_unset(); // identico a $_SESSION = []
   session_destroy(); // la cookie no se elimina, pero se vuelve inutilizable

   die("OK");
?>