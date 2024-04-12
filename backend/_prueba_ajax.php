<?php
   $persona = [
      'nombre' => 'Alexis',
      'edad' => 24,
      'hobby' => 'Ser el mejor',
      'mascotas' => [
         'perrito', 'gatito', 'cerdito'
      ]
   ];

   echo "hola mundo\n";
   echo json_encode($persona), "\n";
   echo "adios mundo\n";
?>