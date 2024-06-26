# Chat UAM

## Tabla de Contenidos

- [version01-index.php_vulnerabilidades](#version01-index.php_vulnerabilidades)
- [version02-index.html_ajax-recibir](#version02-index.html_ajax-recibir)
- [version03-ajax-enviar-recibir](#version03-ajax-enviar-recibir)
- [version04-sesion](#version04-sesion)
- [version05-sesion-avanzado](#version05-sesion-avanzado)
- [version06-login](#version06-login)
- [version07-login-continuación](#version07-login-continuación)
- [version08](#version08)
- [Cuestiones](#Cuestiones)

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
6) **__DIR__** en los archivos PHP ya no es necesario, puesto que ya se separarón del del html.

*Desventajas:*
1) Se pueden agregar múltiples mensajes desde la consola del desarrollador y así saturar el servidor. Esto se logra abriendo la seccción 'Elementos' en las DevTools  y colocandole un id al formulario; posteriormente, en la sección 'Consola' se crea un for invocando a la función enviar('idFormulario').


<br>


  ## version04-sesion
*Uso de cookies y sesiones*
1) Al contar ahora con sesiones y manejo de cookies, ya no es posible que de manera inmediata puedan agregar muchos mensajes desde las DevTools.
2) Una cookie se produce para detectar en que momento un usuario ha mandado su último mensaje y poder evitar que vuelva a mandar otro hasta dentro de 10 segundos.

*Desventajas:*
1) Aún es posible insertar múltiles mensajes, haciendo uso de **curl_init()**, la cual podriamos pensar que de constante "resetea la cookie". Una manera de solucionar este problema es hacer uso de la IP para evitar que un usuairo en una IP mande mas de dos mensajes al mismo tiempo, el problema que surge entonces es cuando dos usuarios esten en la misma IP. 
2) No se usó **sesion_name()**, detalle menor pues en este caso solo se cuenta con un servicio (enviar mensajes).


<br>


  ## version05-sesion-avanzado
*Se agregan pequeños cambios en **sent.php**, como el uso de **sesion_id()**, **sesion_name()**; **die()** en lugar de echo; **empyt()** en lugar de isset debido a que ya se usa **session_name()**.*
1) Se puede observar que SÍ hay colisión si se ejectua **sesion.php** desde **/version05-sesion-avanzado/_1_prueba_sesion** y luego desde **/version04-sesion/_1_prueba_sesion** ya que la cookie esta siendo compartida (las cookies son por dominio). Esto se solucionaría agregando un **session_name()**.

*Desventajas:*
1) **/_hack/hack.php** contiene el script que explota la vulnerabilidad mencionada en el apartado anterior (usando **curl_init()**). Para solucionar esta vulnerabilidad es necesario hacer uso de un login que permita identificar a un usuario, a partir de la base de datos.


<br>


  ## version06-login
*Se presenta una introducción sobre el uso de login usando la API de Google*


<br>


  ## version07-login-continuación
*Notas*
1) Es importante tener en cuenta que pueden ocurrir condiciones de carrera a la hora de hacer consultas en la BD, por lo que la BD debería ser la que se encargue de controlar dichas consultas (Por ejemplo, si se hace login al mismo tiempo con el mismo correo y la BD no tiene un mecanismo para evitar correos duplicados entonces no bastaría con que el PHP controle eso, la BD debería de poder evitar dichas inserciones. Lo mismo para el envío de mensajes).
2) La consistencia es importante. Si devuelvo json en un php entonces sería preferible devolverlo en todos.
3) Las consulas de los archivos **\*_viejo.php** se pueden hacer mucho mas cortas y corrigen las condiciones de carrera, tal y como se muestra en los archivos **\*_sin_id.php**.
4) Fue necesario guardar el id que ocupa dicho usuario en la BD en la SESSION para facilitar las consultas que se hacen desde **sent.php**. Los archivos **\*_sin_id.php** corresponden a como se hacían esas consultas antes de guardar el id en la sesión.


<br>


  ## version08
*Se hace uso de la biblioteca db_access*
->fetch_assoc() se cambia por ->[0]

<br>


 # Cuestiones
1) ¿Quién debe de controlar que el mensaje no vaya vacío?
**R.-** tanto el front como el back

2) Actualmente, cuando un usuario manda un mensaje, no aparece de inmediato a los demás, ¿Cómo se soluciona?
**R.-** [existen varias formas](https://rxdb.info/articles/websockets-sse-polling-webrtc-webtransport.html)

3) ¿Un mismo arhcivo PHP puede tener varias sesiones (varios **session_name()**  **session_start()**)?
**R.-** Sí, siempre y cuando se use **session_write_close()**. NO se recomienda hacerlo.

4) ¿Se debe de tener una sesion (SESSION_NAME) para el login, y otra para el envio de mensajes?
**R.-** En una misma aplicación, cada script debe hacer **session_start**, pero el nombre de sesión pasado a **session_name()** debe coincidir. Diferentes aplicaciones deben tener diferentes nombres de sesión.

5) Para el caso de los mensajes sí se puede controlar que no spameen (haciendo uso de session_id), pero no se puede controlar que un usuario se logee multiples veces (eso lo tendria que controlar en todo caso Google), correcto?
**R.-** Sí. Recordar que el spam de mensajes se corregirá ahora a partir de la fecha en la que se envió el último mensaje.

6) ¿Cual era el campo de verificacion en caso de que dos correos se asocien con personas diferentes?
**R.-** $resultado['sub']

7) ¿Puedo mandar a veces JSON y a veces cadenas?
**R.-** Sí, pero es un caos. Mejor mandar siempre JSON. Cuando se hace **json_encode**, lo que se produce es la representacion de como se hubiera escrito ese valor en código de JS.

8) La funcion inicia_sesion 
  - sin argumento: (hola, me recuerdas o no?) NO PASA EL COMPROBANTE
  - con argumento: google llama a la funcion (hola, traigo este comprobante) SI PASA EL COMPROBANTE

9) ¿Qué pasa si tengo dos archivos .php con el mismo session_name() ? 
**R.-** Simplemente se comparte la sesion.

10) ¿Pueden ocurrir condiciones de carrera por dos sesiones abiertas en la misma cuenta, pero en dispositivos diferentes?
**R.-** Sí. Es importante que la BD cuente con los mecanismos para evitar eso.


<br>


Importante:
**CONSITENCIA (No andar devolviendo cadenas y json)**

**';' no es necesario si no es multiquery**
**Se puede hacer un INSERT directamente desde un SELECT**
**La comunicacion interproceso es lenta(PHP y MySQL)**
**UPDATE actualiza la fila, REPLACE mata la fila y luego la actualiza**

**EXISTS se considera verdadero si el SELECT tiene al menos algo (alguna fila)**
**También existe NOT EXISTS (lo contrario)**