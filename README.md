# Chat UAM

## Tabla de Contenidos

- [version01-index.php_vulnerabilidades](#version01-index.php_vulnerabilidades)
- [version02-index.html_ajax-recibir](#version02-index.html_ajax-recibir)
- [version03-ajax-enviar-recibir](#version03-ajax-enviar-recibir)

<br>

  ## version01-index.php_vulnerabilidades
*Tiene mutiples vulnerabilidades como:*
1) La posibilidad de ejecutar directamente el script install.php, lo que produce que la BD se reinicie.
2) La posibilidad de ejecutar directamente el script sent.php, lo que puede llegar a producir el envió de mensajes vacíos en caso de que en sent.php no se haga uso de la función **isset()**.
3) La posibilidad de inyectar código (Cross-site scripting (XSS)), razón por la cual se hizo uso de la función **htmlspecialchars()** al momento de recibir la entrada del formulario y mandarla a la BD (en sent.php, para la version02).

*Desventajas:*
1) index.php.
2) <?php include 'backend/load.php' ?> provoca que la pagina tenga que recargarse constantemente para ver el contenido añadido.
3) action="backend/sent.php" provoca que al momento de mandar un mensaje, se dirija a una nueva pestaña vacía (que solo procesa el contenido). Esto se soluciona si index.php fuera el mismo que procesará el formulario, pero sigue siendo algo no deseado.

<br>

  ## version02-index.html_ajax-recibir
*Se agregó la opción de recibir JSON desde load.php hacia index.**html** mediante AJAX:*
1) La carga de los mensajes de la base de datos hacia index.html ya no se hace mediante **<?php include 'backend/load.php' ?>**, sino através del **onload="carga()"** en el body del index, razón por la cual ya no necesita ser .php y pasa a ser **index.html**.
2) **load.php** envia los mensajes al html haciendo uso de **echo json_encode($arr);**.
3) La función **carga()** recibe el contenido y lo interpreta como JSON, para poder ser agregado al html mediante appendChild

*Desventajas:*
1) Se dificulta la futura modificación de la estructura al no hacer uso de **template** en el html para colocar el contenido del JSON recibido, por lo que para la version03 ya se hace uso.
2) Aún no se corrige el problema de que al enviar un nuevo mensaje, el procesamiento del formulario se hace mediante **action**.

<br>

  ## version03-ajax-enviar-recibir
*Se agregó la opción de enviar de manera asíncrona los datos el formulario hacia sent.php mesiange AJAX:*
1) Se hace uso de **template** en index.html para facilitar agregar el contenido recibido desde php. **template** NO se muestra al inicio en el html, es como tener un cacho de html que se ocupará en un futuro.
2) **htmlspecialchars** ya es necesario debido a que el textContent se encarga de evitar las inyecciones. El la version02 se corregía que **sent.php** pudiera inyectar código gracias al **htmlspecialchars**, sin embargo, si en la BD por alguna razón ya hubiera código HTML y al procesarlo no se hiciera con textContent entonces las inyecciones seguirían (por los menos inyectar etiquetyas HTML, ya que los script no se ejecutarían).
3) Al consultar la BD, se puede apreciar que al hacer uso de **htmlspecialchars** no se guarda tal cual el HTML sino que se guardan las entidades html.
4) En general no debería ser problema guardar HTML en la BD, siempre y cuando NO se pegue en el propio  HTML.
5) **sent.php** ya no será quien regañe al usuario, ahora solo se encarga de mandarle la respuesta al html y este decidirá como regañar al usuario.

*Desventajas*
1) Se pueden agregar múltiples mensajes desde la consola del desarrollador y así saturar el servidor. Esto se logra abriendo la seccción 'Elementos' en las DevTools  y colocandole un id al formulario; posteriormente, en la sección 'Consola' se crea un for invocando a la función enviar('idFormulario').

<br>

  ## version04-sesion

quien debe de controlar que el mensaje no vaya vacio?
los mensajes de usuario1 no aparecen de inmediato al usuario2