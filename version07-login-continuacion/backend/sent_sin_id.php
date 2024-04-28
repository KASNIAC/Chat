<?php
   require_once('./secret/config.php');
   
   date_default_timezone_set('America/Mexico_City');
   session_name(APP_NAME); // La misma sesion que login.php. Ya tengo los datos del usuario
   session_start( );

   $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
   if(!empty($_POST['cuerpo'])){
      $cuerpo = $conexion->escape_string($_POST['cuerpo']);
      $email = $conexion->escape_string($_SESSION['email']);
      $retardo = 10;

      $conexion->query("INSERT INTO mensaje 
         (id_usuario, cuerpo, fecha) 
      SELECT
         id_usuario, '$cuerpo', NOW( )
      FROM
         Usuario
      WHERE
         email = '$email' AND
         NOT EXISTS (
            SELECT * FROM Mensaje WHERE 
               Mensaje.id_usuario = Usuario.id_usuario AND
               TIMESTAMPDIFF(SECOND, Mensaje.fecha, NOW( )) < $retardo
         )
      ");
      
      if ($conexion->affected_rows == 1) {
         $id_mensaje = $conexion->insert_id;    // el id de la última fila que nosotros insertamos
         $fecha = $conexion->query("SELECT fecha FROM Mensaje WHERE id_mensaje = $id_mensaje")->fetch_assoc( )['fecha'];
         die(json_encode($fecha));
      } else {
         $espera = $conexion->query("SELECT 
            TIMESTAMPDIFF(SECOND, NOW( ), ADDTIME(Mensaje.fecha, SEC_TO_TIME($retardo))) AS espera
         FROM 
            Mensaje JOIN Usuario USING (id_usuario) 
         WHERE 
            email = '$email' 
         ORDER BY 
            fecha DESC LIMIT 1
         ")->fetch_assoc( )['espera'];
         die(json_encode((int)$espera));
      }
   } else {
      die(json_encode("mensaje-vacio"));
   }
?>