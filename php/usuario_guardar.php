
<?php     
    require_once "main.php";

    # Guardar datos
    $nombre=limpiar_cadena($_POST['usuario_nombre']);
    $apellido=limpiar_cadena($_POST['usuario_apellido']);
    $usuario=limpiar_cadena($_POST['usuario_usuario']);
    $email=limpiar_cadena($_POST['usuario_email']);
    $clave1=limpiar_cadena($_POST['usuario_clave_1']);
    $clave2=limpiar_cadena($_POST['usuario_clave_2']);

    # Verificar campos obligatorios

    if($nombre=="" || $apellido=="" || $usuario=="" || $clave1 =="" || $clave2==""){
    echo '<div class="notification is-danger is-light">
                <strong> Ocurrió un error inesperado!!!</strong><br>
                Debres completar todos los campos obligatorios.
            </div>';
        exit();
    }

    # Verificar integridad de los datos
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){
        echo '<div class="notification is-danger is-light">
                <strong> Ocurrió un error inesperado!!!</strong><br>
                El nombre contiene caracteres no permitidos.
            </div>';
        exit();
    }
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){
        echo '<div class="notification is-danger is-light">
        <strong> Ocurrió un error inesperado!!!</strong><br>
        El apellido contiene caracteres no permitidos.
        </div>';
        exit();
    }
    if(verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)){
        echo '<div class="notification is-danger is-light">
                <strong> Ocurrió un error inesperado!!!</strong><br>
                El usuario contiene caracteres no permitidos.
            </div>';
        exit();
    }
    if(verificar_datos("[a-zA-Z0-9\$@.\-]{7,100}", $clave1) || verificar_datos("[a-zA-Z0-9\$@.\-]{7,100}", $clave2) ){
        echo '<div class="notification is-danger is-light">
                <strong> Ocurrió un error inesperado!!!</strong><br>
                La clave no coincide con el formato solicitado.
            </div>';
        exit();
    }

    # Verificar email
    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=db_connect();
            $check_email=$check_email->query("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
            if($check_email->rowCount()>0){
                echo '<div class="notification is-danger is-light">
                        <strong> Ocurrió un error inesperado!!!</strong><br>
                        El email ingresado ya esta registrado!
                      </div>';
                exit();
            }
            $check_email=null;
        }else{
            echo '<div class="notification is-danger is-light">
                    <strong> Ocurrió un error inesperado!!!</strong><br>
                    El email ingresado no es válido!
                </div>';
             exit();
        }
    }
    
    # Validar usuario

    $check_usuario=db_connect();
    $check_usuario=$check_usuario->query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
    if($check_usuario->rowCount()>0){
        echo '<div class="notification is-danger is-light">
                <strong> Ocurrió un error inesperado!!!</strong><br>
                El ususario ingresado ya existe, elija otro
                </div>';
        exit();
    }
    $check_email=null;

    # Verificar contraseñas
    if($clave1 != $clave2){
        echo '<div class="notification is-danger is-light">
        <strong> Ocurrió un error inesperado!!!</strong><br>
        Las claves no coinciden
        </div>';
    exit();
    }else{
        $clave=password_hash($clave1, PASSWORD_BCRYPT, ["cost"=>10]);
    }

    # Guardar datos en BD
    # Utilizar metodo prepare() para evitar SQL injection
    $guardar_usuario=db_connect();
    $guardar_usuario=$guardar_usuario->prepare("INSERT INTO usuario (usuario_nombre,usuario_apellido,usuario_usuario,usuario_clave,usuario_email)
    VALUES (:nombre,:apellido,:usuario,:clave,:email)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":apellido"=>$apellido,
        ":usuario"=>$usuario,
        ":clave"=>$clave,
        ":email"=>$email
    ];
    
    $guardar_usuario->execute($marcadores);

    if($guardar_usuario->rowCount()==1){
        echo '<div class="notification is-success is-light">
        <strong> Registro Exitoso!!!</strong><br>
        El usuario se registro correctamente
        </div>';
    }else{
        echo '<div class="notification is-danger is-light">
        <strong> Ocurrió un error inesperado!!!</strong><br>
        No se pudo registrar el usuario, verifique los datos e intente nuevamente...
        </div>';
    }
    $guardar_usuario=null;

    # Metodo tradicional
    //$guardar_usuario=$guardar_usuario->query("INSERT INTO usuario (usuario_nombre,usuario_apellido,usuario_usuario,usuario_clave,usuario_email)
    //VALUES ('$nombre','$apellido','$usuario','$clave','$email')");
?>