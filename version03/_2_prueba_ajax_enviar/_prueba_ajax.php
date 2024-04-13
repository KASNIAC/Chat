<?php
   if (!isset($_POST['texto'])) {
      echo 'error';
   } else {
      echo 'Recibido: ', $_POST['texto'];
   }
?>