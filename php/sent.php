<?php
   $conexion = new mysqli('127.0.0.1:3307', 'root', 'root', 'mensajes_kasniac');

   $autor = $conexion->escape_string($_POST['username']);
   $cuerpo = $conexion->escape_string($_POST['message-body']);

   $conexion->query("INSERT INTO mensaje (autor, cuerpo) VALUES ('$autor', '$cuerpo')");
?>