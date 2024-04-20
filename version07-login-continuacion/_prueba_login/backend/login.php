<?php
   require_once('libraries/vendor/autoload.php');
   
   if (isset($_POST['comprobante'])) {
      $cliente = new Google_Client([ 'client_id' => '330917364178-utl74obou3uhk4ttk86tu0jlbnod1dev.apps.googleusercontent.com' ]);
      $cliente->setHttpClient(new \GuzzleHttp\Client([ 'curl' => [ CURLOPT_SSL_VERIFYPEER => false ] ]));
      // CURLOPT_SSL_VERIFYPEER => false : potencialmente es una mala practica; en caso de hackeo de red o de que hackeen a google habría problemas.
      $resultado = $cliente->verifyIdToken($_POST['comprobante']);
      if ($resultado == false) {
         die('error-comprobante');
      } else {
         die("{$resultado['email']} {$resultado['name']}");
      }
   } else {
      die('sin-comprobante');
   }
?>