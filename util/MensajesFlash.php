<?php

/**
 * Mensajes flash para notificar errores durante el funcionamiento de la aplicación
 *
 * @author Gabriel Navalón Soriano
 */
class MensajesFlash {

    static public function anadir_mensaje($mensaje) {
        $_SESSION['mensajes_flash'][] = $mensaje;
    }

    static public function imprimir_mensajes() {
        if(isset($_SESSION['mensajes_flash'])) {
            foreach($_SESSION['mensajes_flash'] as $mensaje_flash){
                print '<div class="error">' . $mensaje_flash . '</div>';
            }
            unset($_SESSION['mensajes_flash']);
        }
    }

}
