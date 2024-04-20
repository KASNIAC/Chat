<?php
   require_once('libraries/vendor/autoload.php');
   require_once('secret/config.php');
   
   session_name(APP_NAME);
   session_start();
   
   if (isset($_POST['comprobante'])) {
      $cliente = new Google_Client([ 'client_id' => '330917364178-utl74obou3uhk4ttk86tu0jlbnod1dev.apps.googleusercontent.com' ]);
      $cliente->setHttpClient(new \GuzzleHttp\Client([ 'curl' => [ CURLOPT_SSL_VERIFYPEER => false ] ])); // CURLOPT_SSL_VERIFYPEER => false : potencialmente es una mala practica; en caso de hackeo de red o de que hackeen a google habría problemas.
      $resultado = $cliente->verifyIdToken($_POST['comprobante']);
      
      if ($resultado == false) {
         die(json_encode('error-comprobante'));
      } else {
         $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
         $nombre = $conexion->escape_string($resultado['name']);
         $email = $conexion->escape_string($resultado['email']);
         $conexion->query("
            INSERT INTO 
               Usuario (nombre, email) 
            VALUES 
               ('$nombre', '$email')
            ON DUPLICATE KEY UPDATE
               nombre = '$nombre'
         ");
         
         $_SESSION['logeado'] = true;
         $_SESSION['nombre'] = $resultado['name'];
         $_SESSION['email'] = $resultado['email'];
         
         die(json_encode([ 'email' => $_SESSION['email'], 'nombre' => $_SESSION['nombre'] ]));
      }
   } else {
      if (empty($_SESSION['logeado'])) {
         die(json_encode('no-autenticado'));
      } else {
         die(json_encode([ 'email' => $_SESSION['email'], 'nombre' => $_SESSION['nombre'] ]));
      }
   }
?>