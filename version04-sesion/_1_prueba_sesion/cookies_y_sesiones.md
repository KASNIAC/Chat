**----- Cookies y sesiones en PHP -----**
- Una cookie es una colección de parejas (clave->valor).
- Cuando PHP crea una sesión, pone en la cookie la pareja (phpsessid->id).
- Las cookies son por dominio (cada dominio tiene su propia lista de parejas).
- La función **setcookie()** te permite mandarle parejas extras al navegador.

- Cada vez que el navegador vuelve a entrar a una página del dominio, le va a mandar al servidor todas las parejas que el servidor en algún momento le compartió.
- Ojo: esas parejas (clave->valor) NO son las que guarda $_SESSION.
- Los datos guardados en $_SESSION se almacenan en un archivo del servidor con algún id; la cookie trae en phpsessid ese id, pero los datos de $_SESSION se quedan en el archivo del servidor.
- Es como si $_SESSION fuera una mini base de datos para el usuario, y lo que le mandas al usuario en la cookie son los datos de login de la mini bd, pero como la mini db está en el servidor el usuario debe enviarle al servidor el login y el password en cada acceso para que el servidor pueda vincular al usuario con esa mini db.
- Lo anterior también puede originar problemas de seguridad en algunas circunstancias, por ejemplo: si tu lograras adivinar el id de $_SESSION de otro usuario, podrías fabricar una cookie con ese dato y hacerte pasar por ese usuario ante el servidor.
