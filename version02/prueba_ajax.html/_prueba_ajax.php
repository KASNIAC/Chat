<?php
   $persona = [
      'nombre' => 'Alexis',
      'edad' => 24,
      'hobby' => 'Ser el mejor',
      'mascotas' => [
         'perrito', 'gatito', 'cerdito'
      ]
   ];

   // FORMATO JSON: La función json_encode toma una variable PHP y regresa una cadena.
   // Esa cadena denota la información que tenía la variable. (Similar a un to_string)
   echo json_encode($persona);
  

   // innerHTML vs textContent
   // echo "<h1> innerHTML vs textContent </h1>"; 
   // echo "PERRO LOCO"; 
?>