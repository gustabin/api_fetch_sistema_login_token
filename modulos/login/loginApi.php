<?php
session_start();
// header('Access-Control-Allow-Origin: *'); // cualquier origen
// Configuración de la base de datos
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "usuario";

// Conexión a la base de datos
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Si hay un error en la conexión, muestra el mensaje y detiene la ejecución del script
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Endpoint para verificar si el usuario está autenticado
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['PATH_INFO'] === '/verificar') {    
    // Obtiene el token de autenticación del encabezado de la petición    
    $headers = apache_request_headers();
    $authorization_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
    
    // Extraer el token del encabezado
    list($token) = sscanf($authorization_header, 'Bearer %s');    
    // $token ahora contiene el valor del token    

    // Consulta a la base de datos para verificar si el token es válido
    $query = "SELECT * FROM user WHERE token = '$token' LIMIT 1";
    $result = $conn->query($query);

    // Si el token no es válido, regresa un error
    if ($result->num_rows === 0 OR $token == NULL) {
        // http_response_code(401);
        $data = array("error" => '1', 'mensaje' => 'Token inválido');
        die(json_encode($data));
    }
    // Obtiene los datos del usuario de la base de datos
    $user = $result->fetch_assoc();

    // Regresa un mensaje de prueba al cliente
    // echo json_encode(array('message' => 'Hola, ' . $user['nombre'] . '!'));
    $data = array(
        "exito" => '1', 
        "mensaje" => 'Hola, ' . $user['nombre'] . '!',
        "nombre" => $user['nombre'],
        "correo" => $user['correo']
    );
    die(json_encode($data));
}

// Endpoint para resetear el password y enviar un correo al usuario 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['PATH_INFO'] === '/resetear') { 
    $correo = strtolower($_GET['correoRecuperar']);

    $validaemail = preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_GET['correoRecuperar']);

    if ($validaemail == 0) {
        $data = array("error" => '3');
        die(json_encode($data));
    }

    if (empty($correo)) {
        $data = array("error" => '2');
        die(json_encode($data));
    }

    // Sanitizar los datos recibidos
    $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);

    // Validar email 
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        // El correo no es válido
        $data = array("error" => '3');
        die(json_encode($data));
    }

    $sql = "SELECT * FROM user WHERE correo='$correo'";
   
    $result = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_array($result)) {
        $nombre = utf8_encode($data['nombre']);
        $id = $data['id'];
        $password = "passwordProvicional"; 

        // Creamos una nueva contraseña y Hasheamos antes de almacenarla en la base de datos
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        //actualizamos el password en el registro del usurio
        $query = "UPDATE user SET password = '$password_hashed' WHERE id = " . $id;
        $conn->query($query);

        // $claveDesencriptada = SED::decryption($clave);
        // $clave = $claveDesencriptada;

        $destino = "gustabin@yahoo.com";
        $asunto = "Solicitud de clave del sistema";
        $cuerpo = "<h2>Hola, un usuario esta recuperando el password en el carrito!</h2>
            Hemos recibido la siguiente información:<br>	
            <b>Usuario: </b> $nombre <br>	
            <b>Correo: </b> $correo<br>	
            <br><br>
            <br>
            El equipo de carrito de compras.<br>
            <img src=https://www.gustabin.com/img/logoEmpresa.png height=50px width=50px />
            <a href=https://www.facebook.com/gustabin2.0>
            <img src=https://www.gustabin.com/img/logoFacebook.jpg alt=Logo Facebook height=50px width=50px></a>
            <h5>Desarrollado por Gustabin<br>
            Copyright © 2021. Todos los derechos reservados. Version 1.0.0 <br></h5>
            ";

        $yourWebsite = "gustabin.com";
        $yourEmail = "info@gustabin.com";
        $cabeceras = "From: $yourWebsite <$yourEmail>\n" . "Reply-To: cuentas@gustabin.com" . "\n" . "Content-type: text/html";

        mail($destino, $asunto, $cuerpo, $cabeceras);

        $destino = $correo;
        $asunto = "Recuperación de password del sistema web";
        $cuerpo = "<h2>Apreciado cliente, </h2> $nombre <br>
            Hemos recuperado los datos solicitados. <br><br>
            Su password es: $password<br>
            Su usuario es: $correo<br><br><br>
            Gracias por confiar en nosotros.
            <br>
            El equipo de carrito de compras.<br>
            <img src=https://www.gustabin.com/img/logoEmpresa.png height=50px width=50px />
            <a href=https://www.facebook.com/gustabin2.0>
            <img src=https://www.gustabin.com/img/logoFacebook.jpg alt=Logo Facebook height=50px width=50px></a>
            <h5>Desarrollado por Gustabin<br>
            Copyright © 2021. Todos los derechos reservados. Version 1.0.0 <br></h5>
            ";

        $yourWebsite = "gustabin.com";
        $yourEmail = "info@gustabin.com";
        $cabeceras = "From: $yourWebsite <$yourEmail>\n" . "Reply-To: cuentas@gustabin.com" . "\n" . "Content-type: text/html";

        mail($destino, $asunto, $cuerpo, $cabeceras);
        $data = array(
            "exito" => '1',
            "nombre" => $nombre,
            "correo" => $correo
        );
        die(json_encode($data));
    };
    mysqli_close($conn);
    $data = array(
        "error" => '1'
    );
    die(json_encode($data));
}

