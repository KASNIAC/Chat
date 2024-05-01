<?php
   require_once(__DIR__.'/../secret/config.php');
   
   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

   // fetch_all() == fetch_all(MYSQLI_NUM)
   // fetch_all(MYSQLI_ASSOC)

   // $conexion->query('SHOW TABLES')->fetch_all( ) -> devuelve una estructura de matriz
   // array_column -> devuelve en un arreglo lo que estaba en la columna 0 de la matriz
   $tablas = array_column($conexion->query('SHOW TABLES')->fetch_all( ), 0);

   
   // SET FOREIGN_KEY_CHECKS = 0 -> "No haga las verficaciones de llaves foraneas, para poder eliminar las tablas"
   $conexion->query('SET FOREIGN_KEY_CHECKS = 0');
   foreach ($tablas as $tabla) {
      $conexion->query("DROP TABLE $tabla");
   }
   $conexion->query('SET FOREIGN_KEY_CHECKS = 1');

   // glob('*.sql') -> Para cada archivo de la carpeta actual que sea .sql
   foreach (glob('*.sql') as $nombre_archivo) {
      $conexion->multi_query(file_get_contents($nombre_archivo));    // file_get_contents -> Lee el archivo completo y lo devuelve como cadena
      // $conexion->multi_query("comando1; comando2; comando3;") -> Se ejecutan todos los comandos
      // $conexion->query("comando1; comando2; comando3;") -> Solo se ejecuta el primer comando
   }
?>