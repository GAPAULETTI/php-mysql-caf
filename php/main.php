<?php
    # Conexión a base de datos
    function db_connect(){
        $pdo = new PDO('mysql:host=localhost;dbname=inventario','root','root');
        return $pdo;
    }

    # Verificar Datos
    function verificar_datos($filtro, $cadena){

        if(preg_match("/^.$filtro./", $cadena)){
            return false;
        }else{
            return true;
        }
    }

    # Limpiar cadenas de texto (Evitar SQL injection)
    function limpiar_cadena($cadena){
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        $cadena=str_ireplace("<script>","",$cadena);
        $cadena=str_ireplace("</script>","",$cadena);
        $cadena=str_ireplace("<script src>","",$cadena);
        $cadena=str_ireplace("<script type=>","",$cadena);
        $cadena=str_ireplace("SELECT * FROM","",$cadena);
        $cadena=str_ireplace("DELETE FROM","",$cadena);
        $cadena=str_ireplace("INSERT INTO","",$cadena);
        $cadena=str_ireplace("DROP TABLE","",$cadena);
        $cadena=str_ireplace("DROP DATABASE","",$cadena);
        $cadena=str_ireplace("TRUNCATE TABLE","",$cadena);
        $cadena=str_ireplace("SHOW TABLES;","",$cadena);
        $cadena=str_ireplace("SHOW DATABASES;","",$cadena);
        $cadena=str_ireplace("<?php","",$cadena);
        $cadena=str_ireplace("?>","",$cadena);
        $cadena=str_ireplace("--","",$cadena);
        $cadena=str_ireplace("^","",$cadena);
        $cadena=str_ireplace("<","",$cadena);
        $cadena=str_ireplace("[","",$cadena);
        $cadena=str_ireplace("]","",$cadena);
        $cadena=str_ireplace("==","",$cadena);
        $cadena=str_ireplace(";","",$cadena);
        $cadena=str_ireplace("::","",$cadena);
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);

        return $cadena;
        
    }

    # Renombrar fotos
    function renombrar_fotos($nombre){
        $nombre=str_ireplace(" ","_", $nombre);
        $nombre=str_ireplace("/","_", $nombre);
        $nombre=str_ireplace("#","_", $nombre);
        $nombre=str_ireplace("-","_", $nombre);
        $nombre=str_ireplace("$","_", $nombre);
        $nombre=str_ireplace(".","_", $nombre);
        $nombre=str_ireplace(",","_", $nombre);
        $nombre=$nombre."_".rand(0,100);

        return $nombre;
    }

    # Funcion paginador de tablas
    function paginador_tablas($pagina,$Npaginas,$url,$botones){
        $tabla='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';
        if($pagina<=1){
            $tabla.='
                    <a href="#" class="pagination-previous is-disabled" disabled>Anterior</a>
                    <ul class="pagination-list">';
        }else{
            $tabla.='
                    <a href="'.$url.($pagina-1).'" class="pagination-previous">Anterior</a>
                    <ul class="pagination-list">
                    <li><a href="'.$url.'1" class="pagination-link">1</a></li>
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                    ';
        }

        $ci=0;
        for($i=$pagina; $i<=$Npaginas;$i++){

            if($ci>=$botones){
                break;
            }

            if($pagina==$i){
                $tabla.='<li><a href="'.$url.$i.'" class="pagination-link is-current">'.$i.'</a></li>';
            }else{
                $tabla.='<li><a href="'.$url.$i.'" class="pagination-link is-current">'.$i.'</a></li>';
            }
            $ci++;
        }


        if($pagina==$Npaginas){
            $tabla.='
                    </ul>
                    <a class="pagination-next is-disabled" disabled >Siguiente</a>
                    ';
        }else{
            $tabla.='
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                    <li><a href="'.$url.$Npaginas.'" class="pagination-link">'.$Npaginas.'</a></li>
                    </ul>
                    <a href="'.$url.($pagina+1).'" class="pagination-next">Siguiente</a>
                    ';
        }
        $tabla.='</nav>';
        
        return $tabla;

    }

    //$pdo->query("INSERT INTO categoria(categoria_nombre, categoria_ubicacion) VALUES('limpieza', 'deposito')");
?>