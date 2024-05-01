<?php
   require_once('./libraries/db_access.php');
   require_once('./libraries/vendor/autoload.php');
   require_once('./secret/config.php');
   
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
         $conexion = new db_access(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
         $conexion->query("INSERT INTO Usuario (nombre, email) 
            VALUES 
               (?, ?)
            ON DUPLICATE KEY UPDATE
               nombre = ?
         ", $resultado['name'], $resultado['email'], $resultado['name']);

         // Recuperamos el id del usuario:
         $id_usuario = $conexion->query("SELECT id_usuario FROM Usuario where email = ?", $resultado['email'])[0]["id_usuario"];
         
         $_SESSION['logeado'] = true;
         $_SESSION['name'] = $resultado['name'];
         $_SESSION['email'] = $resultado['email']; // el email REAL (si se usa para otra query, hacer otro escape)
         $_SESSION['id_usuario'] = $id_usuario;
      }
   }
   
   if (empty($_SESSION['logeado'])) { // NO estoy logeado
      die(json_encode('no-autenticado'));
   } else { // YA estoy logueado (ya sea porque ya lo estaba o porque me acabo de loguear)
      die(json_encode([ 'email' => $_SESSION['email'], 'name' => $_SESSION['name']])); 
   }
?>