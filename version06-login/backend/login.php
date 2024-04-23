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

         // TERCA OPCION (solo actualizo el nombre de usuario en caso de que haya cambiado)
         // DUPLICATE KEY habla de todo lo que sea UNIQUE o de la PRIMARY KEY
         $conexion->query("
            INSERT INTO 
               Usuario (nombre, email) 
            VALUES 
               ('$nombre', '$email')
            ON DUPLICATE KEY UPDATE       
               nombre = '$nombre'
         ");

         die(json_encode([ 'email' => $resultado['email'], 'nombre' => $resultado['name']])); // die("{$resultado['sub']} {$resultado['email']} {$resultado['name']}");
      }
   } else {
      die(json_encode('sin-comprobante'));
   }




      // PRIMERA OPCION (error, condicion de carrera puede ocurrir)
      // Un if para detectar si ya esta en la BD puede fallar en este caso, ya que puede existir una condición de carrera.
      // Por ejemplo, si el fetch se hace dos veces en index.html y el primero no tiene await, es probable que cuando lleguen
      // al if, ambos vean que es verdad al estarlo haciendo de forma paralela.
         /*
         $existe = $conexion->query("SELECT email FROM Usuario WHERE email = '$email'")->fetch_all(MYSQLI_ASSOC);
         if(count($existe) == 0){
            $conexion->query("INSERT INTO Usuario (nombre, email) VALUES ('$nombre', '$email')");
         }
         */


      // SEGUNDA OPCION (error, puede cambiar el nombre de usuario y no lo estoy tomando en cuenta)
      // El error anterior se corrige usando UNIQUE en la BD para el email e IGNORE.
      // Con IGNORE ya no regañar (eleva una excepción en la consulta) si ya hay email duplicado.
         /*
         $conexion->query("
            INSERT IGNORE INTO 
               Usuario (nombre, email) 
            VALUES 
               ('$nombre', '$email')
         ");
         */
?>