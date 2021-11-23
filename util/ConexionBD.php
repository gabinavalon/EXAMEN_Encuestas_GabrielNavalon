<?php
/**
 * Clase con conexion a la base de datos
 *
 * @author Gabriel Navalón
 */
class ConexionBD {
    
    public static function conectar(): mysqli{
        $conn = new mysqli('localhost','root','','encuestas');
        if($conn->connect_error){
            die("Error al conectar con MySQL: " . $conn->error);
        }
        return $conn;
    }
}

