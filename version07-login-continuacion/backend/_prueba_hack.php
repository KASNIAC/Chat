<?php
   for ($i = 0; $i < 100; ++$i) {
      $conexion = curl_init( );
      curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true); 
      curl_setopt($conexion, CURLOPT_SSLVERSION, 3);
      curl_setopt($conexion, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($conexion, CURLOPT_COOKIEFILE, '');
      curl_setopt($conexion, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
      curl_setopt($conexion, CURLOPT_URL, 'http://localhost/Proceso%20Chat/version07-login-continuacion/backend/sent.php');
      curl_setopt($conexion, CURLOPT_POST, true);
      curl_setopt($conexion, CURLOPT_POSTFIELDS, [ 'cuerpo' => 'has sido visitado por el hacker' ]);
      curl_exec($conexion);
   }
?>