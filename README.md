# api_fetch_sistema_login_token
 ## Sistema de login con crud y API rest
 ### Realizado en javascript, bootstrap, php y mysql
 ### Tiene los endpoint para postman
 #### Algunas de las características que presenta son:

Se utiliza una base de datos MySQL para almacenar los datos de los usuarios.
Se utiliza la extensión mysqli para conectarse a la base de datos y realizar consultas preparadas.
Se utiliza la función session_start() para manejar sesiones de usuario.
La API define dos endpoints: uno para verificar si un usuario está autenticado y otro para resetear el password de un usuario y enviarle un correo electrónico.
Para manejar las solicitudes GET y POST se utiliza la variable global $_SERVER y la clave PATH_INFO.
Para enviar respuestas al cliente se utiliza la función json_encode().
Se valida la dirección de correo electrónico proporcionada por el usuario antes de procesarla y se utiliza la función filter_var() para sanitizar los datos recibidos.
