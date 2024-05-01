<?php
   require_once('./libraries/db_access.php');
   require_once('./secret/config.php');
   
   date_default_timezone_set('America/Mexico_City');
   session_name(APP_NAME); // La misma sesion que login.php. Ya tengo los datos del usuario
   session_start( );

   $conexion = new db_access(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
   if(!empty($_POST['cuerpo'])){
      $retardo = 10;
      $conexion->query("INSERT INTO Mensaje 
         (id_usuario, cuerpo, fecha) 
      SELECT
         ?, ?, NOW( )
      WHERE
         NOT EXISTS (
            SELECT * FROM Mensaje WHERE 
               Mensaje.id_usuario = ? AND 
               TIMESTAMPDIFF(SECOND, Mensaje.fecha, NOW( )) < $retardo
         )
      ", $_SESSION['id_usuario'], $_POST['cuerpo'], $_SESSION['id_usuario']);

      if ($conexion->affected_rows == 1) {
         $id_mensaje = $conexion->insert_id;    // el id de la última fila que nosotros insertamos
         $fecha = $conexion->query("SELECT fecha FROM Mensaje WHERE id_mensaje = ?", $id_mensaje)[0]['fecha'];
         die(json_encode([ 'espera' => $retardo, 'fecha_insercion' => $fecha ]));
      } else {
         $espera = (int)$conexion->query("SELECT 
            TIMESTAMPDIFF(SECOND, NOW( ), ADDTIME(Mensaje.fecha, SEC_TO_TIME($retardo))) AS espera
         FROM 
            Mensaje
         WHERE 
            Mensaje.id_usuario = ?
         ORDER BY 
            fecha DESC LIMIT 1
         ", $id_usuario)[0]['espera'];
         die(json_encode([ 'espera' => $espera ]));
      }
   } else {
      die(json_encode("mensaje-vacio"));
   }
?>