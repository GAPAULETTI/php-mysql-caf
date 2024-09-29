
<?php     
    require_once "main.php";

    # Guardar datos
    $nombre=limpiar_cadena($_POST['usuario_nombre']);
    $apellido=limpiar_cadena($_POST['usuario_apellido']);
    $usuario=limpiar_cadena($_POST['usuario_usuario']);
    $email=limpiar_cadena($_POST['usuario_email']);
    $clave1=limpiar_cadena($_POST['usuario_clave1']);
    $clave2=limpiar_cadena($_POST['usuario_clave2']);

    # Verificar campos obligatorios

    if($nombre=="" || $apellido=="" || $usuario=="" || $clave1 =="" || $clave2==""){
    echo '  <div class="notification is-danger is-light">
                <strong> Ocurrió un error inesperado!!!</strong><br>
                Debres completar todos los campos obligatorios.
            </div>';
        exit();
    }

    # Verificar integridad de los datos
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){
        echo '  <div class="notification is-danger is-light">
                <strong> Ocurrió un error inesperado!!!</strong><br>
                El nombre contiene caracteres no permitidos.
            </div>';
        exit();
    }
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){
        echo '  <div class="notification is-danger is-light">
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
    if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave2) ){
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
    

?>