// Endpoint para crear un usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['PATH_INFO'] === '/') {
    $correo = $_POST['emailIncluir'];
    $nombre = $_POST['nombreIncluir'];
    $password = $_POST['passwordIncluir'];
    $retipearPassword = $_POST['retipearPassword'];

    if ($password != $retipearPassword) {
        $data = array("error" => '6', "mensaje" => 'El campo password y el campo reescribir password no son iguales!');
        die(json_encode($data));
    }

    //Validar con preg_match
    $validaemail = preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $correo);
    $validaPassword = preg_match("#.*^(?=.{8,20})(?=.*[a-z]).*$#", $password);
    $validaRetipearPassword = preg_match("#.*^(?=.{8,20})(?=.*[a-z]).*$#", $retipearPassword);

    if ($validaemail == 0) {
        $data = array("error" => '2', "mensaje" => 'Email invalido!');
        die(json_encode($data));
    }

    if ($validaPassword == 0) {
        $data = array("error" => '3');
        die(json_encode($data));
    }

    if ($validaRetipearPassword == 0) {
        $data = array("error" => '5');
        die(json_encode($data));
    }

    if (empty($correo) or empty($nombre) or empty($password) or empty($retipearPassword)) {
        $data = array("error" => '4', "mensaje" => 'Debe completar todos los datos!');
        die(json_encode($data));
    }

    // Hasheamos la contraseña antes de almacenarla en la base de datos
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `user` (`id`, `nombre`, `correo`, `password`) 
    VALUES (NULL, '$nombre', '$correo', '$password_hashed')";

    try {
        if (mysqli_query($conn, $sql)) {
            $data = array("exito" => '1', "mensaje" => 'Usuario registrado con exito!');
            mysqli_close($conn);
            die(json_encode($data));
        } else {
            $data = array("error" => '1');
            die(json_encode($data));
        }
    } catch(mysqli_sql_exception $e) {
        $error = array("error" => '1', "mensaje" => $e->getMessage(), "numero_error" => $e->getCode());
        die(json_encode($error));
    }    
}

// Endpoint para la autenticación de un usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['PATH_INFO'] === '/auth') {
    // Obtiene los datos del formulario
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    if ($password == "passwordProvicional") {
        $data = array("error" => '2', 'mensaje' => 'Tienes que cambiar el password', 'correo' => $correo);
        die(json_encode($data));
    }
    
    // Consulta a la base de datos para verificar si el usuario existe
    $query = "SELECT * FROM user WHERE correo = '$correo' LIMIT 1";
    $result = $conn->query($query);
    
    // Si no se encuentra al usuario, regresa un error
    if ($result->num_rows === 0) {
        $data = array("error" => '1', 'mensaje' => 'Usuario no encontrado');
        die(json_encode($data));
    }
    
    // Obtiene los datos del usuario de la base de datos
    $user = $result->fetch_assoc();

    // Verifica si la contraseña es correcta
    if (!password_verify($password, $user['password'])) {
        $data = array("error" => '1', 'mensaje' => 'Contraseña incorrecta');
        die(json_encode($data));
    }

    // Genera un token de autenticación para el usuario
    $token = bin2hex(random_bytes(32));

    // Guarda el token en la base de datos
    $query = "UPDATE user SET token = '$token' WHERE id = " . $user['id'];
    $conn->query($query);

    // Regresa el token al cliente
    $data = array("exito" => '1', 'token' => $token);
    die(json_encode($data));
}

// Endpoint para cambiar el password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['PATH_INFO'] === '/cambiar') {
    $correo = $_POST['emailCambiarPassword'];
    $password = $_POST['passwordCambiarPassword'];
    $retipearPassword = $_POST['retipearCambiarPassword'];

    if ($password != $retipearPassword) {
        $data = array("error" => '6', "mensaje" => 'El campo password y el campo reescribir password no son iguales!');
        die(json_encode($data));
    }

    //Validar con preg_match
    $validaemail = preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $correo);
    $validaPassword = preg_match("#.*^(?=.{8,20})(?=.*[a-z]).*$#", $password);
    $validaRetipearPassword = preg_match("#.*^(?=.{8,20})(?=.*[a-z]).*$#", $retipearPassword);

    if ($validaemail == 0) {
        $data = array("error" => '2', "mensaje" => 'Email invalido!');
        die(json_encode($data));
    }

    if ($validaPassword == 0) {
        $data = array("error" => '3');
        die(json_encode($data));
    }

    if ($validaRetipearPassword == 0) {
        $data = array("error" => '5');
        die(json_encode($data));
    }

    if (empty($correo) or empty($password) or empty($retipearPassword)) {
        $data = array("error" => '4', "mensaje" => 'Debe completar todos los datos!');
        die(json_encode($data));
    }

    // Hasheamos la contraseña antes de almacenarla en la base de datos
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Guarda el token en la base de datos
    $sql = "UPDATE user SET password = '$password_hashed' WHERE correo = '" . $correo . "'";

    try {
        if (mysqli_query($conn, $sql)) {
            $data = array("exito" => '1', "mensaje" => 'Password cambiado con exito!');
            mysqli_close($conn);
            die(json_encode($data));
        } else {
            $data = array("error" => '1');
            die(json_encode($data));
        }
    } catch(mysqli_sql_exception $e) {
        $error = array("error" => '1', "mensaje" => $e->getMessage(), "numero_error" => $e->getCode());
        die(json_encode($error));
    }    
}