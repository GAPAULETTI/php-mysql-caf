<?php

    $user_id_del=limpiar_cadena($_GET['user_id_del']);

    $check_usuario=db_connect();

    $check_usuario=$check_usuario->query("SELECT usuario_id FROM usuario WHERE usuario_id='$user_id_del'");

    if($check_usuario->rowCount()==1){

        $check_producto=db_connect();
        $check_producto= $check_producto->query("SELECT usuario_id FROM producto WHERE usuario_id='$user_id_del' LIMIT 1");

        if($check_producto->rowCount()<=0){
            
            $eliminar_usuario=db_connect();
            $eliminar_usuario= $eliminar_usuario->prepare("DELETE FROM usuario WHERE usuario_id=:id");

            $eliminar_usuario->execute([":id"=>$user_id_del]);

            if($eliminar_usuario->rowCount()==1){
                echo '<div class="notification is-success is-light">
                <strong>Usuario eliminado correctamente..</strong>
                </div>';

            }else{
                echo '<div class="notification is-danger is-light">
                <strong> Ocurrió un error inesperado!!!</strong><br>
                El usuario no se pudo eliminar..
                </div>';

            }
        }else{
            echo '<div class="notification is-danger is-light">
                <strong> Ocurrió un error inesperado!!!</strong><br>
                El usuario que intenta eliminar tiene productos asociados..
                </div>';
        }

    }else{
        echo '<div class="notification is-danger is-light">
        <strong> Ocurrió un error inesperado!!!</strong><br>
        El usuario que intenta eliminar no existe..
        </div>';
    }
    $check_usuario=null;
