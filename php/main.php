<?php
    # Conexión a base de datos
    function db_connect(){
        $pdo = new PDO('mysql:host=localhost;dbname=inventario','root','root');
        return $pdo;
    }

    //$pdo->query("INSERT INTO categoria(categoria_nombre, categoria_ubicacion) VALUES('limpieza', 'deposito')");
?>