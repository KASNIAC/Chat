<?php
   require_once(__DIR__.'/../secret/config.php');
   
   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
   $tablas = array_column($conexion->query('SHOW TABLES')->fetch_all( ), 0);
   $conexion->query('SET FOREIGN_KEY_CHECKS = 0');
   foreach ($tablas as $tabla) {
      $conexion->query("DROP TABLE $tabla");
   }
   $conexion->query('SET FOREIGN_KEY_CHECKS = 1');
   
   foreach (glob('*.sql') as $archivo) {
      $conexion->multi_query(file_get_contents($archivo));
   }
?>