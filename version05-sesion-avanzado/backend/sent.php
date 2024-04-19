<?php
   require_once(__DIR__.'/secret/config.php');
   
   date_default_timezone_set('America/Mexico_City');
   session_name(APP_NAME);
   // session_id(str_replace($_SERVER['REMOTE_ADDR'], '.', '-')); // sesion_id(); establece el id para que no sea generado por defecto, puedo usar la IP como identificador. 
         // La sesion ya no se vincula con la cookie, sino con la IP.
         // Desafortunadamente NO ES una solución general, ya que dos individuos distintos pueden compartir la misma IP.
   session_start( );
   
   if(empty($_SESSION)) {
      $_SESSION['rastrea-mensaje'] = time();
   } else if(time() - $_SESSION['rastrea-mensaje'] < 10) { 
      die("demasiados-mensajes"); // die() == echo + exit
   } else {
      $_SESSION['rastrea-mensaje'] = time();
   }

   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

   if(isset($_POST['autor'], $_POST['cuerpo'])){
      if($_POST['autor'] == "" && $_POST['cuerpo'] == ""){
         die("vacio-usuario-mensaje");
      } else if($_POST['autor'] == ""){
         die("vacio-usuario");
      } else if($_POST['cuerpo'] == ""){
         die("vacio-mensaje");
      } else{
         $fecha = date('Y-m-d H:i:s');
         $autor = $conexion->escape_string($_POST['autor']);
         $cuerpo = $conexion->escape_string($_POST['cuerpo']);
         $conexion->query("INSERT INTO mensaje (autor, cuerpo, fecha) VALUES ('$autor', '$cuerpo', '$fecha')");
         die($fecha);
      }
   } else {
      die("sin-datos");
   }
?>