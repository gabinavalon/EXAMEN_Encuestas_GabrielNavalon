<?php


/**
 * Clase para manejo de sesiones 
 *
 * @author Gabriel Navalón Soriano
 */
class Sesion {
    static public function iniciar($id){
        $_SESSION['id_usuario_sesion']=$id;
    }
    
    static public function existe() {
        return isset($_SESSION['id_usuario_sesion']);
    }
    
    static public function cerrar(){
        unset($_SESSION['id_usuario_sesion']);
    }
    
    /**
     * Devuelve el id del usuario conectado o false si no ha iniciado sesión
     * @return boolean
     */
    static public function obtener(){
        if(isset($_SESSION['id_usuario_sesion']))
            return $_SESSION['id_usuario_sesion'];
        else
            return false;
    }
}
