<?php
   require_once('libraries/vendor/autoload.php');
   require_once('secret/config.php');
   
   session_name(APP_NAME);
   if (isset($_POST['comprobante'])) {
      $cliente = new Google_Client([ 'client_id' => '330917364178-utl74obou3uhk4ttk86tu0jlbnod1dev.apps.googleusercontent.com' ]);
      $cliente->setHttpClient(new \GuzzleHttp\Client([ 'curl' => [ CURLOPT_SSL_VERIFYPEER => false ] ])); // CURLOPT_SSL_VERIFYPEER => false : potencialmente es una mala practica; en caso de hackeo de red o de que hackeen a google habría problemas.
      $resultado = $cliente->verifyIdToken($_POST['comprobante']);
      if ($resultado == false) {
         die(json_encode('error-comprobante'));
      } else {
         session_start();
         $_SESSION['logeado'] = true;

         $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
         $nombre = $conexion->escape_string($resultado['name']);
         $email = $conexion->escape_string($resultado['email']);
   
         /*
         // Solo lo agrego si no existe
         $existe = $conexion->query("SELECT email FROM Usuario WHERE email = '$email'")->fetch_all(MYSQLI_ASSOC);
         if(count($existe) == 0){
            $conexion->query("INSERT INTO Usuario (nombre, email) VALUES ('$nombre', '$email')");
         }
         */
         
         /* No regañar si ya hay email duplicado
         $conexion->query("
            INSERT IGNORE INTO 
               Usuario (nombre, email) 
            VALUES 
               ('$nombre', '$email')
         ");
         */
         
         $conexion->query("
            INSERT INTO 
               Usuario (nombre, email) 
            VALUES 
               ('$nombre', '$email')
            ON DUPLICATE KEY UPDATE
               nombre = '$nombre'
         ");
         die(json_encode([ 'email' => $resultado['email'], 'nombre' => $resultado['name']]));
         //die("{$resultado['sub']} {$resultado['email']} {$resultado['name']}"); // Puedo mandar a veces JSON y a veces cadenas?
      }
   } else {
      die(json_encode('sin-comprobante'));
   }
?>