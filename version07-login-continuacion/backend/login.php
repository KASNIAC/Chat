<?php
   require_once('libraries/vendor/autoload.php');
   require_once('secret/config.php');
   
   session_name(APP_NAME);
   session_start(); // desde el principio para saber si ya se logeo o si no se había logeado
   
   // No me logueo ante google sino que me identifico y google me da mi comprobante.

   if (isset($_POST['comprobante'])) { // ¿Ya me dio google mi comprobante?
      $cliente = new Google_Client([ 'client_id' => '330917364178-utl74obou3uhk4ttk86tu0jlbnod1dev.apps.googleusercontent.com' ]);
      $cliente->setHttpClient(new \GuzzleHttp\Client([ 'curl' => [ CURLOPT_SSL_VERIFYPEER => false ] ]));
      $resultado = $cliente->verifyIdToken($_POST['comprobante']);
      
      if ($resultado == false) {
         die(json_encode('error-comprobante')); // ERROR con el comprobante
      } else { // OK comprobante
         $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
         $nombre = $conexion->escape_string($resultado['name']);
         $email = $conexion->escape_string($resultado['email']);
         $conexion->query("INSERT INTO Usuario (nombre, email) 
            VALUES 
               ('$nombre', '$email')
            ON DUPLICATE KEY UPDATE
               nombre = '$nombre'
         ");

         // Recuperamos el id del usuario:
         $id_usuario = $conexion->query("SELECT id_usuario FROM Usuario where email = '$email'")->fetch_assoc()["id_usuario"];
         
         $_SESSION['logeado'] = true;
         $_SESSION['name'] = $resultado['name'];
         $_SESSION['email'] = $resultado['email']; // No es mejor guardar $email (ya la variable escapada de inyeccion SQL?)
         $_SESSION['id_usuario'] = $id_usuario;
      }
   }
   
   if (empty($_SESSION['logeado'])) { // NO estoy logeado
      die(json_encode('no-autenticado'));
   } else { // YA estoy logueado (ya sea porque ya lo estaba o porque me acabo de loguear)
      die(json_encode([ 'email' => $_SESSION['email'], 'name' => $_SESSION['name']])); 
   }
?>