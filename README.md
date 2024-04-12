# Chat UAM

## Tabla de Contenidos

- [version01-index.php_vulnerabilidades](#version01-index.php_vulnerabilidades)
- [version-02](#version02)

<br>

  ## version01-index.php_vulnerabilidades
Tiene mutiples vulnerabilidades como: 

	1) La posibilidad de ejecutar directamente el script install.php, lo que produce que la BD se reinice.
 
	2) La posibilidad de ejecutar directamente el script sent.php, lo que puede llegar a producir el envió de mensajes vacíos en caso de que en sent.php no se haga uso de la función **isset()**.
 
	3) La posibilidad de inyectar código (Cross-site scripting (XSS)), razón por la cual se hizo uso de la función **htmlspecialchars()** al momento de recibir la entrada del formulario y mandarla a la BD.

Malas practicas:

	1) index.php.
 
	2) <?php include 'backend/load.php' ?> provoca que la pagina tenga que recargarse constantemente para ver el contenido añadido.
 
	3) action="backend/sent.php" provoca que al momento de mandar un msj, se diriga a una nueva pestaña vacia (que solo procesa el contenido). Esto se soluciona si index.php fuera el mismo que procesará el formulario, pero sigue siendo algo no deseado.

<br>

  ## version02
