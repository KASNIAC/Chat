<?php
   $persona = [
      'nombre' => 'Alexis',
      'edad' => 24,
      'hobby' => 'Ser el mejor',
      'mascotas' => [
         'perrito', 'gatito', 'cerdito'
      ]
   ];

   echo json_encode($persona);
?>