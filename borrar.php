<?php

session_start(); //Permite utilizar variables de sesión

require 'modelos/Voto.php';
require 'modelos/Candidato.php';
require 'DAO/VotoDAO.php';
require 'DAO/CandidatoDAO.php';
require 'util/MensajesFlash.php';
require 'util/Sesion.php';
require 'util/ConexionBD.php';

$conn = ConexionBD::conectar();

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$canDAO = new CandidatoDAO($conn);
$candidato = $canDAO->obtener_id($id);
$foto = $candidato->getFoto();
unlink("imagenes/$foto");

if ($canDAO->borrar($candidato)) {
        MensajesFlash::anadir_mensaje("Candidato borrado");
        unlink("imagenes/");
    } else {
        MensajesFlash::anadir_mensaje("El candidato no se ha podido borrar");
    }

header("Location: index.php");