<?php
   $conexion = new mysqli('127.0.0.1:3307', 'root', 'root', 'test');

   // $nombre = "wendy's";
   $nombre = $conexion->escape_string("Wendy's");
   $conexion->query("INSERT INTO persona (nombre) VALUES ('$nombre')");
?>