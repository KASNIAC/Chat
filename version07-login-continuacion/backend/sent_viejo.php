<?php
   require_once('./secret/config.php');
   
   date_default_timezone_set('America/Mexico_City');
   session_name(APP_NAME); // La misma sesion que login.php. Ya tengo los datos del usuario
   session_start( );

   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

   function recupera_id(){
      global $conexion;

      $email = $conexion->escape_string($_SESSION['email']);
      $peticion = $conexion->query("SELECT id_usuario FROM usuario WHERE email = '$email';");

      return $peticion->fetch_assoc()["id_usuario"]; // assoc porque solo tengo una fila
   }

   function agrega_mensaje(){
      global $conexion;

      $id_usuario = recupera_id();
      $fecha = date('Y-m-d H:i:s');
      $cuerpo = $conexion->escape_string($_POST['cuerpo']);

      $test = $conexion->query("INSERT INTO mensaje (id_usuario, cuerpo, fecha) VALUES ('$id_usuario', '$cuerpo', '$fecha')");
      return $fecha;
   }

   if(!empty($_POST['cuerpo'])){
      $email = $conexion->escape_string($_SESSION['email']);

      // Pueden ocurrir condiciones de carrera por dos sesiones abiertas en la misma cuenta, pero en dispositivos diferentes?
      $r1 = $conexion->query("SELECT Mensaje.fecha FROM Mensaje
         INNER JOIN Usuario ON usuario.id_usuario = mensaje.id_usuario
         WHERE email = '$email'
         ORDER BY mensaje.id_mensaje DESC LIMIT 1;");
      $fecha_ultimo_msj = $r1->fetch_assoc(); // assoc porque solo tengo una fila

      if(isset($fecha_ultimo_msj)){
         $timestamp = strtotime($fecha_ultimo_msj["fecha"]);
         $ahora = time(); $espera = 10;
         if($ahora - $timestamp < $espera){
            die(json_encode($timestamp + $espera - $ahora)); // die(json_encode("demasiados-mensajes"));
         }
      }
      
      die(json_encode(agrega_mensaje()));
   } else {
      die(json_encode("mensaje-vacio"));
   }
?>