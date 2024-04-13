<?php
   require_once(__DIR__.'/secret/config.php');
   
   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
   if(isset($_POST['username'], $_POST['message-body'])){
      if($_POST['username'] == "" && $_POST['message-body'] == ""){
         echo "<script> alert('Usuario y mensaje vacio') </script>";
      } else if($_POST['username'] == ""){
         echo "<script> alert('Usuario vacio') </script>";
      } else if($_POST['message-body'] == ""){
         echo "<script> alert('Mensaje vacio') </script>";
      } else{
         $autor = $conexion->escape_string($_POST['username']);
         $cuerpo = $conexion->escape_string($_POST['message-body']);
         $conexion->query("INSERT INTO mensaje (autor, cuerpo) VALUES ('$autor', '$cuerpo')");
      }
   }
?>