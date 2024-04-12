

document.addEventListener('DOMContentLoaded', function() {
   // Obtener el botón
   var boton = document.getElementById('button-send');

   // Función para manejar el evento al presionar la tecla Enter
   function handleEnterKey(event) {
       // Verificar si la tecla presionada es Enter (código 13)
       if (event.keyCode === 13) {
           // Simular clic en el botón
           boton.click();
       }
   }

   // Agregar el evento keydown al documento para detectar la tecla Enter
   document.addEventListener('keydown', handleEnterKey);
});

function prueba() {
   console.log("Hola mundo")
}