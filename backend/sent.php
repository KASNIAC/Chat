<?php
   require_once(__DIR__.'/secret/config.php');
   
   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
   $autor = $conexion->escape_string($_POST['username']);
   $cuerpo = $conexion->escape_string($_POST['message-body']);
   $conexion->query("INSERT INTO mensaje (autor, cuerpo) VALUES ('$autor', '$cuerpo')");
?>